<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\Setting;
use App\Models\SmtpSetting;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\PaymentSetting;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Helpers\MailHelper;
use App\Services\StockAlertService;
use App\Traits\LogsApiCalls;

class CheckoutController extends Controller
{
    use LogsApiCalls;

    // Inject in constructor
    public function __construct(protected StockAlertService $alertService)
    {
    }

    public function checkout()
    {
        $customer = auth('customer')->user();

        $cart = Cart::with([
            'items.product.images',
            'items.product.category',
            'items.priceVariant',
            'items.addons',
        ])
            ->where('user_id', $customer->id)
            ->first();

        if ($cart) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $customer = auth('customer')->user();

        $addresses = $customer->addresses()
            ->with(['state', 'city'])
            ->orderByDesc('is_default')
            ->get();

        $defaultAddress = $addresses->firstWhere('is_default', true);

        $states = State::orderBy('name')
            ->get();

  // Pixel/GA begin_checkout event — rendered as an inline script tag on the checkout view
        $beginCheckoutScript = \App\Services\Tracking\PixelTracker::beginCheckoutScript($cart);
        
        return view(
            'front-pages.checkout',
            compact(
                'cart',
                'customer',
                'addresses',
                'defaultAddress',
                'states',
                'beginCheckoutScript'
            )
        );
    }

    public function storeAddress(Request $request)
    {
        $customer = auth('customer')->user();

        CustomerAddress::where(
            'customer_id',
            $customer->id
        )->update([
                    'is_default' => 0
                ]);

        CustomerAddress::create([
            'customer_id' => $customer->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'country' => 'India',
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'address_type' => $request->address_type ?? 'home',
            'is_default' => 1,
        ]);

        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json([
            'success' => true
        ]);
    }


    public function changeDefaultAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:customer_addresses,id'
        ]);

        $customer = auth('customer')->user();

        CustomerAddress::where(
            'customer_id',
            $customer->id
        )->update([
                    'is_default' => 0
                ]);

        CustomerAddress::where(
            'id',
            $request->address_id
        )
            ->where('customer_id', $customer->id)
            ->update([
                'is_default' => 1
            ]);

        $cart = Cart::where(
            'user_id',
            $customer->id
        )->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json([
            'success' => true
        ]);
    }


    public function placeOrder(Request $request)
    {
        $customer = auth('customer')->user();

        $request->validate([
            'payment_method' => 'required|in:cod,razorpay',
        ]);

        $address = null;

        /*
        |--------------------------------------------------------------------------
        | Existing Address
        |--------------------------------------------------------------------------
        */

        if ($request->filled('address_id')) {

            $address = CustomerAddress::where(
                'customer_id',
                $customer->id
            )->find($request->address_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Address If Not Exists
        |--------------------------------------------------------------------------
        */

        if (!$address) {

            $request->validate([

                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required',

                'address_line_1' => 'required',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'pincode' => 'required',
            ]);

            CustomerAddress::where(
                'customer_id',
                $customer->id
            )->update([
                        'is_default' => 0
                    ]);

            $address = CustomerAddress::create([

                'customer_id' => $customer->id,

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,

                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,

                'state_id' => $request->state_id,
                'city_id' => $request->city_id,

                'pincode' => $request->pincode,

                'address_type' => 'home',

                'is_default' => 1,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Recalculate GST Using New Address
            |--------------------------------------------------------------------------
            */

            $cart = Cart::where(
                'user_id',
                $customer->id
            )->first();

            if ($cart) {

                $cart->recalculateTotals();
                $cart->refresh();
            }
        }

        $cart = Cart::with([
            'items.product',
            'items.addons',
        ])
            ->where('user_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->count() == 0) {

            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        DB::beginTransaction();

        try {

            $order = Order::create([

                'customer_id' => $customer->id,
                'address_id' => $address->id,

                'order_number' =>
                    'ORD-' . strtoupper(uniqid()),

                'customer_name' => $address->name,
                'customer_email' => $address->email,
                'customer_phone' => $address->phone,

                'address_line_1' => $address->address_line_1,
                'address_line_2' => $address->address_line_2,

                'state_id' => $address->state_id,
                'city_id' => $address->city_id,
                'pincode' => $address->pincode,

                'coupon_code' => $cart->coupon_code,

                'subtotal' => $cart->subtotal,
                'discount' => $cart->discount,
                'tax_amount' => $cart->tax_amount,
                'grand_total' => $cart->grand_total,

                'gst_type' => $cart->gst_type,

                'cgst_rate' => $cart->cgst_rate,
                'sgst_rate' => $cart->sgst_rate,
                'igst_rate' => $cart->igst_rate,

                'cgst_amount' => $cart->cgst_amount,
                'sgst_amount' => $cart->sgst_amount,
                'igst_amount' => $cart->igst_amount,

                'payment_method' => $request->payment_method,

                'payment_status' =>
                    $request->payment_method == 'cod'
                    ? 'pending'
                    : 'pending',

                'status' => 'pending',
            ]);
            
            $order->statusHistory()->create([
    'status'          => 'pending',
    'previous_status' => null,
    'remarks'         => 'Order placed successfully',
    'triggered_by'    => 'Customer',
]);
            // ADD THIS — admin notification
\App\Models\AdminNotification::notify([
    'type'      => 'order',
    'title'     => 'New order placed',
    'message'   => "{$order->customer_name} placed a new order worth ₹" . number_format($order->grand_total, 2) . " ({$order->items()->count()} items).",
    'reference' => '#' . $order->order_number,
    'icon'      => 'fa-shopping-bag',
    'url'       => route('admin.orders.show', $order->id),
    'link_text' => 'View Order',
]);

            \App\Models\Notification::create([
                'customer_id' => $customer->id,
                'title' => 'Order Placed',
                'message' => 'Your order ' . $order->order_number . ' has been placed successfully.',
                'icon' => 'fa-cart-shopping',
                'color' => 'order-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'pending',
                ],
            ]);

            foreach ($cart->items as $item) {

                $orderItem = OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product_id,

                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,

                    'selected_attributes' => $item->selected_attributes,

                    'product_name' =>
                        $item->product->name ?? 'Product',

                    'quantity' => $item->quantity,

                    'price' => $item->price,

                    'total' => $item->total,
                ]);

                // Carry the cart item's addon snapshot over to the order item.
                foreach ($item->addons as $addon) {
                    $orderItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | COD Order
            |--------------------------------------------------------------------------
            */

            if ($request->payment_method == 'cod') {

                $invoiceNumber =
                    AdminSettingController::generateInvoiceNumber();

                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => $invoiceNumber,
                    'invoice_date' => now()->toDateString(),

                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'customer_phone' => $order->customer_phone,

                    'billing_address' => collect([
                        $order->address_line_1,
                        $order->address_line_2,
                        $order->city?->name ?? '',
                        $order->state?->name ?? '',
                        $order->pincode,
                    ])->filter()->implode(', '),

                    'subtotal' => $order->subtotal,
                    'discount' => $order->discount,
                    'tax_amount' => $order->tax_amount,
                    'grand_total' => $order->grand_total,

                    'gst_type' => $order->gst_type,

                    'cgst_rate' => $order->cgst_rate,
                    'sgst_rate' => $order->sgst_rate,
                    'igst_rate' => $order->igst_rate,

                    'cgst_amount' => $order->cgst_amount,
                    'sgst_amount' => $order->sgst_amount,
                    'igst_amount' => $order->igst_amount,

                    'status' => 'generated',
                ]);

                $cart->items()->delete();
                $cart->delete();

$this->deductOrderStock($order);

$this->logPayment([
    'order_id'        => $order->id,
    'order_number'    => $order->order_number,
    'gateway'         => 'cod',
    'payment_id'      => null,
    'amount'          => $order->grand_total,
    'method'          => 'cod',
    'status'          => 'pending',
    'customer_name'   => $order->customer_name,
    'customer_email'  => $order->customer_email,
]);

DB::commit();

 // 👇 new — Meta CAPI purchase event, dispatched after commit so order is guaranteed saved
                \App\Jobs\SendMetaCapiPurchase::dispatch(
                    $order->id,
                    $request->ip(),
                    $request->userAgent(),
                    $request->cookie('_fbp'),
                    $request->cookie('_fbc'),
                );

                $this->sendOrderEmails($order);

                return response()->json([
                    'success' => true,
                    'type' => 'cod',
                    'message' => 'Order placed successfully.',
                    'redirect_url' => route(
                        'order.success',
                        $order->id
                    )
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Razorpay Order
            |--------------------------------------------------------------------------
            */

            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api(
                $keyId,
                $keySecret
            );

            $razorpayPayload = [

                'receipt' => $order->order_number,

                'amount' =>
                    round($order->grand_total * 100),

                'currency' => 'INR',

                'payment_capture' => 1
            ];

            $apiStartTime = microtime(true);

            try {

                $razorpayOrder = $api->order->create($razorpayPayload);

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'orders',
                    'service' => 'Razorpay',
                    'status_code' => 200,
                    'response_time_ms' => (int) round((microtime(true) - $apiStartTime) * 1000),
                    'request_payload' => $razorpayPayload,
                    'response_payload' => $razorpayOrder->toArray(),
                ]);

            } catch (\Exception $e) {

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'orders',
                    'service' => 'Razorpay',
                    'status_code' => $e->getCode() ?: 500,
                    'response_time_ms' => (int) round((microtime(true) - $apiStartTime) * 1000),
                    'request_payload' => $razorpayPayload,
                    'error_message' => $e->getMessage(),
                ]);

                throw $e;
            }

            $order->update([
                'razorpay_order_id' =>
                    $razorpayOrder['id']
            ]);

$this->logPayment([
    'order_id'        => $order->id,
    'order_number'    => $order->order_number,
    'gateway'         => 'razorpay',
    'payment_id'      => $razorpayOrder['id'],
    'amount'          => $order->grand_total,
    'method'          => null,
    'status'          => 'created',
    'customer_name'   => $order->customer_name,
    'customer_email'  => $order->customer_email,
    'meta'            => $razorpayOrder->toArray(),
]);

            DB::commit();

            return response()->json([

                'success' => true,

                'type' => 'razorpay',

                'order_id' => $order->id,

                'razorpay_order_id' =>
                    $razorpayOrder['id'],

                'amount' =>
                    round($order->grand_total * 100),

                'key' => $keyId,

                'customer_name' =>
                    $order->customer_name,

                'customer_email' =>
                    $order->customer_email,

                'customer_phone' =>
                    $order->customer_phone,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function razorpaySuccess(Request $request)
    {
        $request->validate([

            'order_id' => 'required|exists:orders,id',

            'razorpay_payment_id' => 'required',

            'razorpay_order_id' => 'required',

            'razorpay_signature' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $order = Order::with('items')
                ->findOrFail($request->order_id);

            /*
            |--------------------------------------------------------------------------
            | Verify Signature
            |--------------------------------------------------------------------------
            */

            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api(
                $keyId,
                $keySecret
            );

            $attributes = [

                'razorpay_order_id' =>
                    $request->razorpay_order_id,

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_signature' =>
                    $request->razorpay_signature,
            ];

            $verifyStartTime = microtime(true);

            try {

                $api->utility->verifyPaymentSignature(
                    $attributes
                );

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'payment/verify',
                    'service' => 'Razorpay',
                    'status_code' => 200,
                    'response_time_ms' => (int) round((microtime(true) - $verifyStartTime) * 1000),
                    'request_payload' => $attributes,
                ]);

            } catch (\Exception $e) {

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'payment/verify',
                    'service' => 'Razorpay',
                    'status_code' => $e->getCode() ?: 400,
                    'response_time_ms' => (int) round((microtime(true) - $verifyStartTime) * 1000),
                    'request_payload' => $attributes,
                    'error_message' => $e->getMessage(),
                ]);

                throw $e;
            }

            /*
            |--------------------------------------------------------------------------
            | Mark Order Paid
            |--------------------------------------------------------------------------
            */

            $order->update([

                'payment_status' => 'paid',

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_signature' =>
                    $request->razorpay_signature,

                'transaction_id' =>
                    $request->razorpay_payment_id,

                'status' => 'processing',
            ]);

            $order->statusHistory()->create([
    'status'          => 'processing',
    'previous_status' => 'pending',
    'remarks'         => 'Payment received successfully via Razorpay',
    'triggered_by'    => 'Razorpay Webhook',
]);


            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'title' => 'Payment Successful',
                'message' => 'Payment received for order ' . $order->order_number . '. Your order is now being processed.',
                'icon' => 'fa-credit-card',
                'color' => 'success-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'processing',
                ],
            ]);
            
            // ADD THIS
\App\Models\AdminNotification::notify([
    'type'      => 'payment',
    'title'     => 'Payment received',
    'message'   => "Payment of ₹" . number_format($order->grand_total, 2) . " for order #{$order->order_number} successfully received via Razorpay.",
    'reference' => '#' . $order->order_number,
    'icon'      => 'fa-credit-card',
    'url'       => route('admin.orders.show', $order->id),
    'link_text' => 'View Order',
]);

            /*
            |--------------------------------------------------------------------------
            | Generate Invoice
            |--------------------------------------------------------------------------
            */

            if (!$order->invoice) {

                $invoiceNumber =
                    AdminSettingController::generateInvoiceNumber();

                Invoice::create([

                    'order_id' => $order->id,

                    'invoice_number' =>
                        $invoiceNumber,

                    'invoice_date' =>
                        now()->toDateString(),

                    'customer_name' =>
                        $order->customer_name,

                    'customer_email' =>
                        $order->customer_email,

                    'customer_phone' =>
                        $order->customer_phone,

                    'billing_address' =>
                        collect([
                            $order->address_line_1,
                            $order->address_line_2,
                            $order->city?->name ?? '',
                            $order->state?->name ?? '',
                            $order->pincode,
                        ])->filter()->implode(', '),

                    'subtotal' =>
                        $order->subtotal,

                    'discount' =>
                        $order->discount,

                    'tax_amount' =>
                        $order->tax_amount,

                    'grand_total' =>
                        $order->grand_total,

                    'gst_type' =>
                        $order->gst_type,

                    'cgst_rate' =>
                        $order->cgst_rate,

                    'sgst_rate' =>
                        $order->sgst_rate,

                    'igst_rate' =>
                        $order->igst_rate,

                    'cgst_amount' =>
                        $order->cgst_amount,

                    'sgst_amount' =>
                        $order->sgst_amount,

                    'igst_amount' =>
                        $order->igst_amount,

                    'status' => 'generated',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Clear Cart
            |--------------------------------------------------------------------------
            */

            $cart = Cart::where(
                'user_id',
                $order->customer_id
            )->first();

            if ($cart) {

                $cart->items()->delete();

                $cart->delete();
            }

            // Razorpay — deduct stock after payment verified, before committing
            $this->deductOrderStock($order);
            // $this->alertService->sendAlertEmailIfNeeded(); // ← add this


$this->logPayment([
    'order_id'        => $order->id,
    'order_number'    => $order->order_number,
    'gateway'         => 'razorpay',
    'payment_id'      => $request->razorpay_payment_id,
    'amount'          => $order->grand_total,
    'method'          => 'razorpay',
    'status'          => 'captured',
    'customer_name'   => $order->customer_name,
    'customer_email'  => $order->customer_email,
    'meta'            => [
        'razorpay_order_id'   => $request->razorpay_order_id,
        'razorpay_payment_id' => $request->razorpay_payment_id,
    ],
]);

            DB::commit();


            // 👇 new — Meta CAPI purchase event
            \App\Jobs\SendMetaCapiPurchase::dispatch(
                $order->id,
                $request->ip(),
                $request->userAgent(),
                $request->cookie('_fbp'),
                $request->cookie('_fbc'),
            );
            
            $this->sendOrderEmails($order);

            return response()->json([

                'success' => true,

                'redirect_url' =>
                    route(
                        'order.success',
                        $order->id
                    ),
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            
             $this->logPayment([
        'order_id'        => $request->order_id ?? null,
        'order_number'    => optional(Order::find($request->order_id))->order_number,
        'gateway'         => 'razorpay',
        'payment_id'      => $request->razorpay_payment_id ?? null,
        'amount'          => optional(Order::find($request->order_id))->grand_total ?? 0,
        'method'          => 'razorpay',
        'status'          => 'failed',
        'error_message'   => $e->getMessage(),
        'meta'            => $request->only(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature']),
    ]);



            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()
            ], 422);
        }
    }

   public function orderSuccess(Order $order)
    {
        // Pixel/GA purchase event — rendered as an inline script tag on the thank-you view
        $purchaseScript = \App\Services\Tracking\PixelTracker::purchaseScript($order);

        return view(
            'front-pages.thank-you',
            compact('order', 'purchaseScript') // 👈 new
        );
    }


    protected function sendOrderEmails(Order $order): void
    {
        $order->loadMissing([
            'items.product',
            'state',
            'city',
        ]);

        /*
         |--------------------------------------------------------------------------
         | Order Items HTML
         |--------------------------------------------------------------------------
         */
        $orderItems = '';

        foreach ($order->items as $item) {

            // Thumbnail: image variant > product default image > null (matches admin blade)
            $thumb = null;
            if ($item->imageVariant && $item->imageVariant->image) {
                $thumb = asset('storage/' . $item->imageVariant->image);
            } elseif ($item->product) {
                $thumb = $item->product->display_image;
            }

            $imageHtml = $thumb
                ? "<img src='{$thumb}' alt='{$item->product_name}' style='width:56px;height:56px;object-fit:cover;border-radius:4px;border:1px solid #d0d8d7;display:block;'>"
                : "<span style='display:block;width:56px;height:56px;background:#e8efee;border-radius:4px;border:1px solid #d0d8d7;'></span>";

            // Variant label from selected_attributes snapshot (same logic as admin blade)
            $variantLabel = null;
            if (!empty($item->selected_attributes)) {
                $variantLabel = collect($item->selected_attributes)
                    ->map(function ($value, $key) {
                        if (is_array($value)) {
                            $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                            $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                            return $attrName . ': ' . $attrVal;
                        }
                        return $key . ': ' . $value;
                    })
                    ->join(' · ');
            }

            $variantHtml = $variantLabel
                ? "<div style='font-size:11px;color:#7a9e9c;'>{$variantLabel}</div>"
                : '';

            // SKU: sku variant > snapshot sku > product sku
            $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);
            $skuHtml = $sku
                ? "<div style='font-size:11px;color:#7a9e9c;'>SKU: {$sku}</div>"
                : '';

            // Addons — list each one and fold into the line total
            $addonsTotal = $item->addons->sum('price');
            $lineTotal = ($item->price * $item->quantity) + $addonsTotal;

            $addonsHtml = '';
            if ($item->addons->isNotEmpty()) {
                foreach ($item->addons as $addon) {
                    $addonsHtml .= "<div style='font-size:11px;color:#7a9e9c;'>+ {$addon->detail} (₹" . number_format($addon->price, 2) . ")</div>";
                }
            }

            $orderItems .= "
    <div style='display:table;width:100%;border-bottom:1px solid #e6eae9;padding:14px 0;'>
        <div style='display:table-cell;width:60px;vertical-align:middle;padding-right:14px;'>
            {$imageHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;'>
            <div style='font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:3px;'>{$item->product_name}</div>
            {$variantHtml}
            {$skuHtml}
            <div style='font-size:11px;color:#7a9e9c;'>Qty: {$item->quantity}</div>
            {$addonsHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:700;color:#1F5552;white-space:nowrap;'>
            ₹ " . number_format($lineTotal, 2) . "
        </div>
    </div>
";
        }
        /*
        |--------------------------------------------------------------------------
        | Order Summary HTML
        |--------------------------------------------------------------------------
        */
        $orderSummary = "
        <div style='margin-top:16px;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#666;'>Subtotal</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                    ₹ " . number_format($order->subtotal, 2) . "
                </span>
            </div>
    ";

        if ($order->discount > 0) {
            $discountLabel = 'Discount' . ($order->coupon_code ? " ({$order->coupon_code})" : '');
            $orderSummary .= "
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#2e7d32;font-weight:500;'>{$discountLabel}</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#2e7d32;font-weight:500;'>
                    − ₹ " . number_format($order->discount, 2) . "
                </span>
            </div>
        ";
        }

        if ($order->tax_amount > 0) {

            if ($order->gst_type === 'igst' && $order->igst_amount > 0) {

                $orderSummary .= "
                <div style='display:table;width:100%;padding:5px 0;'>
                    <span style='display:table-cell;font-size:13px;color:#666;'>IGST ({$order->igst_rate}%)</span>
                    <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                        ₹ " . number_format($order->igst_amount, 2) . "
                    </span>
                </div>
            ";

            } else {

                if ($order->cgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>CGST ({$order->cgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->cgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }

                if ($order->sgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>SGST ({$order->sgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->sgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }
            }
        }

        $orderSummary .= "
            <hr style='border:none;border-top:1px solid #d4dbd9;margin:10px 0;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:15px;font-weight:600;color:#1a1a1a;'>Grand Total</span>
                <span style='display:table-cell;text-align:right;font-size:16px;font-weight:700;color:#1F5552;'>
                    ₹ " . number_format($order->grand_total, 2) . "
                </span>
            </div>
        </div>
    ";
        /*
        |--------------------------------------------------------------------------
        | Shipping Address HTML
        |--------------------------------------------------------------------------
        */
        $shippingAddress = "
        <div>
            <strong>{$order->customer_name}</strong><br>
            {$order->address_line_1}
    ";

        if (!empty($order->address_line_2)) {
            $shippingAddress .= "<br>{$order->address_line_2}";
        }

        $shippingAddress .= "
            <br>{$order->city?->name}, {$order->state?->name} - {$order->pincode}
            <br>📞 {$order->customer_phone}
        </div>
    ";

        /*
        |--------------------------------------------------------------------------
        | Common Variables
        |--------------------------------------------------------------------------
        */
        $variables = [

            '{customer_name}' => $order->customer_name,

            '{order_number}' => $order->order_number,
            '{order_date}' => $order->created_at->format('d M Y'),
            '{grand_total}' => '₹' . number_format($order->grand_total, 2),

            '{payment_method}' => ucfirst($order->payment_method),
            '{payment_status}' => ucfirst($order->payment_status),
            '{transaction_id}' => $order->transaction_id ?? 'N/A',

            '{order_url}' => route('order.success', $order->id),

            '{order_items}' => $orderItems,
            '{order_summary}' => $orderSummary,
            '{shipping_address}' => $shippingAddress,
        ];

        /*
        |--------------------------------------------------------------------------
        | Customer - Order Confirmed
        |--------------------------------------------------------------------------
        */
        \App\Services\Email\EmailDispatcher::send(
            'order-confirmed',
            $order->customer_email,
            $variables,
            $order->customer_name
        );

        /*
        |--------------------------------------------------------------------------
        | Customer - Payment Received
        |--------------------------------------------------------------------------
        */
        if ($order->payment_status === 'paid') {

            \App\Services\Email\EmailDispatcher::send(
                'payment-received',
                $order->customer_email,
                array_merge($variables, [
                    '{payment_amount}' => '₹' . number_format($order->grand_total, 2),
                    '{transaction_id}' => $order->transaction_id ?? $order->razorpay_payment_id ?? 'N/A',
                    '{invoice_url}' => route('order.success', $order->id),
                ]),
                $order->customer_name
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin - New Order Alert
        |--------------------------------------------------------------------------
        */
        $adminEmail = Setting::first()?->admin_email;

        if ($adminEmail) {

            \App\Services\Email\EmailDispatcher::send(
                'new-order-alert',
                $adminEmail,
                array_merge($variables, [
                    '{admin_order_url}' => route('admin.orders.show', $order->id),
                ])
            );
        }
    }


    protected function deductOrderStock(Order $order): void
    {
        /** @var \App\Services\StockService $stockService */
        $stockService = app(\App\Services\StockService::class);

        $order->loadMissing(['items.product', 'items.stockVariant']);

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product)
                continue;

            try {
                $stockService->debit(
                    $product,
                    $item->quantity,
                    'order',
                    $order,               // reference — links history entry to this order
                    null,                 // no admin user, this is a customer action
                    null,                 // no note
                    true,                 // allowNegative: true so an order never fails due to stock race
                    $item->stockVariant   // null if this item has no stock-type variant → falls back to product stock
                );
            } catch (\Exception $e) {
                // Log but don't block the order — stock can be corrected manually
                \Log::warning("Stock debit failed for product {$product->id} on order {$order->id}: " . $e->getMessage());
            }
        }
    }

protected function logPayment(array $data): void
{
    try {
        \App\Models\PaymentLog::create($data);
    } catch (\Exception $e) {
        \Log::warning('Payment log write failed: ' . $e->getMessage());
    }
}

}
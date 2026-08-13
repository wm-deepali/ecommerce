<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvoiceSetting;
use App\Models\Order;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    private function customer()
    {
        return Auth::guard('customer')->user();
    }

    private function findOrder(int $id): Order
    {
        return Order::with([
            'items.product.images',
            'items.priceVariant',
            'items.imageVariant',
            'items.stockVariant',
            'items.skuVariant',
            'items.addons',
            'items.review.images',
            'invoice',
            'city',
            'state',
        ])
            ->where('customer_id', $this->customer()->id)
            ->findOrFail($id);
    }

    public function index()
    {
        $customer = $this->customer();

        $orders = $customer->orders()
            ->with([
                'items.product.images',
                'items.priceVariant',
                'items.imageVariant',
                'items.stockVariant',
                'items.skuVariant',
                'items.addons',
                'invoice',
                'statusHistory',
            ])
            ->latest()
            ->get();

        $returnReasons = \App\Models\ReturnReason::where('is_active', 1)->orderBy('sort_order')->get();

        return view('user.orders.index', compact('orders', 'returnReasons'));
    }

    public function show(int $id)
    {
        $order = $this->findOrder($id);

        $returnReasons = \App\Models\ReturnReason::where('is_active', 1)->orderBy('sort_order')->get();

        return view('user.orders.show', compact('order', 'returnReasons'));
    }

    public function invoice(int $id)
    {
        $order = $this->findOrder($id);

        if (!$order->invoice) {
            return back()->with('error', 'Invoice is not available for this order yet.');
        }

        // findOrder() already eager-loads everything the invoice view needs
        // (product, all four variant types, addons) — no extra load() call required.

        $setting = InvoiceSetting::with([
            'state',
            'city'
        ])->first();

        $logo_64 = null;

        if ($setting?->company_logo) {
            $logoPath = storage_path('app/public/' . $setting->company_logo);

            if (file_exists($logoPath)) {
                $mime = mime_content_type($logoPath);

                $logo_64 = 'data:' . $mime . ';base64,' .
                    base64_encode(file_get_contents($logoPath));
            }
        }

        $pdf = Pdf::loadView('user.orders.invoice', [
            'order' => $order,
            'invoice' => $order->invoice,
            'setting' => $setting,
            'isPdf' => true,
            'logo_64' => $logo_64,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 150,
            ]);

        $filename = 'Invoice-' . $order->invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }

    public function submitReturn(Request $request)
    {
        // ... unchanged, no variant references here
        $request->validate([
            'order_id' => 'required|integer',
            'order_item_id' => 'required|integer',
            'return_reason_id' => 'required|exists:return_reasons,id',
            'type' => 'required|in:return,exchange',
            'details' => 'nullable|string|max:1000',
            'refund_method' => 'required|in:upi,qr,bank',
            'upi_id' => 'required_if:refund_method,upi|nullable|string|max:100',
            'qr_image' => 'required_if:refund_method,qr|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bank_name' => 'required_if:refund_method,bank|nullable|string|max:100',
            'account_name' => 'required_if:refund_method,bank|nullable|string|max:100',
            'account_number' => 'required_if:refund_method,bank|nullable|string|max:30',
            'ifsc_code' => 'required_if:refund_method,bank|nullable|string|max:20',
            'bank_branch' => 'nullable|string|max:100',
            'account_type' => 'required_if:refund_method,bank|nullable|in:savings,current,salary',
        ]);

        $customer = Auth::guard('customer')->user();
        $order = $customer->orders()->findOrFail($request->order_id);
        $item = $order->items()->findOrFail($request->order_item_id);

        abort_if(
            $order->created_at->diffInDays(now()) > 7,
            403,
            'Return window has expired.'
        );

        $already = OrderReturn::where('order_item_id', $item->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($already) {
            return back()->with('error', 'A return request for this item is already in progress.');
        }

        $qrPath = null;
        if ($request->refund_method === 'qr' && $request->hasFile('qr_image')) {
            $qrPath = $request->file('qr_image')->store('returns/qr', 'public');
        }

        OrderReturn::create([
            'order_id' => $order->id,
            'order_item_id' => $item->id,
            'customer_id' => $customer->id,
            'return_reason_id' => $request->return_reason_id,
            'type' => $request->type,
            'details' => $request->details,
            'status' => 'pending',
            'refund_method' => $request->refund_method,
            'upi_id' => $request->refund_method === 'upi' ? $request->upi_id : null,
            'qr_image' => $request->refund_method === 'qr' ? $qrPath : null,
            'bank_name' => $request->refund_method === 'bank' ? $request->bank_name : null,
            'account_name' => $request->refund_method === 'bank' ? $request->account_name : null,
            'account_number' => $request->refund_method === 'bank' ? $request->account_number : null,
            'ifsc_code' => $request->refund_method === 'bank' ? $request->ifsc_code : null,
            'bank_branch' => $request->refund_method === 'bank' ? $request->bank_branch : null,
            'account_type' => $request->refund_method === 'bank' ? $request->account_type : null,
        ]);


// admin notification
\App\Models\AdminNotification::notify([
    'type'      => 'return',
    'title'     => 'Return request received',
    'message'   => "{$customer->name} raised a {$request->type} request for {$item->product_name} from order #{$order->order_number}."
        . ($request->details ? " Reason: {$request->details}." : ''),
    'reference' => '#RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT),
    'icon'      => 'fa-undo',
    'url'       => route('admin.order-returns.show', $orderReturn->id),
    'link_text' => 'Review Return',
]);

        return back()->with('success', 'Return request submitted. We\'ll process your refund within 3–5 business days.');
    }

    public function reorder(int $id)
    {
        $order = $this->findOrder($id);
        $customer = $this->customer();

        $added = 0;
        $skipped = [];

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product || $product->stock < 1) {
                $skipped[] = $item->product_name;
                continue;
            }

            $cart = $customer->cart()->firstOrCreate([]);

            // Match on product + all four variant refs, so different
            // size/color combos of the same product don't collapse together.
            $cartItem = $cart->items()
                ->where('product_id', $product->id)
                ->where('price_variant_id', $item->price_variant_id)
                ->where('image_variant_id', $item->image_variant_id)
                ->where('stock_variant_id', $item->stock_variant_id)
                ->where('sku_variant_id', $item->sku_variant_id)
                ->get()
                ->first(fn ($ci) => $ci->selected_attributes === $item->selected_attributes);

            if ($cartItem) {
                $newQty = min($cartItem->quantity + $item->quantity, $product->stock);
                $cartItem->update([
                    'quantity' => $newQty,
                    'total' => $newQty * $cartItem->price,
                ]);
            } else {
                $qty = min($item->quantity, $product->stock);

                $newCartItem = $cart->items()->create([
                    'product_id' => $product->id,
                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,
                    'selected_attributes' => $item->selected_attributes,
                    'quantity' => $qty,
                    'price' => $item->price,
                    'total' => $qty * $item->price,
                ]);

                foreach ($item->addons as $addon) {
                    $newCartItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }

            $added++;
        }

        if ($added === 0) {
            return redirect()->route('user.orders.index')
                ->with('error', 'None of the items from this order are currently available.');
        }

        $message = "{$added} " . Str::plural('item', $added) . " added to your cart.";

        if (!empty($skipped)) {
            $message .= ' Unavailable: ' . implode(', ', $skipped) . '.';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }
}
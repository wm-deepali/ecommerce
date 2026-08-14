<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderShippedMail;
use App\Models\Courier;
use App\Models\InvoiceSetting;
use App\Models\Order;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
   public function index(Request $request)
{
    // ── Customer filter (used when viewing orders from a customer's wishlist/profile) ──
    $customerId = $request->input('customer');

    // ── KPI counts ────────────────────────────────────────
    $kpi = [
        'total' => Order::when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'pending' => Order::where('status', 'pending')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'shipped' => Order::where('status', 'shipped')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'delivered' => Order::where('status', 'delivered')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
    ];

    // ── Tab counts ────────────────────────────────────────
    // NDR and RTO added as their own tabs — without these, orders that fail
    // delivery (status = 'ndr'/'rto') would only ever show up under "All"
    // and never surface in a dedicated queue for admins to work through.
    $tabCounts = [
        'all' => Order::when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'new' => Order::where('status', 'new')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'processing' => Order::where('status', 'processing')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'shipped' => Order::where('status', 'shipped')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'delivered' => Order::where('status', 'delivered')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'ndr' => Order::where('status', 'ndr')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'rto' => Order::where('status', 'rto')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
        'cancelled' => Order::where('status', 'cancelled')->when($customerId, fn ($q) => $q->where('customer_id', $customerId))->count(),
    ];

    // ── Base query ────────────────────────────────────────
    $query = Order::with(['items', 'customer'])
        ->latest();

    // ── Customer filter ────────────────────────────────────
    if ($customerId) {
        $query->where('customer_id', $customerId);
    }

    // ── Status tab filter ─────────────────────────────────
    $activeTab = $request->input('tab', 'all');
    if ($activeTab !== 'all') {
        $query->where('status', $activeTab);
    }

    // ── Search (order number, name, email) ────────────────
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
                ->orWhere('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_email', 'like', "%{$search}%");
        });
    }

    // ── Payment status filter ─────────────────────────────
    if ($payment = $request->input('payment')) {
        $query->where('payment_status', $payment);
    }

    // ── Date range filter ─────────────────────────────────
    if ($from = $request->input('from_date')) {
        $query->whereDate('created_at', '>=', $from);
    }
    if ($to = $request->input('to_date')) {
        $query->whereDate('created_at', '<=', $to);
    }

    // ── Paginate ──────────────────────────────────────────
    $orders = $query->paginate(25)->withQueryString();

    return view('admin.orders.index', compact(
        'orders',
        'kpi',
        'tabCounts',
        'activeTab'
    ));
}

    // ── Export CSV ────────────────────────────────────────────
    public function export(Request $request)
    {
        $query = Order::with('items')->latest();

  if ($customerId = $request->input('customer')) {
        $query->where('customer_id', $customerId);
    }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }
        if ($payment = $request->input('payment')) {
            $query->where('payment_status', $payment);
        }
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }
        if (($tab = $request->input('tab', 'all')) !== 'all') {
            $query->where('status', $tab);
        }

        $orders = $query->get();

        $filename = 'orders_' . now()->format('Y_m_d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $fh = fopen('php://output', 'w');
            fputcsv($fh, [
                'Order #',
                'Customer',
                'Email',
                'Phone',
                'Items',
                'Subtotal',
                'Discount',
                'Tax',
                'Grand Total',
                'Payment',
                'Status',
                'Date',
            ]);
            foreach ($orders as $o) {
                fputcsv($fh, [
                    $o->order_number,
                    $o->customer_name,
                    $o->customer_email,
                    $o->customer_phone,
                    $o->items->count(),
                    $o->subtotal,
                    $o->discount,
                    $o->tax_amount,
                    $o->grand_total,
                    $o->payment_status,
                    $o->status,
                    $o->created_at->format('d M Y h:i A'),
                ]);
            }
            fclose($fh);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function show(Order $order)
    {
        $order->load([
            'items.product.images',   // product thumbnail
            'items.imageVariant',
            'items.skuVariant',     // variant image (falls back to product thumb)
            'items.addons',           // selected addons
            'customer',               // customer profile info
            'state',
            'city',
            'invoice',
            'statusHistory',
            'ndrs',                   // NDR history for the "NDR History" card + Mark NDR button gating
        ]);


        // Customer's total order count (for sidebar)
        $customerOrderCount = $order->customer_id
            ? Order::where('customer_id', $order->customer_id)->count()
            : null;

        // Avatar initials
        $words = explode(' ', trim($order->customer_name));
        $initials = strtoupper(
            substr($words[0] ?? '', 0, 1) .
            substr($words[1] ?? '', 0, 1)
        );

        // Payment pill CSS class
        $payClass = match ($order->payment_status) {
            'paid' => 'pay-paid',
            'pending' => 'pay-pending',
            'failed' => 'pay-failed',
            'refunded' => 'pay-refunded',
            default => 'pay-pending',
        };

        // Order status pill CSS class
        $orderClass = match ($order->status) {
            'new' => 'order-new',
            'processing' => 'order-processing',
            'shipped' => 'order-shipped',
            'delivered' => 'order-delivered',
            'cancelled' => 'order-cancelled',
            'ndr' => 'order-ndr',
            'rto' => 'order-rto',
            default => 'order-new',
        };

        // Timeline steps — mark done/active based on current status
        $statusFlow = ['new', 'processing', 'shipped', 'delivered'];
        $currentIdx = array_search($order->status, $statusFlow);

        $timelineSteps = [
            'new' => ['title' => 'Order Placed', 'desc' => 'Customer placed the order successfully.'],
            'processing' => ['title' => 'Order Confirmed &amp; Processing', 'desc' => 'Payment confirmed, order is being prepared.'],
            'shipped' => ['title' => 'Shipped', 'desc' => 'Package dispatched.'],
            'delivered' => ['title' => 'Delivered', 'desc' => 'Order delivered to customer.'],
            'cancelled' => ['title' => 'Cancelled', 'desc' => 'Order was cancelled.'],
            'ndr' => ['title' => 'Delivery Failed (NDR)', 'desc' => 'Courier could not deliver the order.'],
            'rto' => ['title' => 'Returned to Origin', 'desc' => 'Order returned; stock credited back.'],
        ];

        $couriers = Courier::where('is_active', 1)
            ->orderBy('name')
            ->get();


        return view('admin.orders.show', compact(
            'order',
            'customerOrderCount',
            'initials',
            'payClass',
            'orderClass',
            'statusFlow',
            'currentIdx',
            'timelineSteps',
            'couriers'
        ));
    }

    // ── Status update AJAX/POST method ────────────────────────────────────────────
    // NOTE: this intentionally still only accepts pending/processing/shipped/
    // delivered/cancelled. 'ndr' and 'rto' are NOT settable here — they're only
    // set via NdrController (markNdr / reattempt / markRto / cancel), which also
    // handles the NDR-specific side effects (customer notification wording,
    // stock reversal on RTO, etc.) that this generic status flow doesn't do.
    // The "Update Status" panel is hidden in the blade when status is ndr/rto
    // for the same reason — don't let this form silently overwrite an active
    // NDR case.
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'courier_id' => 'nullable|exists:couriers,id',
            'tracking_number' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status;

        $order->update([
            'status' => $request->status,
            'courier_id' => $request->courier_id,
            'tracking_number' => $request->tracking_number,
        ]);

        if ($oldStatus !== $request->status) {

            $remarks = $request->note;

            if (!$remarks) {

                $remarks = 'Order status changed from '
                    . ucfirst($oldStatus)
                    . ' to '
                    . ucfirst($request->status);

                if ($request->tracking_number) {
                    $remarks .= ' | Tracking Number: '
                        . $request->tracking_number;
                }
            }

            $order->statusHistory()->create([
                'status' => $request->status,
                'remarks' => $remarks,
                'previous_status'=> $oldStatus,
                'triggered_by' => 'Admin (' . auth()->user()->name . ')'
            ]);

            if ($order->customer_id) {

                $notificationData = match ($request->status) {

                    'processing' => [
                        'title' => 'Order Processing',
                        'message' => "Your order {$order->order_number} is now being processed.",
                        'icon' => 'fa-box-open',
                        'color' => 'order-icon',
                    ],

                    'shipped' => [
                        'title' => 'Order Shipped',
                        'message' => "Your order {$order->order_number} has been shipped."
                            . ($order->tracking_number
                                ? " Tracking Number: {$order->tracking_number}"
                                : ''),
                        'icon' => 'fa-truck-fast',
                        'color' => 'order-icon',
                    ],

                    'delivered' => [
                        'title' => 'Order Delivered',
                        'message' => "Your order {$order->order_number} has been delivered successfully.",
                        'icon' => 'fa-box-check',
                        'color' => 'success-icon',
                    ],

                    'cancelled' => [
                        'title' => 'Order Cancelled',
                        'message' => "Your order {$order->order_number} has been cancelled.",
                        'icon' => 'fa-circle-xmark',
                        'color' => 'security-icon',
                    ],

                    default => [
                        'title' => 'Order Updated',
                        'message' => "Your order {$order->order_number} status changed to {$request->status}.",
                        'icon' => 'fa-bell',
                        'color' => 'system-icon',
                    ],
                };

                \App\Models\Notification::create([
                    'customer_id' => $order->customer_id,
                    'title' => $notificationData['title'],
                    'message' => $notificationData['message'],
                    'icon' => $notificationData['icon'],
                    'color' => $notificationData['color'],
                    'data' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'status' => $request->status,
                    ],
                ]);
            }

// admin notification
$adminNotifData = match ($request->status) {

    'shipped' => [
        'title'   => 'Order shipped',
        'message' => "Order #{$order->order_number} dispatched"
            . ($order->tracking_number ? " via {$order->courier?->name}. Tracking ID: {$order->tracking_number}." : '.')
            . " Expected delivery in 3–5 days.",
        'icon'      => 'fa-truck',
        'link_text' => 'Track Shipment',
    ],

    'delivered' => [
        'title'     => 'Order delivered',
        'message'   => "Order #{$order->order_number} has been delivered to {$order->customer_name}.",
        'icon'      => 'fa-box-check',
        'link_text' => 'View Order',
    ],

    'cancelled' => [
        'title'     => 'Order cancelled',
        'message'   => "Order #{$order->order_number} by {$order->customer_name} (₹" . number_format($order->grand_total, 2) . ") was cancelled."
            . ($request->note ? " Reason: {$request->note}." : ''),
        'icon'      => 'fa-times-circle',
        'link_text' => 'View Order',
    ],

    default => null,
};

if ($adminNotifData) {
    \App\Models\AdminNotification::notify([
        'type'      => $request->status === 'cancelled' ? 'cancel' : 'order',
        'title'     => $adminNotifData['title'],
        'message'   => $adminNotifData['message'],
        'reference' => '#' . $order->order_number,
        'icon'      => $adminNotifData['icon'],
        'url'       => route('admin.orders.show', $order->id),
        'link_text' => $adminNotifData['link_text'],
    ]);
}

            /*
            |--------------------------------------------------------------------------
            | Email Notifications
            |--------------------------------------------------------------------------
            */

            $smtpSetting = SmtpSetting::first();

            if ($smtpSetting) {

                /*
                |--------------------------------------------------------------------------
                | Email Notifications
                |--------------------------------------------------------------------------
                */

                // Build these once — shipped/delivered/cancelled all need them
                // Build these once — shipped/delivered/cancelled all need them
                $orderItems = '';

                if (in_array($request->status, ['shipped', 'delivered', 'cancelled'])) {
                    $order->loadMissing(['items.product', 'items.imageVariant', 'items.skuVariant', 'items.addons', 'courier', 'state', 'city']);

                    foreach ($order->items as $item) {

    // Thumbnail: image variant > product default image > null
    $thumb = null;
    if ($item->imageVariant && $item->imageVariant->image) {
        $thumb = asset('storage/' . $item->imageVariant->image);
    } elseif ($item->product) {
        $thumb = $item->product->display_image;
    }

    $imageHtml = $thumb
        ? "<img src='{$thumb}' alt='{$item->product_name}' style='width:56px;height:56px;object-fit:cover;border-radius:4px;border:1px solid #d0d8d7;display:block;'>"
        : "<span style='display:block;width:56px;height:56px;background:#e8efee;border-radius:4px;border:1px solid #d0d8d7;'></span>";

    // Variant label from selected_attributes snapshot
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
                }


                if ($request->status === 'shipped') {

                    \App\Services\Email\EmailDispatcher::send(
                        'order-shipped',
                        $order->customer_email,
                        [
                            '{customer_name}' => $order->customer_name,

                            '{order_number}' => $order->order_number,
                            '{shipped_date}' => now()->format('d M Y'),

                            '{courier_name}' => $order->courier?->name ?? 'Courier Service',
                            '{tracking_number}' => $order->tracking_number ?? 'N/A',
                            '{tracking_url}' => $order->courier?->website_url
                                ?? url('/track-order/' . $order->order_number),

                            '{expected_delivery}' => now()->addDays(3)->format('d M Y'),

                            '{grand_total}' => '₹' . number_format($order->grand_total, 2),

                            '{payment_method}' => ucfirst($order->payment_method),
                            '{payment_status}' => ucfirst($order->payment_status),

                            '{order_items}' => $orderItems,
                            '{shipping_address}' => $shippingAddress,

                            '{order_url}' => route('order.success', $order->id),
                        ],
                        $order->customer_name
                    );
                }

                if ($request->status === 'delivered') {

                    \App\Services\Email\EmailDispatcher::send(
                        'order-delivered',
                        $order->customer_email,
                        [
                            '{customer_name}' => $order->customer_name,

                            '{order_number}' => $order->order_number,
                            '{delivered_date}' => now()->format('d M Y'),
                            '{grand_total}' => '₹' . number_format($order->grand_total, 2),
                            '{item_count}' => $order->items->count(),

                            '{payment_method}' => ucfirst($order->payment_method),
                            '{payment_status}' => ucfirst($order->payment_status),

                            '{order_items}' => $orderItems,
                            '{shipping_address}' => $shippingAddress,

                            '{review_url}' => route('home'),
                            '{order_url}' => route('order.success', $order->id),
                            '{return_url}' => route('order.success', $order->id),
                        ],
                        $order->customer_name
                    );
                }

                if ($request->status === 'cancelled') {

                    \App\Services\Email\EmailDispatcher::send(
                        'order-cancelled',
                        $order->customer_email,
                        [
                            '{customer_name}' => $order->customer_name,
                            '{order_number}' => $order->order_number,

                            '{cancel_reason}' => $request->note ?: 'Cancelled by store',
                            '{refund_amount}' => '₹' . number_format($order->grand_total, 2),
                            '{refund_days}' => '5-7',

                            '{shipping_address}' => $shippingAddress,
                        ],
                        $order->customer_name
                    );
                }

            }

        }

        return back()->with(
            'success',
            'Order status updated successfully.'
        );
    }


    // ── 1. Browser preview ────────────────────────────────────────────────────────
    public function invoice(Order $order)
    {
        // 404 gracefully if no invoice has been generated yet
        $invoice = $order->invoice;

        if (!$invoice) {
            return back()->with('error', 'No invoice found for this order.');
        }

        $setting = InvoiceSetting::with([
            'state',
            'city'
        ])->first();

        $order->load([
            'items.product',
            'items.addons',
            'state',
            'city',
        ]);

        $logo_64 = null;

        if ($setting?->company_logo) {
            $logoPath = storage_path('app/public/' . $setting->company_logo);

            if (file_exists($logoPath)) {
                $mime = mime_content_type($logoPath);

                $logo_64 = 'data:' . $mime . ';base64,' .
                    base64_encode(file_get_contents($logoPath));
            }
        }

        // Rendered as a full standalone HTML page (no admin layout)
        return view('admin.orders.invoice', compact('order', 'invoice', 'setting', 'logo_64'));
    }

    // ── 2. PDF download ───────────────────────────────────────────────────────────
    public function invoiceDownload(Order $order)
    {
        $invoice = $order->invoice;

        if (!$invoice) {
            return back()->with('error', 'No invoice found for this order.');
        }

        $order->load([
            'items.product',
            'items.addons',
            'state',
            'city',
        ]);

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


        $pdf = Pdf::loadView('admin.orders.invoice', [
            'order' => $order,
            'invoice' => $invoice,
            'setting' => $setting,
            'isPdf' => true,   // hides the print bar in the view
            'logo_64' => $logo_64,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 150,
            ]);

        $filename = 'Invoice-' . $invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }

    public function printLabels(Request $request)
    {
        $query = Order::with(['state', 'city', 'courier']);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        }

        $orders = $query->latest()->get();

        return view('admin.orders.print-labels', compact('orders'));
    }

    public function previewLabels(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id',
            'label_size' => 'required|in:A4,A5,A6,A8',
        ]);

        $orders = Order::with(['state', 'city', 'courier'])
            ->whereIn('id', $request->order_ids)
            ->get();

        $setting = InvoiceSetting::first(); // apna actual settings model daal dena

        $grid = $this->labelGridConfig($request->label_size);

        return view('admin.orders.label-preview', [
            'orders' => $orders,
            'setting' => $setting,
            'labelSize' => $request->label_size,
            'cols' => $grid['cols'],
        ]);
    }

    public function generateLabels(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id',
            'label_size' => 'required|in:A4,A5,A6,A8',
        ]);

        $orders = Order::with(['state', 'city', 'courier'])
            ->whereIn('id', $request->order_ids)
            ->get();

        $setting = InvoiceSetting::first();

        $grid = $this->labelGridConfig($request->label_size);
        $pages = $orders->chunk($grid['perPage']);

        $pdf = PDF::loadView('admin.orders.label-pdf', [
            'pages' => $pages,
            'cols' => $grid['cols'],
            'setting' => $setting,
        ]);

        $pdf->setPaper('a4', 'portrait'); // physical paper hamesha A4 hi hota hai

        return $pdf->stream('order-labels-' . now()->format('Y-m-d-His') . '.pdf');
    }

    private function labelGridConfig(string $size): array
    {
        // ── Labels-per-A4-sheet config ──
        // NOTE: Manager ne explicitly bola "A8 hai to A4 pe 2 print honge" —
        // ye standard ISO paper-doubling se match nahi karta (jo A8=16 deta),
        // isliye yahan business decision liya: chhota size bhi sirf 2 labels/sheet
        // rakha hai (courier scan ke liye readable size zaroori hai).
        // Agar manager confirm kare exact count, sirf yahan value change karo —
        // baaki poora system (preview + PDF) automatically adjust ho jaayega.
        return match ($size) {
            'A4' => ['perPage' => 1, 'cols' => 1],
            'A5' => ['perPage' => 2, 'cols' => 2],
            'A6' => ['perPage' => 4, 'cols' => 2],
            'A8' => ['perPage' => 2, 'cols' => 2], // manager ke exact instruction ke hisaab se
            default => ['perPage' => 1, 'cols' => 1],
        };
    }

}
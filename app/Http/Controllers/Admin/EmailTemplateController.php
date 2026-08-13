<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\SmtpSetting;
use App\Services\Email\EmailDispatcher;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{

    public function index()
    {
        $emailData = self::getData();

        return view('admin.admin-settings.templates', $emailData);
    }

    /**
     * The blade is shared with SMS templates — this just
     * supplies the $emailTemplates and $emailMeta variables.
     * The view is loaded by whatever controller already renders
     * the message-templates page; call getData() from there.
     */
    public static function getData(): array
    {
        $meta = EmailTemplate::eventMeta();

        // Keyed by event_key for easy blade lookup
        $templates = EmailTemplate::whereIn('event_key', EmailTemplate::$eventKeys)
            ->get()
            ->keyBy('event_key');

        return [
            'emailMeta' => $meta,
            'emailTemplates' => $templates,
            'smtpSettings' => SmtpSetting::getInstance(),
        ];
    }

    /**
     * AJAX save — POST /admin/settings/email-templates/{eventKey}
     */
    public function save(Request $request, string $eventKey): \Illuminate\Http\JsonResponse
    {
        if (!in_array($eventKey, EmailTemplate::$eventKeys)) {
            return response()->json(['success' => false, 'message' => 'Invalid event key.'], 422);
        }

        $validated = $request->validate([
            'enabled' => 'nullable|boolean',
            'from_name' => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
            'reply_to_name' => 'nullable|string|max:100',
            'reply_to_email' => 'nullable|email|max:150',
            'cc' => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:255',
            'preview_text' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            // extras
            'expiry_minutes' => 'nullable|integer|min:1|max:1440',
            'admin_email' => 'nullable|email|max:150',
            'stock_threshold' => 'nullable|integer|min:1',
        ]);

        // Build extra_settings for event-specific extras
        $extras = [];
        if ($eventKey === 'password-reset' && isset($validated['expiry_minutes'])) {
            $extras['expiry_minutes'] = $validated['expiry_minutes'];
        }
        if (in_array($eventKey, ['new-order-alert', 'low-stock-alert'])) {
            if (isset($validated['admin_email']))
                $extras['admin_email'] = $validated['admin_email'];
            if (isset($validated['stock_threshold']))
                $extras['stock_threshold'] = $validated['stock_threshold'];
        }

        $template = EmailTemplate::firstOrNew(['event_key' => $eventKey]);
        $template->fill([
            'enabled' => (bool) ($validated['enabled'] ?? false),
            'from_name' => $validated['from_name'] ?? null,
            'from_email' => $validated['from_email'] ?? null,
            'reply_to_name' => $validated['reply_to_name'] ?? null,
            'reply_to_email' => $validated['reply_to_email'] ?? null,
            'cc' => $validated['cc'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'preview_text' => $validated['preview_text'] ?? null,
            'body' => $validated['body'] ?? null,
            'extra_settings' => !empty($extras) ? $extras : null,
        ]);
        $template->save();

        return response()->json([
            'success' => true,
            'message' => "'{$eventKey}' email template saved.",
        ]);
    }

    /**
     * AJAX test send — POST /admin/settings/email-templates/test
     */
    public function sendTest(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'event_key' => 'required|string',
            'email' => 'required|email',
        ]);

        $eventKey = $request->input('event_key');
        $email = $request->input('email');

        // Sample variables — same pattern as SMS_SAMPLE in JS
        // Sample variables — matches EmailTemplate::eventMeta() vars exactly
        $appUrl = url('/');

        $samples = [
            // Customer
            '{customer_name}' => 'Rahul Sharma',
            '{email}' => $email,

            // Store (global)
            '{store_name}' => 'Oudhyana Chikankaari Store',
            '{brand_name}' => 'Oudhyana Chikankaari',
            '{logo_url}' => $appUrl .'/assets/img/corporate/Oudhyana_img/logo.png',
            '{tagline}' => 'Handcrafted, with heart.',
            '{shop_url}' => $appUrl, 
            '{login_url}' => $appUrl . '/user/login',

            // Support (global)
            '{support_email}' => 'support@oudhyana.com',
            '{support_number}' => '+91 0000000000',

            // Order
            '{order_number}' => 'ORD-1089',
            '{order_date}' => '24 Jun 2026',
            '{shipped_date}' => '26 Jun 2026',
            '{delivered_date}' => '28 Jun 2026',
            '{grand_total}' => '₹3,450',
            '{item_count}' => '3',

            // Payment
            '{payment_method}' => 'UPI',
            '{payment_status}' => 'Paid',
            '{payment_amount}' => '₹3,450',
            '{transaction_id}' => 'TXN8472910',

            // Shipment
            '{courier_name}' => 'Delhivery',
            '{tracking_number}' => 'DEL123456789',
            '{tracking_url}' => $appUrl . '/track/1089',
            '{expected_delivery}' => '28 Jun 2026',

            // Cancellation / Refund
            '{cancel_reason}' => 'Out of stock',
            '{refund_amount}' => '₹3,450',
            '{refund_days}' => '5-7',

            // Smart HTML blocks
            '{order_items}' => '
    <div style="display:table;width:100%;border-bottom:1px solid #e6eae9;padding:14px 0;">
        <div style="display:table-cell;width:60px;vertical-align:middle;padding-right:14px;">
            <span style="display:block;width:56px;height:56px;background:#e8efee;border-radius:4px;border:1px solid #d0d8d7;"></span>
        </div>
        <div style="display:table-cell;vertical-align:middle;">
            <div style="font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:3px;">Sample Product</div>
            <div style="font-size:11px;color:#7a9e9c;">Qty: 1</div>
        </div>
        <div style="display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:700;color:#1F5552;white-space:nowrap;">
            ₹ 3,450.00
        </div>
    </div>
',

            '{order_summary}' => '
    <div style="margin-top:16px;">
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:13px;color:#666;">Subtotal</span>
            <span style="display:table-cell;text-align:right;font-size:13px;color:#333;">₹ 3,450.00</span>
        </div>
        <hr style="border:none;border-top:1px solid #d4dbd9;margin:10px 0;">
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:15px;font-weight:600;color:#1a1a1a;">Grand Total</span>
            <span style="display:table-cell;text-align:right;font-size:16px;font-weight:700;color:#1F5552;">₹ 3,450.00</span>
        </div>
    </div>
',

            '{shipping_address}' => '<div><strong>Rahul Sharma</strong><br>221B Baker Street<br>Lucknow, Uttar Pradesh - 226001<br>📞 +91-9876543210</div>',

            // Actions
            '{order_url}' => $appUrl . '/user/orders/1089',
            '{review_url}' => $appUrl . '/user/orders/1089',
            '{return_url}' => $appUrl . '/user/orders/1089',
            '{invoice_url}' => $appUrl . '/user/orders/1089/invoice',

            // Coupon
            '{coupon_code}' => 'SAVE20',
            '{discount_value}' => '₹200',
            '{expiry_date}' => '30 Jun 2026',
            '{store_url}' => $appUrl,

            // Password reset (OTP)
            '{otp}' => '847291',
            '{otp_expiry}' => '10',

            // Admin — new order alert
            '{admin_order_url}' => $appUrl . '/admin/orders/1089',

            // Admin — low stock digest
            '{report_date}' => 'Tuesday, 30 June 2026 — 4:30 PM',
            '{total_count}' => '5',
            '{critical_count}' => '2',
            '{low_count}' => '3',
            '{critical_threshold}' => '2',
            '{low_threshold}' => '5',

            '{critical_products}' =>
                '<div style="font-size:12px;font-weight:700;color:#b22222;margin:20px 0 10px">🔴 Out of Stock (≤ 2 units)</div><div>Sample critical product row</div>',

            '{low_products}' =>
                '<div style="font-size:12px;font-weight:700;color:#916a00;margin:20px 0 10px">🟡 Low Stock (≤ 5 units)</div><div>Sample low stock product row</div>',

            '{admin_stock_url}' => $appUrl . '/admin/stock-alerts',
        ];

        $result = EmailDispatcher::sendTest($eventKey, $email, $samples, 'Test Recipient');

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success']
                ? "Test email sent to {$email}"
                : $result['response'],
        ]);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'event_key',
        'enabled',
        'from_name',
        'from_email',
        'reply_to_name',
        'reply_to_email',
        'cc',
        'subject',
        'preview_text',
        'body',
        'extra_settings',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'extra_settings' => 'array',
    ];

    /**
     * All valid event keys, in sidebar display order.
     * Changing this list is the only thing needed to add/remove events.
     */
    public static array $eventKeys = [
        'welcome',
        'order-confirmed',
        'order-shipped',
        'order-delivered',
        'order-cancelled',
        'payment-received',
        'coupon',
        'password-reset',
        'new-order-alert',
        'low-stock-alert',
    ];

    /**
     * Human-readable metadata for each event key.
     */
    public static function eventMeta(): array
    {
        return [
            'welcome' => [
                'label' => 'Welcome Email',
                'icon' => 'fa fa-star',
                'desc' => 'Sent automatically when a new customer registers on the store.',
                'default_subject' => 'Welcome to {store_name}, {customer_name}! 🎉',
                'default_preview' => 'Your account is ready — explore our latest collection!',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Welcome to <strong>{store_name}</strong>! We\'re thrilled to have you with us.</p>
<p>Your account is now active. Start exploring our collections.</p>
<a href="{shop_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Shop Now</a>
<p>Need help? Reply to this email or call {support_number}.</p>
<p>Warm regards,<br>Team {brand_name}</p>',
                'vars' => [
                    '{customer_name}' => 'Customer Name',
                    '{store_name}' => 'Store Name',
                    '{shop_url}' => 'Shop URL',
                    '{login_url}' => 'Login URL',
                    '{support_number}' => 'Support Number',
                    '{logo_url}' => 'Logo URL',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'order-confirmed' => [
                'label' => 'Order Confirmed',
                'icon' => 'fa fa-check-circle',
                'desc' => 'Sent when payment is verified and the order moves to confirmed status.',
                'default_subject' => 'Your order #{order_id} is confirmed! ✅',
                'default_preview' => 'Your order is on its way to fulfilment!',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Great news! Your order <strong>#{order_id}</strong> has been confirmed.</p>
<p>Payment of <strong>{order_amount}</strong> received via {payment_method}.<br>Expected delivery: <strong>{expected_delivery}</strong>.</p>
<a href="{order_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">View Order</a>
<p>Thank you for shopping with us!<br>Team {brand_name}</p>',
                'vars' => [

                    // Customer
                    '{customer_name}' => 'Customer Name',

                    // Store
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',

                    // Order
                    '{order_number}' => 'Order Number',
                    '{order_date}' => 'Order Date',
                    '{grand_total}' => 'Grand Total',

                    // Payment
                    '{payment_method}' => 'Payment Method',
                    '{payment_status}' => 'Payment Status',
                    '{transaction_id}' => 'Transaction ID',

                    // Smart HTML Blocks
                    '{order_items}' => 'Order Items',
                    '{order_summary}' => 'Order Summary',
                    '{shipping_address}' => 'Shipping Address',

                    // Actions
                    '{order_url}' => 'Order Details URL',

                    // Support
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'order-shipped' => [
                'label' => 'Order Shipped',
                'icon' => 'fa fa-truck',
                'desc' => 'Sent when the order is dispatched from the warehouse with tracking details.',
                'default_subject' => 'Your order #{order_id} is on the way 🚚',
                'default_preview' => 'Track your shipment with the details inside.',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Your order <strong>#{order_id}</strong> has been shipped!</p>
<p>Courier: <strong>{courier_name}</strong><br>AWB Number: <strong>{awb_number}</strong><br>Expected: <strong>{expected_delivery}</strong></p>
<a href="{tracking_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Track Order</a>
<p>Team {brand_name}</p>',
                'vars' => [

                    // Customer
                    '{customer_name}' => 'Customer Name',

                    // Store (Global Variables)
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',

                    // Order
                    '{order_number}' => 'Order Number',
                    '{shipped_date}' => 'Shipped Date',
                    '{grand_total}' => 'Order Total',

                    // Shipment
                    '{courier_name}' => 'Courier Name',
                    '{tracking_number}' => 'Tracking Number',
                    '{tracking_url}' => 'Tracking URL',
                    '{expected_delivery}' => 'Expected Delivery',

                    // Payment
                    '{payment_method}' => 'Payment Method',
                    '{payment_status}' => 'Payment Status',

                    // Dynamic Blocks
                    '{order_items}' => 'Order Items',
                    '{shipping_address}' => 'Shipping Address',

                    // Actions
                    '{order_url}' => 'Order Details URL',

                    // Support (Global Variables)
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'order-delivered' => [
                'label' => 'Order Delivered',
                'icon' => 'fa fa-box-open',
                'desc' => 'Sent when delivery is confirmed by the courier or customer.',
                'default_subject' => 'Your order #{order_id} has arrived! ⭐',
                'default_preview' => 'We hope you love your order. Leave us a review!',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Your order <strong>#{order_id}</strong> has been delivered. We hope you love it!</p>
<p>It would mean a lot if you shared your feedback.</p>
<a href="{review_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Rate Your Experience</a>
<p>Team {brand_name}</p>',
                'vars' => [

                    // Customer
                    '{customer_name}' => 'Customer Name',

                    // Store (Global Variables)
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',

                    // Order
                    '{order_number}' => 'Order Number',
                    '{delivered_date}' => 'Delivered Date',
                    '{grand_total}' => 'Order Total',
                    '{item_count}' => 'Item Count',

                    // Payment
                    '{payment_method}' => 'Payment Method',
                    '{payment_status}' => 'Payment Status',

                    // Dynamic Blocks
                    '{order_items}' => 'Delivered Items',
                    '{shipping_address}' => 'Delivery Address',

                    // Actions
                    '{review_url}' => 'Review URL',
                    '{order_url}' => 'Order Details URL',
                    '{return_url}' => 'Return Request URL',

                    // Support (Global Variables)
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'order-cancelled' => [
                'label' => 'Order Cancelled',
                'icon' => 'fa fa-times-circle',
                'desc' => 'Sent when an order is cancelled, either by the customer or the store.',
                'default_subject' => 'Your order #{order_id} has been cancelled',
                'default_preview' => 'Your refund is being processed.',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Your order <strong>#{order_id}</strong> has been cancelled.</p>
<p>Reason: {cancel_reason}<br>Refund of <strong>{refund_amount}</strong> will be processed within {refund_days} business days.</p>
<p>Questions? Contact us anytime.<br>Team {brand_name}</p>',
                'vars' => [

                    // Customer
                    '{customer_name}' => 'Customer Name',

                    // Store (Global Variables)
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',

                    // Order
                    '{order_number}' => 'Order Number',

                    // Cancellation
                    '{cancel_reason}' => 'Cancellation Reason',
                    '{refund_amount}' => 'Refund Amount',
                    '{refund_days}' => 'Refund Processing Days',

                    // Dynamic Blocks
                    '{shipping_address}' => 'Shipping Address',

                    // Support (Global Variables)
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],


                'extras' => null,
                'audience' => 'customer',
            ],
            'payment-received' => [
                'label' => 'Payment Received',
                'icon' => 'fa fa-credit-card',
                'desc' => 'Sent when a payment is successfully processed.',
                'default_subject' => 'Payment receipt for order #{order_number}',
                'default_preview' => 'Your payment has been received successfully.',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Payment of <strong>{payment_amount}</strong> received for order <strong>#{order_number}</strong>.</p>
<p>Method: {payment_method}<br>Transaction ID: <strong>{transaction_id}</strong></p>
<a href="{invoice_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Download Invoice</a>
<p>Thank you!<br>Team {brand_name}</p>',
                'vars' => [

                    // Customer
                    '{customer_name}' => 'Customer Name',

                    // Store (Global Variables)
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',

                    // Order
                    '{order_number}' => 'Order Number',
                    '{order_date}' => 'Order Date',
                    '{grand_total}' => 'Grand Total',

                    // Payment
                    '{payment_amount}' => 'Payment Amount',
                    '{payment_method}' => 'Payment Method',
                    '{payment_status}' => 'Payment Status',
                    '{transaction_id}' => 'Transaction ID',

                    // Smart HTML Blocks
                    '{order_items}' => 'Order Items',
                    '{order_summary}' => 'Order Summary',
                    '{shipping_address}' => 'Shipping Address',

                    // Actions
                    '{order_url}' => 'Order Details URL',
                    '{invoice_url}' => 'Invoice URL',

                    // Support
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'coupon' => [
                'label' => 'Coupon / Offer',
                'icon' => 'fa fa-tag',
                'desc' => 'Promotional email for coupon codes and special offers sent to opted-in customers.',
                'default_subject' => 'Exclusive offer just for you, {customer_name}! 🎁',
                'default_preview' => 'Use your coupon before it expires.',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Here\'s an exclusive offer just for you!</p>
<p style="font-size:22px;font-weight:700;letter-spacing:4px;color:#303d89">{coupon_code}</p>
<p>Get <strong>{discount_value}</strong> off your next order. Valid till <strong>{expiry_date}</strong>.</p>
<a href="{store_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Shop Now</a>
<p>Team {brand_name}</p>',
                'vars' => [
                    '{customer_name}' => 'Customer Name',
                    '{coupon_code}' => 'Coupon Code',
                    '{discount_value}' => 'Discount Value',
                    '{expiry_date}' => 'Expiry Date',
                    '{store_url}' => 'Store URL',
                    '{brand_name}' => 'Brand Name',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
            'password-reset' => [
                'label' => 'Password Reset',
                'icon' => 'fa fa-key',
                'desc' => 'Security email sent when a customer requests a password reset (OTP).',
                'default_subject' => 'Your {store_name} password reset code',
                'default_preview' => 'Use this OTP to reset your password. Expires in {otp_expiry} minutes.',
                'default_body' => '<p>Dear {customer_name},</p>
<p>Someone requested a password reset for your account at {store_name}. Use the OTP below to continue.</p>
<p style="font-size:32px;font-weight:700;letter-spacing:8px;color:#303d89">{otp}</p>
<p>Valid for <strong>{otp_expiry} minutes</strong>. Do not share this code with anyone.</p>
<p>If you did not request this, please ignore this email — your password will remain unchanged.</p>
<p>Team {brand_name}</p>',
                'vars' => [
                    '{customer_name}' => 'Customer Name',
                    '{email}' => 'Customer Email',
                    '{otp}' => 'OTP Code',
                    '{otp_expiry}' => 'OTP Expiry (min)',
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                    '{logo_url}' => 'Logo URL',
                    '{tagline}' => 'Store Tagline',
                    '{support_email}' => 'Support Email',
                    '{support_number}' => 'Support Number',
                ],
                'extras' => 'password-reset',
                'audience' => 'customer',
            ],
            'new-order-alert' => [
                'label' => 'New Order Alert (Admin)',
                'icon' => 'fa fa-bell',
                'desc' => 'Internal alert sent to the admin email on every new order.',
                'default_subject' => '🛒 New Order #{order_number} — {grand_total}',
                'default_preview' => 'A new order just came in.',
                'default_body' => '<p>A new order has been placed on your store.</p>
<table style="border-collapse:collapse;width:100%;font-size:14px">
<tr><td style="padding:8px;border:1px solid #e3e5e8"><strong>Order No.</strong></td><td style="padding:8px;border:1px solid #e3e5e8">#{order_number}</td></tr>
<tr><td style="padding:8px;border:1px solid #e3e5e8"><strong>Customer</strong></td><td style="padding:8px;border:1px solid #e3e5e8">{customer_name}</td></tr>
<tr><td style="padding:8px;border:1px solid #e3e5e8"><strong>Amount</strong></td><td style="padding:8px;border:1px solid #e3e5e8">{grand_total}</td></tr>
<tr><td style="padding:8px;border:1px solid #e3e5e8"><strong>Payment</strong></td><td style="padding:8px;border:1px solid #e3e5e8">{payment_method} — {payment_status}</td></tr>
<tr><td style="padding:8px;border:1px solid #e3e5e8"><strong>Date</strong></td><td style="padding:8px;border:1px solid #e3e5e8">{order_date}</td></tr>
</table>
<a href="{admin_order_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">View in Admin</a>',
                'vars' => [
                    '{order_number}' => 'Order Number',
                    '{customer_name}' => 'Customer Name',
                    '{grand_total}' => 'Order Amount',
                    '{payment_method}' => 'Payment Method',
                    '{payment_status}' => 'Payment Status',
                    '{transaction_id}' => 'Transaction ID',
                    '{order_date}' => 'Order Date',

                    // Smart HTML Blocks
                    '{order_items}' => 'Order Items',
                    '{order_summary}' => 'Order Summary',
                    '{shipping_address}' => 'Customer Address',

                    // Actions
                    '{order_url}' => 'Order Details URL',
                    '{admin_order_url}' => 'Admin Order URL',

                    // Store (Global Variables)
                    '{store_name}' => 'Store Name',
                    '{brand_name}' => 'Brand Name',
                ],
                'extras' => 'admin',
                'audience' => 'admin',
            ],
            'low-stock-alert' => [
                'label' => 'Low Stock Alert (Admin)',
                'icon' => 'fa fa-exclamation-triangle',
                'desc' => 'Internal digest alert sent to admin when products fall below stock thresholds.',
                'default_subject' => '⚠️ Stock Alert — {total_count} products need attention',
                'default_preview' => 'Some products need restocking.',
                'default_body' => '<p>Stock alert for your store.</p>
<p><strong>{critical_count}</strong> critical, <strong>{low_count}</strong> low on stock.</p>
{critical_products}
{low_products}
<a href="{admin_stock_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0">Manage Stock</a>',
                'vars' => [
                    '{total_count}' => 'Total Products Affected',
                    '{critical_count}' => 'Critical Stock Count',
                    '{low_count}' => 'Low Stock Count',
                    '{critical_threshold}' => 'Critical Threshold',
                    '{low_threshold}' => 'Low Threshold',

                    // Smart HTML Blocks
                    '{critical_products}' => 'Critical Products Table',
                    '{low_products}' => 'Low Stock Products Table',

                    // Actions
                    '{admin_stock_url}' => 'Admin Stock URL',
                ],
                'extras' => 'admin',
                'audience' => 'admin',
            ],
        ];
    }

    /**
     * Nav badge — same logic as SmsTemplate::navBadge()
     */
    public function navBadge(): array
    {
        if ($this->enabled) {
            return ['class' => 'active-badge', 'label' => 'On'];
        }

        if (!empty($this->body)) {
            return ['class' => 'draft-badge', 'label' => 'Draft'];
        }

        return ['class' => 'off-badge', 'label' => 'Off'];
    }

    /**
     * Status badge HTML for the panel header.
     */
    public function statusBadgeHtml(): string
    {
        if ($this->enabled) {
            return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)">
                        <i class="fa fa-circle" style="font-size:7px;margin-right:4px"></i>Active
                    </span>';
        }

        if (!empty($this->body)) {
            return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)">Draft</span>';
        }

        return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--bg);color:var(--text-hint);border:1px solid var(--border)">Off</span>';
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceSetting;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
use App\Models\SmtpSetting;
use App\Models\PaymentSetting;
use App\Models\Setting;
use App\Models\Courier;
use App\Models\GoogleSetting;

class AdminSettingController extends Controller
{
    // ðŸ”¹ Show form
    public function index(Request $request)
    {
        $invoice_setting = InvoiceSetting::first();
        $smtp = SmtpSetting::first();
        $payment = PaymentSetting::first();
        $general = Setting::first();
        $states = State::all();
        $couriers = Courier::latest()->get();
        $activeTab = $request->tab ?? 'general';
        
         $google_setting = GoogleSetting::current(); // 👈 new

        return view(
            'admin.admin-settings.index',
            compact(
                'invoice_setting',
                'smtp',
                'payment',
                'general',
                'states',
                'couriers',
                'google_setting',
                'activeTab'
            )
        );
    }

    // ðŸ”¹ Save settings
    public function invoiceSettingStore(Request $request)
    {
        $rules = [
            // Company
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_state' => 'required|exists:states,id',
            'company_city' => 'required|exists:cities,id',
            'company_pincode' => 'required|string|max:10',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            // Invoice
            'invoice_prefix' => 'required|string|max:20',
            'invoice_serial' => 'required|integer|min:1',
            'invoice_year_format' => 'nullable|in:none,slash,year',
            'invoice_separator' => 'nullable|string|max:5',
            'invoice_date_format' => 'nullable|in:d/m/Y,d M Y,m-d-Y',
            // Tax
            'tax_type' => 'nullable|in:inclusive,exclusive',
            'business_type' => 'nullable|in:registered,unregistered',
            // Footer
            'terms_conditions' => 'nullable|string',
        ];

        // GST Validation Only For Registered
        if ($request->business_type == 'registered') {
            $rules['company_gstin'] = 'required|string|max:15';
            $rules['company_pan'] = 'required|string|max:10';
            $rules['cgst'] = 'required|numeric|min:0|max:100';
            $rules['sgst'] = 'required|numeric|min:0|max:100';
            $rules['igst'] = 'required|numeric|min:0|max:100';
        }

        $validated = $request->validate($rules);

        // Checkboxes
        $validated['show_gst_breakup'] =
            $request->has('show_gst_breakup');
        $validated['auto_generate_invoice'] =
            $request->has('auto_generate_invoice');
        $validated['email_invoice_customer'] =
            $request->has('email_invoice_customer');

        // Unregistered Business
        if ($request->business_type == 'unregistered') {
            $validated['company_gstin'] = null;
            $validated['company_pan'] = null;
            $validated['cgst'] = 0;
            $validated['sgst'] = 0;
            $validated['igst'] = 0;
            $validated['show_gst_breakup'] = 0;
        }

        // Logo Upload
        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request
                ->file('company_logo')
                ->store('company', 'public');
        }

        InvoiceSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()
            ->route('admin.admin-setting.index', ['tab' => 'gst'])
            ->with('success', 'Invoice & GST settings updated successfully.');
    }

    // ðŸ”¥ Generate Invoice Number (SAFE VERSION)
    public static function generateInvoiceNumber()
    {
        return DB::transaction(function () {
            $setting = InvoiceSetting::lockForUpdate()->first();

            if (!$setting) {
                return 'INV/00001';
            }

            $serial = $setting->invoice_serial;
            $year = now()->year;
            $nextYear = substr($year + 1, -2);

            $yearPart = '';
            switch ($setting->invoice_year_format) {
                case 'slash':
                    $yearPart = $year . '-' . $nextYear;
                    break;
                case 'year':
                    $yearPart = $year;
                    break;
                case 'none':
                default:
                    $yearPart = '';
                    break;
            }

            $parts = [];
            if (!empty($setting->invoice_prefix)) {
                $parts[] = $setting->invoice_prefix;
            }
            if (!empty($yearPart)) {
                $parts[] = $yearPart;
            }
            $parts[] = str_pad($serial, 5, '0', STR_PAD_LEFT);

            $invoiceNumber = implode(
                $setting->invoice_separator ?: '/',
                $parts
            );

            // increment next invoice number
            $setting->increment('invoice_serial');

            return $invoiceNumber;
        });
    }

    public function getCities(Request $request)
    {
        return City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function smtpSettingStore(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string',
            'smtp_encryption' => 'required|in:tls,ssl,none',
            'from_name' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
            'reply_to_name' => 'nullable|string|max:255',
            'reply_to_email' => 'nullable|email|max:255',
        ]);

        $validated['order_confirmation']
            = $request->has('order_confirmation');
        $validated['order_shipped']
            = $request->has('order_shipped');
        $validated['order_delivered']
            = $request->has('order_delivered');
        $validated['password_reset']
            = $request->has('password_reset');
        $validated['new_order_alert']
            = $request->has('new_order_alert');
        $validated['low_stock_alert']
            = $request->has('low_stock_alert');

        SmtpSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'SMTP settings saved successfully.'
        );
    }

    public function paymentSettingStore(Request $request)
    {
        $validated = $request->validate([
            'test_key_id' => 'nullable|string|max:255',
            'test_key_secret' => 'nullable|string',
            'live_key_id' => 'nullable|string|max:255',
            'live_key_secret' => 'nullable|string',
        ]);

        $validated['live_mode'] = $request->has('live_mode');

        PaymentSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'Payment settings saved successfully.'
        );
    }

    public function generalSettingStore(Request $request)
    {
        $general = Setting::first();

        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'business_address' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:100',
            'header_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico,webp|max:1024',
            'admin_login_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'admin_dashboard_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $validated['maintenance_mode']
            = $request->has('maintenance_mode');
        $validated['product_reviews']
            = $request->has('product_reviews');
        $validated['wishlist']
            = $request->has('wishlist');
        $validated['stock_alerts']
            = $request->has('stock_alerts');
        $validated['cod_enabled']
            = $request->has('cod_enabled');

        // Header Logo
        if ($request->hasFile('header_logo')) {
            if ($general && $general->header_logo && Storage::disk('public')->exists($general->header_logo)) {
                Storage::disk('public')->delete($general->header_logo);
            }
            $validated['header_logo'] = $request->file('header_logo')->store('settings', 'public');
        }

        // Footer Logo
        if ($request->hasFile('footer_logo')) {
            if ($general && $general->footer_logo && Storage::disk('public')->exists($general->footer_logo)) {
                Storage::disk('public')->delete($general->footer_logo);
            }
            $validated['footer_logo'] = $request->file('footer_logo')->store('settings', 'public');
        }

        // Favicon
        if ($request->hasFile('favicon')) {
            if ($general && $general->favicon && Storage::disk('public')->exists($general->favicon)) {
                Storage::disk('public')->delete($general->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // Admin Login Page Logo
        if ($request->hasFile('admin_login_logo')) {
            if ($general && $general->admin_login_logo && Storage::disk('public')->exists($general->admin_login_logo)) {
                Storage::disk('public')->delete($general->admin_login_logo);
            }
            $validated['admin_login_logo'] = $request->file('admin_login_logo')->store('settings', 'public');
        }

        // Admin Dashboard Logo
        if ($request->hasFile('admin_dashboard_logo')) {
            if ($general && $general->admin_dashboard_logo && Storage::disk('public')->exists($general->admin_dashboard_logo)) {
                Storage::disk('public')->delete($general->admin_dashboard_logo);
            }
            $validated['admin_dashboard_logo'] = $request->file('admin_dashboard_logo')->store('settings', 'public');
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'General settings updated successfully.'
        );
    }

    public function courierStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        $validated['is_active'] =
            $request->has('is_active');

        Courier::updateOrCreate(
            ['id' => $request->id],
            $validated
        );

        return redirect()
            ->route(
                'admin.admin-setting.index',
                ['tab' => 'couriers']
            )
            ->with(
                'success',
                'Courier saved successfully.'
            );
    }

    public function courierDelete(Courier $courier)
    {
        $courier->delete();

        return redirect()
            ->route(
                'admin.admin-setting.index',
                ['tab' => 'couriers']
            )
            ->with(
                'success',
                'Courier deleted successfully.'
            );
    }
    
    public function googleSettingStore(Request $request)
    {
        $request->validate([
            'gtm_container_id' => 'nullable|string|max:50',
            'ga4_measurement_id' => 'nullable|string|max:50',
            'gads_conversion_id' => 'nullable|string|max:50',
            'meta_pixel_id' => 'nullable|string|max:50',
            'gsc_verify_method' => 'nullable|in:meta,file,dns',
            'gads_currency' => 'nullable|string|max:5',
        ]);

        $checkboxFields = [
            'gtm_enabled',
            'gtm_all_pages',
            'gtm_datalayer_events',
            'ga4_enabled',
            'ga4_ev_view_item',
            'ga4_ev_add_to_cart',
            'ga4_ev_remove_from_cart',
            'ga4_ev_begin_checkout',
            'ga4_ev_add_payment',
            'ga4_ev_purchase',
            'ga4_ev_refund',
            'ga4_ev_search',
            'ga4_ev_login',
            'ga4_ev_sign_up',
            'gads_enabled',
            'gads_enhanced_conversions',
            'gads_send_order_value',
            'gsc_auto_sitemap',
            'meta_enabled',
            'meta_ev_page_view',
            'meta_ev_view_content',
            'meta_ev_add_to_cart',
            'meta_ev_add_to_wishlist',
            'meta_ev_initiate_checkout',
            'meta_ev_add_payment',
            'meta_ev_purchase',
            'meta_ev_lead',
            'meta_ev_complete_reg',
            'meta_ev_search',
            'meta_advanced_matching',
        ];

        $data = $request->except(['_token']);

        foreach ($checkboxFields as $field) {
            $data[$field] = $request->boolean($field);
        }

        GoogleSetting::updateOrCreate(['id' => 1], $data);

        return redirect()
            ->route('admin.admin-setting.index', ['tab' => 'tracking'])
            ->with('success', 'Tracking settings saved successfully.');
    }
    
}
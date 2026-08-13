<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = [

        'company_name',
        'company_logo',
        'company_address',
        'company_phone',
        'company_email',

        'company_gstin',
        'company_pan',

        'company_state',
        'company_city',
        'company_pincode',

        'cgst',
        'sgst',
        'igst',

        'tax_type',
        'business_type',
        'show_gst_breakup',

        'invoice_prefix',
        'invoice_serial',
        'invoice_year_format',
        'invoice_separator',
        'invoice_date_format',

        'auto_generate_invoice',
        'email_invoice_customer',

        'terms_conditions',
    ];

    protected $casts = [

        'show_gst_breakup' => 'boolean',
        'auto_generate_invoice' => 'boolean',
        'email_invoice_customer' => 'boolean',

        'cgst' => 'decimal:2',
        'sgst' => 'decimal:2',
        'igst' => 'decimal:2',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'company_state');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'company_city');
    }
}
<?php
namespace App\Exports;

use App\Models\CouponEnquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CouponEnquiriesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return CouponEnquiry::latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'Email', 'Country Code', 'Phone', 'WhatsApp Optin', 'Status', 'Date'];
    }

    public function map($enquiry): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $enquiry->email,
            $enquiry->country_code,
            $enquiry->phone,
            $enquiry->whatsapp_optin ? 'Yes' : 'No',
            ucfirst($enquiry->status),
            $enquiry->created_at->format('d M Y, h:i A'),
        ];
    }
}
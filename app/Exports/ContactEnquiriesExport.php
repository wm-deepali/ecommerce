<?php

namespace App\Exports;

use App\Models\ContactEnquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContactEnquiriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return ContactEnquiry::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Email', 'Mobile', 'Inquiry Type', 'Message', 'Date'];
    }

    public function map($item): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $item->name,
            $item->email,
            $item->mobile ?? '—',
            $item->inquiry_type ?? '—',
            $item->message ?? '—',
            $item->created_at->format('d M Y h:i A'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF303D89']],
            ],
        ];
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierEnquiry;
use App\Exports\SupplierEnquiriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class SupplierEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = SupplierEnquiry::with('category')->latest()->paginate(10);

        return view('admin.supplier-enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = SupplierEnquiry::with('category')->findOrFail($id);

        return view('admin.supplier-enquiries.show', compact('enquiry'));
    }

    public function destroy($id)
    {
        SupplierEnquiry::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }


    public function export()
    {
        $filename = 'bulk_order_enquiries_' . now()->format('Y_m_d_His') . '.xlsx';
        return Excel::download(new SupplierEnquiriesExport(), $filename);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No records selected.'], 422);
        }

        $deleted = SupplierEnquiry::whereIn('id', $ids)->delete();

        return response()->json(['message' => $deleted . ' enquiries deleted successfully.']);
    }
}
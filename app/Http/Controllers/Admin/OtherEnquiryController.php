<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralEnquiry;
use App\Exports\OtherEnquiriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class OtherEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = GeneralEnquiry::latest()->paginate(10);

        return view('admin.other-enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = GeneralEnquiry::findOrFail($id);

        return view('admin.other-enquiries.show', compact('enquiry'));
    }

    public function destroy($id)
    {
        GeneralEnquiry::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }


    public function export()
    {
        $filename = 'manage_enquiries_' . now()->format('Y_m_d_His') . '.xlsx';
        return Excel::download(new OtherEnquiriesExport(), $filename);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No records selected.'], 422);
        }

        $deleted = GeneralEnquiry::whereIn('id', $ids)->delete();

        return response()->json(['message' => $deleted . ' enquiries deleted successfully.']);
    }
}
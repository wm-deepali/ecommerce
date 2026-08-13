<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Exports\ContactEnquiriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ContactEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = ContactEnquiry::latest()->paginate(10);

        return view('admin.contact-enquiries.index', compact('enquiries'));
    }

    public function show(ContactEnquiry $contactEnquiry)
    {
        return view(
            'admin.contact-enquiries.show',
            ['enquiry' => $contactEnquiry]
        );
    }


    public function export()
    {
        $filename = 'contact_enquiries_' . now()->format('Y_m_d_His') . '.xlsx';
        return Excel::download(new ContactEnquiriesExport(), $filename);
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No records selected.'], 422);
        }

        ContactEnquiry::whereIn('id', $ids)->delete();

        return response()->json(['message' => count($ids) . ' enquiries deleted successfully.']);
    }

    public function destroy(ContactEnquiry $contactEnquiry)
    {
        $contactEnquiry->delete();

        return response()->json([
            'status' => true,
            'message' => 'Enquiry deleted successfully.'
        ]);
    }
}
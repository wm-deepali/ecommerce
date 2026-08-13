<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorEnquiry;

class VendorEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = VendorEnquiry::with('type')->latest()->paginate(10);

        return view('admin.vendor-enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = VendorEnquiry::with('type')->findOrFail($id);

        return view('admin.vendor-enquiries.show', compact('enquiry'));
    }

    public function destroy($id)
    {
        VendorEnquiry::findOrFail($id)->delete();

        return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
    }
}
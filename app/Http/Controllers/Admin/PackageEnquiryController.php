<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageEnquiry;

class PackageEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = PackageEnquiry::latest()->paginate(10);

        return view('admin.package-enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = PackageEnquiry::findOrFail($id);

        return view('admin.package-enquiries.show', compact('enquiry'));
    }

    public function destroy($id)
    {
        PackageEnquiry::findOrFail($id)->delete();

       return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
    }
}
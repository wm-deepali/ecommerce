<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeEnquiry;

class HomeEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = HomeEnquiry::latest()->paginate(10);

        return view('admin.home-enquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $enquiry = HomeEnquiry::findOrFail($id);

        return view('admin.home-enquiries.show', compact('enquiry'));
    }

   public function destroy($id)
{
    HomeEnquiry::findOrFail($id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
}
}
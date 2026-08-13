<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $enquiries = Enquiry::with('state','city')->latest()->get();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    // ✅ VIEW DETAILS
    public function show($id)
    {
        $enquiry = Enquiry::with([
            'items.product',
            'state',
            'city'
        ])->findOrFail($id);

        return view('admin.enquiries.show', compact('enquiry'));
    }

    // ❌ DELETE
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $enquiry->delete();

        return response()->json([
            'status' => true,
            'message' => 'Enquiry deleted successfully'
        ]);
    }
}
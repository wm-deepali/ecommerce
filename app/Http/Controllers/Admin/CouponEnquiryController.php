<?php
namespace App\Http\Controllers\Admin;

use App\Exports\CouponEnquiriesExport;
use App\Http\Controllers\Controller;
use App\Models\CouponEnquiry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CouponEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = CouponEnquiry::latest()->paginate(20);
        return view('admin.coupon-enquiries.index', compact('enquiries'));
    }

    public function destroy($id)
    {
        $enquiry = CouponEnquiry::findOrFail($id);
        $enquiry->delete();

        return response()->json([
            'status' => true,
            'message' => 'Enquiry deleted successfully.',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'status' => false,
                'message' => 'No enquiries selected.',
            ], 422);
        }

        CouponEnquiry::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => count($ids) . ' enquiries deleted successfully.',
        ]);
    }

    public function export()
    {
        return Excel::download(new CouponEnquiriesExport, 'coupon-enquiries-' . now()->format('Y-m-d') . '.xlsx');
    }
}
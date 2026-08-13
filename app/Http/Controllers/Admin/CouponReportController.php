<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CouponReportController extends Controller
{
    public function index(Request $request)
    {
        // ── Per-coupon redemption + savings (from real orders, paid only) ──
        $orderStats = Order::select(
                'coupon_code',
                DB::raw('COUNT(*) as redemptions'),
                DB::raw('SUM(discount) as total_savings')
            )
            ->whereNotNull('coupon_code')
            ->where('coupon_code', '!=', '')
            ->where('payment_status', 'paid')
            ->groupBy('coupon_code')
            ->get()
            ->keyBy('coupon_code');

        // ── Top-level summary cards (always global, not affected by table filters) ──
        $totalCoupons   = Coupon::count();
        $activeCoupons  = Coupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })->count();
        $inactiveCoupons = Coupon::where('status', 0)->count();

        $totalRedemptions = (clone $orderStats)->sum('redemptions');
        $monthRedemptions = Order::whereNotNull('coupon_code')
            ->where('coupon_code', '!=', '')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $totalDiscountGiven = (clone $orderStats)->sum('total_savings');
        $monthDiscountGiven = Order::whereNotNull('coupon_code')
            ->where('coupon_code', '!=', '')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('discount');

        $avgDiscountPerUse = $totalRedemptions > 0 ? $totalDiscountGiven / $totalRedemptions : 0;

        // ── Leaderboards (global top 5, not affected by table filters) ──
        $couponsByCode = Coupon::pluck('discount_type', 'code')
            ->merge(Coupon::pluck('discount_value', 'code'))
            ; // fallback not used directly, we'll map below

        $allCoupons = Coupon::all()->keyBy('code');

        $mostUsed = $orderStats->sortByDesc('redemptions')->take(5)->map(function ($row) use ($allCoupons) {
            $coupon = $allCoupons->get($row->coupon_code);
            return (object) [
                'code'        => $row->coupon_code,
                'redemptions' => $row->redemptions,
                'total_savings' => $row->total_savings,
                'coupon'      => $coupon,
            ];
        })->values();

        $mostSavings = $orderStats->sortByDesc('total_savings')->take(5)->map(function ($row) use ($allCoupons) {
            $coupon = $allCoupons->get($row->coupon_code);
            return (object) [
                'code'        => $row->coupon_code,
                'redemptions' => $row->redemptions,
                'total_savings' => $row->total_savings,
                'coupon'      => $coupon,
            ];
        })->values();

        // ── Filtered detail table ──
        $query = Coupon::query();

        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $today = now();
            switch ($request->status) {
                case 'active':
                    $query->where('status', 1)
                        ->where(function ($q) use ($today) {
                            $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
                        });
                    break;
                case 'inactive':
                    $query->where('status', 0);
                    break;
                case 'expired':
                    $query->whereNotNull('end_date')->where('end_date', '<', $today);
                    break;
            }
        }

        $coupons = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Attach live redemption/savings stats to each coupon on this page
        $coupons->getCollection()->transform(function ($coupon) use ($orderStats) {
            $stat = $orderStats->get($coupon->code);
            $coupon->redemptions_count = $stat->redemptions ?? 0;
            $coupon->savings_total = $stat->total_savings ?? 0;
            $coupon->computed_status = $this->resolveStatus($coupon);
            return $coupon;
        });

        return view('admin.reports.coupon-reports', [
            'stats' => [
                'total_coupons'        => $totalCoupons,
                'active_coupons'       => $activeCoupons,
                'inactive_coupons'     => $inactiveCoupons,
                'total_redemptions'    => $totalRedemptions,
                'month_redemptions'    => $monthRedemptions,
                'total_discount'       => $totalDiscountGiven,
                'month_discount'       => $monthDiscountGiven,
                'avg_discount_per_use' => $avgDiscountPerUse,
            ],
            'mostUsed'    => $mostUsed,
            'mostSavings' => $mostSavings,
            'coupons'     => $coupons,
        ]);
    }

    public function export(Request $request)
    {
        $coupons = Coupon::orderByDesc('id')->get();

        $orderStats = Order::select(
                'coupon_code',
                DB::raw('COUNT(*) as redemptions'),
                DB::raw('SUM(discount) as total_savings')
            )
            ->whereNotNull('coupon_code')
            ->where('coupon_code', '!=', '')
            ->where('payment_status', 'paid')
            ->groupBy('coupon_code')
            ->get()
            ->keyBy('coupon_code');

        $filename = 'coupon-report-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($coupons, $orderStats) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Code', 'Type', 'Value', 'Min Order', 'Max Discount', 'Redemptions', 'Usage Limit', 'Total Savings', 'Start Date', 'End Date', 'Status']);

            foreach ($coupons as $coupon) {
                $stat = $orderStats->get($coupon->code);
                fputcsv($handle, [
                    $coupon->code,
                    $coupon->discount_type,
                    $coupon->discount_value,
                    $coupon->minimum_order_amount,
                    $coupon->maximum_discount,
                    $stat->redemptions ?? 0,
                    $coupon->usage_limit,
                    $stat->total_savings ?? 0,
                    optional($coupon->start_date)->format('d M Y'),
                    optional($coupon->end_date)->format('d M Y'),
                    $this->resolveStatus($coupon),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function resolveStatus(Coupon $coupon): string
    {
        if ((int) $coupon->status === 0) {
            return 'inactive';
        }

        if ($coupon->end_date && Carbon::parse($coupon->end_date)->lt(now())) {
            return 'expired';
        }

        return 'active';
    }
    
}
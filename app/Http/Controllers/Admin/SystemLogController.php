<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use App\Models\EmailLog;
use App\Models\PaymentLog;
use App\Models\AuthLog;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $emailQuery = EmailLog::query()->latest();

        if ($request->filled('email_status')) {
            $emailQuery->where('status', $request->email_status);
        }

        if ($request->filled('email_event')) {
            $emailQuery->where('event_key', $request->email_event);
        }

        if ($request->filled('email_search')) {
            $search = $request->email_search;
            $emailQuery->where(function ($q) use ($search) {
                $q->where('to_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $emailLogs = $emailQuery->paginate(20)->withQueryString();

        $emailStats = [
            'total'   => EmailLog::count(),
            'failed'  => EmailLog::where('status', 'failed')->count(),
            'blocked' => EmailLog::where('status', 'blocked')->count(),
        ];

        $paymentQuery = PaymentLog::query()->latest();

        if ($request->filled('payment_status')) {
            $paymentQuery->where('status', $request->payment_status);
        }

        if ($request->filled('payment_gateway')) {
            $paymentQuery->where('gateway', $request->payment_gateway);
        }

        if ($request->filled('payment_search')) {
            $search = $request->payment_search;
            $paymentQuery->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('payment_id', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $paymentLogs = $paymentQuery->paginate(20)->withQueryString();

        $paymentStats = [
            'total'    => PaymentLog::count(),
            'captured' => PaymentLog::where('status', 'captured')->count(),
            'failed'   => PaymentLog::where('status', 'failed')->count(),
            'pending'  => PaymentLog::whereIn('status', ['created', 'pending'])->count(),
        ];

        $authQuery = AuthLog::query()->latest();

        if ($request->filled('auth_event')) {
            $authQuery->where('event', $request->auth_event);
        }

        if ($request->filled('auth_user_type')) {
            $authQuery->where('user_type', $request->auth_user_type);
        }

        if ($request->filled('auth_search')) {
            $search = $request->auth_search;
            $authQuery->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $authLogs = $authQuery->paginate(20)->withQueryString();

        $authStats = [
            'total'  => AuthLog::count(),
            'failed' => AuthLog::where('status', 'failed')->count(),
            'admin'  => AuthLog::where('user_type', 'admin')->count(),
        ];

        $orderEventQuery = OrderStatusHistory::query()->with('order')->latest();

        if ($request->filled('order_status')) {
            $orderEventQuery->where('status', $request->order_status);
        }

        if ($request->filled('order_search')) {
            $search = $request->order_search;
            $orderEventQuery->where(function ($q) use ($search) {
                $q->where('remarks', 'like', "%{$search}%")
                  ->orWhereHas('order', function ($oq) use ($search) {
                      $oq->where('order_number', 'like', "%{$search}%")
                         ->orWhere('customer_name', 'like', "%{$search}%");
                  });
            });
        }

        $orderEvents = $orderEventQuery->paginate(20)->withQueryString();

        $orderEventStats = [
            'total'     => OrderStatusHistory::count(),
            'cancelled' => OrderStatusHistory::where('status', 'cancelled')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | API Logs (Razorpay, reCAPTCHA, and any future outbound service calls)
        |--------------------------------------------------------------------------
        */
        $apiQuery = ApiLog::query()->latest();

        if ($request->filled('api_method')) {
            $apiQuery->where('method', $request->api_method);
        }

        if ($request->filled('api_service')) {
            $apiQuery->where('service', $request->api_service);
        }

        if ($request->filled('api_status')) {
            match ($request->api_status) {
                '2xx' => $apiQuery->whereBetween('status_code', [200, 299]),
                '4xx' => $apiQuery->whereBetween('status_code', [400, 499]),
                '5xx' => $apiQuery->whereBetween('status_code', [500, 599]),
                default => null,
            };
        }

        if ($request->filled('api_search')) {
            $search = $request->api_search;
            $apiQuery->where(function ($q) use ($search) {
                $q->where('endpoint', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('service', 'like', "%{$search}%");
            });
        }

        $apiLogs = $apiQuery->paginate(20)->withQueryString();

        $apiStats = [
            'total'  => ApiLog::count(),
            'failed' => ApiLog::where(function ($q) {
                $q->whereNull('status_code')
                  ->orWhere('status_code', '>=', 400)
                  ->orWhereNotNull('error_message');
            })->count(),
        ];

        // Distinct services for the filter dropdown — grows automatically as
        // new integrations start writing to api_logs.
        $apiServices = ApiLog::query()
            ->whereNotNull('service')
            ->distinct()
            ->orderBy('service')
            ->pluck('service');

       /*
        |--------------------------------------------------------------------------
        | All Logs (unified feed — unions Email/Payment/Auth/Order/API logs)
        |--------------------------------------------------------------------------
        */
        $allChannel = $request->input('all_channel');   // Payment | Email | API | Order | Auth
        $allLevel   = $request->input('all_level');      // Success | Info | Warning | Error
        $allSearch  = $request->input('all_search');
        $allFrom    = $request->input('all_date_from');
        $allTo      = $request->input('all_date_to');

        $subQueries = [];

        // ── Email ──
        if (!$allChannel || $allChannel === 'Email') {
            $q = DB::table('email_logs')->select(
                'id',
                DB::raw("'email' as log_type"),
                'created_at',
                DB::raw("'Email' as channel"),
                DB::raw("CASE status
                            WHEN 'sent' THEN 'Success'
                            WHEN 'blocked' THEN 'Warning'
                            ELSE 'Error' END as level"),
                DB::raw("CONCAT(COALESCE(subject, ''), ' — ', event_key) as message"),
                DB::raw("COALESCE(reference, '—') as reference"),
                DB::raw("to_email as ip_or_user")
            );
            if ($allSearch) {
                $q->where(function ($w) use ($allSearch) {
                    $w->where('to_email', 'like', "%{$allSearch}%")
                      ->orWhere('subject', 'like', "%{$allSearch}%")
                      ->orWhere('reference', 'like', "%{$allSearch}%");
                });
            }
            if ($allFrom) $q->whereDate('created_at', '>=', $allFrom);
            if ($allTo)   $q->whereDate('created_at', '<=', $allTo);
            if ($allLevel) $q->having('level', $allLevel);
            $subQueries[] = $q;
        }

        // ── Payment ──
        if (!$allChannel || $allChannel === 'Payment') {
            $q = DB::table('payment_logs')->select(
                'id',
                DB::raw("'payment' as log_type"),
                'created_at',
                DB::raw("'Payment' as channel"),
                DB::raw("CASE status
                            WHEN 'captured' THEN 'Success'
                            WHEN 'refunded' THEN 'Info'
                            WHEN 'failed' THEN 'Error'
                            ELSE 'Warning' END as level"),
                DB::raw("CONCAT('Payment ', status, ' — ', COALESCE(order_number, CONCAT('#', order_id)), ' · ₹', amount) as message"),
                DB::raw("COALESCE(payment_id, '—') as reference"),
                DB::raw("COALESCE(customer_name, customer_email, '—') as ip_or_user")
            );
            if ($allSearch) {
                $q->where(function ($w) use ($allSearch) {
                    $w->where('order_number', 'like', "%{$allSearch}%")
                      ->orWhere('payment_id', 'like', "%{$allSearch}%")
                      ->orWhere('customer_email', 'like', "%{$allSearch}%");
                });
            }
            if ($allFrom) $q->whereDate('created_at', '>=', $allFrom);
            if ($allTo)   $q->whereDate('created_at', '<=', $allTo);
            if ($allLevel) $q->having('level', $allLevel);
            $subQueries[] = $q;
        }

        // ── Auth ──
        if (!$allChannel || $allChannel === 'Auth') {
            $q = DB::table('auth_logs')->select(
                'id',
                DB::raw("'auth' as log_type"),
                'created_at',
                DB::raw("'Auth' as channel"),
                DB::raw("CASE status WHEN 'success' THEN 'Success' ELSE 'Error' END as level"),
                DB::raw("CONCAT(REPLACE(event, '_', ' '), ' — ', COALESCE(email, 'unknown')) as message"),
                DB::raw("COALESCE(ip_address, '—') as reference"),
                DB::raw("COALESCE(ip_address, '—') as ip_or_user")
            );
            if ($allSearch) {
                $q->where(function ($w) use ($allSearch) {
                    $w->where('email', 'like', "%{$allSearch}%")
                      ->orWhere('ip_address', 'like', "%{$allSearch}%");
                });
            }
            if ($allFrom) $q->whereDate('created_at', '>=', $allFrom);
            if ($allTo)   $q->whereDate('created_at', '<=', $allTo);
            if ($allLevel) $q->having('level', $allLevel);
            $subQueries[] = $q;
        }

        // ── Order events ──
        if (!$allChannel || $allChannel === 'Order') {
            $q = DB::table('order_status_histories as osh')
                ->leftJoin('orders as o', 'o.id', '=', 'osh.order_id')
                ->select(
                    'osh.id',
                    DB::raw("'order' as log_type"),
                    'osh.created_at',
                    DB::raw("'Order' as channel"),
                    DB::raw("CASE osh.status
                                WHEN 'cancelled' THEN 'Error'
                                WHEN 'refunded' THEN 'Warning'
                                WHEN 'pending' THEN 'Info'
                                ELSE 'Success' END as level"),
                    DB::raw("CONCAT('Order status changed to ', REPLACE(osh.status, '_', ' ')) as message"),
                    DB::raw("COALESCE(o.order_number, CONCAT('#', osh.order_id)) as reference"),
                    DB::raw("COALESCE(osh.triggered_by, 'System') as ip_or_user")
                );
            if ($allSearch) {
                $q->where(function ($w) use ($allSearch) {
                    $w->where('osh.remarks', 'like', "%{$allSearch}%")
                      ->orWhere('o.order_number', 'like', "%{$allSearch}%")
                      ->orWhere('o.customer_name', 'like', "%{$allSearch}%");
                });
            }
            if ($allFrom) $q->whereDate('osh.created_at', '>=', $allFrom);
            if ($allTo)   $q->whereDate('osh.created_at', '<=', $allTo);
            if ($allLevel) $q->having('level', $allLevel);
            $subQueries[] = $q;
        }

        // ── API ──
        if (!$allChannel || $allChannel === 'API') {
            $q = DB::table('api_logs')->select(
                'id',
                DB::raw("'api' as log_type"),
                'created_at',
                DB::raw("'API' as channel"),
                DB::raw("CASE
                            WHEN status_code IS NULL OR status_code >= 500 THEN 'Error'
                            WHEN status_code >= 400 THEN 'Warning'
                            ELSE 'Success' END as level"),
                DB::raw("CONCAT(method, ' ', endpoint, ' (', service, ')') as message"),
                DB::raw("COALESCE(status_code, 'ERR') as reference"),
                DB::raw("COALESCE(ip_address, '—') as ip_or_user")
            );
            if ($allSearch) {
                $q->where(function ($w) use ($allSearch) {
                    $w->where('endpoint', 'like', "%{$allSearch}%")
                      ->orWhere('ip_address', 'like', "%{$allSearch}%")
                      ->orWhere('service', 'like', "%{$allSearch}%");
                });
            }
            if ($allFrom) $q->whereDate('created_at', '>=', $allFrom);
            if ($allTo)   $q->whereDate('created_at', '<=', $allTo);
            if ($allLevel) $q->having('level', $allLevel);
            $subQueries[] = $q;
        }

        $union = array_shift($subQueries);
        foreach ($subQueries as $sq) {
            $union->unionAll($sq);
        }

        $allLogs = DB::table(DB::raw("({$union->toSql()}) as all_logs"))
            ->mergeBindings($union)
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $allLogsTotal = EmailLog::count() + PaymentLog::count() + AuthLog::count()
            + OrderStatusHistory::count() + ApiLog::count();

        return view('admin.security.system-logs', compact(
            'emailLogs', 'emailStats', 'paymentLogs', 'paymentStats', 'authLogs', 'authStats',
            'orderEvents', 'orderEventStats', 'apiLogs', 'apiStats', 'apiServices',
            'allLogs', 'allLogsTotal'
        ));
    }
}
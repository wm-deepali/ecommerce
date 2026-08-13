<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('orders');

        $this->applyFilters($query, $request);

        // Stats (always unfiltered)
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', true)->count();
        $newThisMonth = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $verifiedEmails = Customer::whereNotNull('email_verified_at')->count();

        $customers = $query->latest()->paginate(25)->withQueryString();

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'newThisMonth',
            'verifiedEmails'
        ));
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'addresses.state',
            'addresses.city',
            'orders' => fn($q) => $q->latest()->limit(10),
            'orders.items',
        ]);

        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()->where('payment_status', 'paid')->sum('grand_total');
        $avgOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;
        $addressCount = $customer->addresses()->count();

        return view('admin.customers.show', compact(
            'customer',
            'totalOrders',
            'totalSpent',
            'avgOrderValue',
            'addressCount'
        ));
    }


    public function export(Request $request): StreamedResponse
    {
        $query = Customer::withCount('orders');

        $this->applyFilters($query, $request);

        $filename = 'customers-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'Name',
                'Email',
                'Mobile',
                'Status',
                'Email Verified',
                'Orders Count',
                'Total Spent',
                'Joined Date',
            ]);

            $query->chunk(200, function ($customers) use ($handle) {

                foreach ($customers as $customer) {

                    $totalSpent = $customer->orders()
                        ->where('payment_status', 'paid')
                        ->sum('grand_total');

                    fputcsv($handle, [
                        $customer->id,
                        $customer->name,
                        $customer->email,
                        $customer->mobile,
                        $customer->status ? 'Active' : 'Inactive',
                        $customer->email_verified_at ? 'Yes' : 'No',
                        $customer->orders_count,
                        number_format($totalSpent, 2, '.', ''),
                        $customer->created_at->format('d M Y'),
                    ]);
                }
            });

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache',
            'Pragma' => 'no-cache',
        ]);
    }


    private function applyFilters($query, Request $request): void
    {
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('email_verified')) {
            $request->input('email_verified') == '1'
                ? $query->whereNotNull('email_verified_at')
                : $query->whereNull('email_verified_at');
        }

        if ($joined = $request->input('joined')) {
            match ($joined) {
                'this_month' => $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year),

                'last_3_months' => $query->where(
                    'created_at',
                    '>=',
                    now()->subMonths(3)
                ),

                default => null,
            };
        }
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
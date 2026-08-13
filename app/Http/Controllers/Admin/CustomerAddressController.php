<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\State;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerAddressController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerAddress::with(['customer', 'state', 'city']);

        $this->applyFilters($query, $request);


        // Stats — always from unfiltered table
        $totalAddresses = CustomerAddress::count();
        $defaultAddresses = CustomerAddress::where('is_default', true)->count();
        $uniqueCities = CustomerAddress::distinct('city_id')->count('city_id');
        $uniqueStates = CustomerAddress::distinct('state_id')->count('state_id');

        // States for filter dropdown
        $states = State::orderBy('name')->get();

        $addresses = $query->latest()->paginate(25)->withQueryString();

        return view('admin.customers.addresses', compact(
            'addresses',
            'totalAddresses',
            'defaultAddresses',
            'uniqueCities',
            'uniqueStates',
            'states'
        ));
    }


    public function export(Request $request): StreamedResponse
    {
        $query = CustomerAddress::with(['customer', 'state', 'city']);

        $this->applyFilters($query, $request);

        $filename = 'customer-addresses-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'Customer Name',
                'Customer Email',
                'Customer Mobile',
                'Address Type',
                'Default',
                'Address Line 1',
                'Address Line 2',
                'City',
                'State',
                'Pincode',
                'Created At',
            ]);

            $query->chunk(200, function ($addresses) use ($handle) {

                foreach ($addresses as $address) {

                    fputcsv($handle, [
                        $address->id,
                        $address->customer?->name ?? '',
                        $address->customer?->email ?? '',
                        $address->customer?->mobile ?? '',
                        ucfirst($address->address_type ?? 'Other'),
                        $address->is_default ? 'Yes' : 'No',
                        $address->address_line_1,
                        $address->address_line_2,
                        $address->city?->name ?? '',
                        $address->state?->name ?? '',
                        $address->pincode,
                        $address->created_at?->format('d M Y h:i A'),
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
                $q->whereHas(
                    'customer',
                    fn($cq) =>
                    $cq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                )
                    ->orWhereHas(
                        'city',
                        fn($cq) =>
                        $cq->where('name', 'like', "%{$search}%")
                    )
                    ->orWhere('pincode', 'like', "%{$search}%")
                    ->orWhere('address_line_1', 'like', "%{$search}%");
            });
        }

        if ($request->filled('address_type')) {
            $query->where('address_type', $request->input('address_type'));
        }

        if ($request->filled('is_default')) {
            $query->where('is_default', $request->input('is_default'));
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->input('state_id'));
        }
    }


    public function destroy(CustomerAddress $address)
    {
        $address->delete();
        return redirect()->route('admin.customers.addresses.index')
            ->with('success', 'Address deleted successfully.');
    }
}
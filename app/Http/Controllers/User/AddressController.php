<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    private function customer()
    {
        return Auth::guard('customer')->user();
    }

    private function findAddress(int $id): CustomerAddress
    {
        return CustomerAddress::where('customer_id', $this->customer()->id)
            ->findOrFail($id);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LIST
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * GET /user/addresses
     */
    public function index()
    {
        $customer  = $this->customer();
        $addresses = $customer->addresses()
            ->with(['state', 'city'])
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        $states = State::orderBy('name')->get();

        return view('user.address.index', compact('addresses', 'states'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * POST /user/addresses
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:120'],
            'phone'         => ['required', 'string', 'max:20'],
            'address_line_1'=> ['required', 'string', 'max:255'],
            'address_line_2'=> ['nullable', 'string', 'max:255'],
            'pincode'       => ['required', 'string', 'max:10'],
            'state_id'      => ['required', 'integer', 'exists:states,id'],
            'city_id'       => ['required', 'integer', 'exists:cities,id'],
            'address_type'  => ['required', 'in:home,office,other'],
            'is_default'    => ['nullable', 'boolean'],
        ]);

        $customer = $this->customer();

        DB::transaction(function () use ($customer, $data) {
            // If new address is set as default, unset all others first
            if (! empty($data['is_default'])) {
                $customer->addresses()->update(['is_default' => false]);
            }

            // First address is always default
            $isFirst = $customer->addresses()->count() === 0;

            $customer->addresses()->create([
                ...$data,
                'customer_id' => $customer->id,
                'is_default'  => $isFirst || ! empty($data['is_default']),
            ]);
        });

        return back()->with('success', 'Address added successfully.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EDIT (returns JSON for modal)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * GET /user/addresses/{address}/edit
     * Returns address data as JSON so the modal can pre-fill.
     */
    public function edit(int $id)
    {
        $address = $this->findAddress($id);

        return response()->json([
            'address' => $address,
            'cities'  => City::where('state_id', $address->state_id)->orderBy('name')->get(),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * PUT /user/addresses/{address}
     */
    public function update(Request $request, int $id)
    {
        $address = $this->findAddress($id);

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:120'],
            'phone'         => ['required', 'string', 'max:20'],
            'address_line_1'=> ['required', 'string', 'max:255'],
            'address_line_2'=> ['nullable', 'string', 'max:255'],
            'pincode'       => ['required', 'string', 'max:10'],
            'state_id'      => ['required', 'integer', 'exists:states,id'],
            'city_id'       => ['required', 'integer', 'exists:cities,id'],
            'address_type'  => ['required', 'in:home,office,other'],
            'is_default'    => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($address, $data) {
            if (! empty($data['is_default'])) {
                $address->customer->addresses()->update(['is_default' => false]);
            }

            $address->update([
                ...$data,
                'is_default' => ! empty($data['is_default']) || $address->is_default,
            ]);
        });

        return back()->with('success', 'Address updated successfully.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * DELETE /user/addresses/{address}
     */
    public function destroy(int $id)
    {
        $address  = $this->findAddress($id);
        $customer = $this->customer();

        if ($address->is_default) {
            return back()->with('error', 'Cannot delete your default address. Set another address as default first.');
        }

        $address->delete();

        // If only one left, make it default automatically
        $remaining = $customer->addresses()->count();
        if ($remaining === 1) {
            $customer->addresses()->first()->update(['is_default' => true]);
        }

        return back()->with('success', 'Address deleted.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SET DEFAULT
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * PATCH /user/addresses/{address}/default
     */
    public function setDefault(int $id)
    {
        $address  = $this->findAddress($id);
        $customer = $this->customer();

        DB::transaction(function () use ($customer, $address) {
            $customer->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back()->with('success', 'Default address updated.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CITIES BY STATE (AJAX)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * GET /user/addresses/cities?state_id=1
     */
    public function cities(Request $request)
    {
        $request->validate(['state_id' => ['required', 'integer', 'exists:states,id']]);

        return response()->json(
            City::where('state_id', $request->state_id)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}
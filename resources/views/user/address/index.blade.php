@extends('layouts.user-app')

@section('title', 'My Addresses')

@section('content')

<div class="aq-modern-content aq-address-page">
    <div class="aq-page-header">
        <h2>My Addresses</h2>
        <p>Manage your delivery and billing addresses.</p>
    </div>

    @php
        $typeIcons = [
            'home'   => 'fa-solid fa-house',
            'office' => 'fa-solid fa-building',
            'other'  => 'fa-solid fa-location-dot',
        ];
    @endphp

    <!-- Address Grid -->
    <div class="aq-address-grid">

        <!-- Add New -->
        <div class="aq-address-card aq-address-add-card"
             data-bs-toggle="modal"
             data-bs-target="#addressModal"
             onclick="openAddModal()">
            <div class="aq-add-icon"><i class="fa-solid fa-plus"></i></div>
            <h5>Add New Address</h5>
        </div>

        <!-- Address Cards -->
        @forelse ($addresses as $address)
            <div class="aq-address-card {{ $address->is_default ? 'default-address' : '' }}">

                <div class="aq-address-header">
                    <span class="aq-address-type">
                        <i class="{{ $typeIcons[$address->address_type] ?? 'fa-solid fa-location-dot' }}"></i>
                        {{ ucfirst($address->address_type) }}
                    </span>
                    @if ($address->is_default)
                        <span class="aq-address-badge">Default</span>
                    @endif
                </div>

                <h4 class="aq-address-name">{{ $address->name }}</h4>

                <p class="aq-address-details">
                    {{ $address->address_line_1 }}
                    @if ($address->address_line_2), {{ $address->address_line_2 }}@endif<br>
                    {{ $address->city?->name }}, {{ $address->state?->name }} – {{ $address->pincode }}
                </p>

                <p class="aq-address-phone">
                    <i class="fa-solid fa-phone"></i> {{ $address->phone }}
                </p>

                <div class="aq-address-actions">
                    {{-- Edit --}}
                    <button
                        class="aq-btn-action"
                        onclick="openEditModal({{ $address->id }})"
                        data-bs-toggle="modal"
                        data-bs-target="#addressModal">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>

                    {{-- Delete --}}
                    @if (!$address->is_default)
                        <form action="{{ route('user.address.destroy', $address->id) }}"
                              method="POST"
                              onsubmit="return confirmDelete(event, this)"
                              style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="aq-btn-action text-danger">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    @else
                        <span class="aq-btn-action text-muted" style="opacity:.4;cursor:not-allowed;"
                              title="Cannot delete default address">
                            <i class="fa-solid fa-trash-can"></i> Delete
                        </span>
                    @endif

                    {{-- Set Default --}}
                    @if (!$address->is_default)
                        <form action="{{ route('user.address.default', $address->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="aq-btn-action aq-set-default">
                                Set as Default
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            {{-- no addresses yet; the "Add New" card above handles this --}}
        @endforelse

    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     Add / Edit Address Modal
════════════════════════════════════════════════════════════ -->
<div class="modal fade aq-premium-modal address-modal" id="addressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:550px;">
        <div class="modal-content">
            <button type="button" class="btn-close position-absolute"
                    style="top:20px;right:20px;z-index:10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="p-4">
                <h3 class="font-family-heading mb-4" id="modalTitle">Add New Address</h3>

                <form id="addressForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">Full Name *</label>
                            <input type="text" name="name" id="fieldName"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required placeholder="John Doe"
                                   value="{{ old('name') }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">Mobile Number *</label>
                            <input type="tel" name="phone" id="fieldPhone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   required placeholder="+91 00000 00000"
                                   value="{{ old('phone') }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="aq-form-label">Address Line 1 *</label>
                        <input type="text" name="address_line_1" id="fieldLine1"
                               class="form-control @error('address_line_1') is-invalid @enderror"
                               required placeholder="House/Flat No., Building Name"
                               value="{{ old('address_line_1') }}">
                        @error('address_line_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="aq-form-label">Address Line 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="address_line_2" id="fieldLine2"
                               class="form-control"
                               placeholder="Street, Sector, Area"
                               value="{{ old('address_line_2') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">Pincode *</label>
                            <input type="text" name="pincode" id="fieldPincode"
                                   class="form-control @error('pincode') is-invalid @enderror"
                                   required placeholder="110001"
                                   value="{{ old('pincode') }}">
                            @error('pincode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">State *</label>
                            <select name="state_id" id="fieldState"
                                    class="form-select @error('state_id') is-invalid @enderror"
                                    required>
                                <option value="" disabled selected>Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">City *</label>
                            <select name="city_id" id="fieldCity"
                                    class="form-select @error('city_id') is-invalid @enderror"
                                    required>
                                <option value="" disabled selected>Select City</option>
                            </select>
                            @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="aq-form-label">Address Type *</label>
                            <div class="d-flex gap-4 mt-2">
                                @foreach (['home' => 'Home', 'office' => 'Office', 'other' => 'Other'] as $val => $label)
                                    <label class="d-flex align-items-center gap-2"
                                           style="cursor:pointer;font-size:14px;color:#555;">
                                        <input type="radio" name="address_type" id="type_{{ $val }}"
                                               value="{{ $val }}"
                                               {{ old('address_type', 'home') === $val ? 'checked' : '' }}
                                               style="width:16px;height:16px;margin:0;appearance:auto !important;">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            @error('address_type')<div class="text-danger" style="font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="d-flex align-items-center gap-2" style="cursor:pointer;font-size:14px;color:#555;">
                            <input type="checkbox" name="is_default" id="fieldDefault" value="1"
                                   style="width:16px;height:16px;appearance:auto !important;">
                            Set as default address
                        </label>
                    </div>

                    <button type="submit" id="submitBtn"
                            style="width:100%;background:var(--aq-color-maroon);color:#fff;padding:12px;border:none;border-radius:8px;font-size:15px;font-weight:600;">
                        Save Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const CITIES_URL  = "{{ route('user.address.cities') }}";
const STORE_URL   = "{{ route('user.address.store') }}";
const EDIT_BASE   = "{{ url('user/addresses') }}";  // /{id}/edit & /{id}

// ── State → City cascade ──────────────────────────────────────────────────
document.getElementById('fieldState').addEventListener('change', function () {
    fetchCities(this.value);
});

async function fetchCities(stateId, selectedCityId = null) {
    const select = document.getElementById('fieldCity');
    select.innerHTML = '<option value="" disabled selected>Loading...</option>';
    try {
        const res   = await fetch(`${CITIES_URL}?state_id=${stateId}`);
        const cities = await res.json();
        select.innerHTML = '<option value="" disabled selected>Select City</option>';
        cities.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            if (selectedCityId && c.id == selectedCityId) opt.selected = true;
            select.appendChild(opt);
        });
    } catch {
        select.innerHTML = '<option value="" disabled selected>Failed to load cities</option>';
    }
}

// ── Open modal in ADD mode ────────────────────────────────────────────────
function openAddModal() {
    document.getElementById('modalTitle').textContent  = 'Add New Address';
    document.getElementById('addressForm').action      = STORE_URL;
    document.getElementById('formMethod').value        = 'POST';
    document.getElementById('submitBtn').textContent   = 'Save Address';
    document.getElementById('addressForm').reset();
    document.getElementById('fieldCity').innerHTML =
        '<option value="" disabled selected>Select City</option>';
    document.getElementById('type_home').checked = true;
}

// ── Open modal in EDIT mode ───────────────────────────────────────────────
async function openEditModal(id) {
    document.getElementById('modalTitle').textContent = 'Edit Address';
    document.getElementById('submitBtn').textContent  = 'Update Address';

    try {
        const res  = await fetch(`${EDIT_BASE}/${id}/edit`);
        const data = await res.json();
        const a    = data.address;

        document.getElementById('addressForm').action = `${EDIT_BASE}/${id}`;
        document.getElementById('formMethod').value   = 'PUT';

        document.getElementById('fieldName').value    = a.name    ?? '';
        document.getElementById('fieldPhone').value   = a.phone   ?? '';
        document.getElementById('fieldLine1').value   = a.address_line_1 ?? '';
        document.getElementById('fieldLine2').value   = a.address_line_2 ?? '';
        document.getElementById('fieldPincode').value = a.pincode ?? '';
        document.getElementById('fieldDefault').checked = a.is_default == 1;

        // Address type radio
        const typeRadio = document.querySelector(`input[name="address_type"][value="${a.address_type}"]`);
        if (typeRadio) typeRadio.checked = true;

        // State dropdown
        const stateSelect = document.getElementById('fieldState');
        stateSelect.value = a.state_id;

        // Fetch cities for this state, then select the right city
        await fetchCities(a.state_id, a.city_id);

    } catch (err) {
        console.error('Failed to load address', err);
        alert('Could not load address details. Please try again.');
    }
}

function confirmDelete(event, form) {
    event.preventDefault();

    Swal.fire({
        title: 'Delete Address?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800020',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });

    return false;
}

// ── Re-open modal with validation errors (old input) ─────────────────────
@if ($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('addressModal'));
        modal.show();

        @if (old('state_id'))
            fetchCities({{ old('state_id') }}, {{ old('city_id', 'null') }});
        @endif
    });
@endif
</script>
@endpush
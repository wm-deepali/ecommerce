@extends('layouts.user-app')
@section('content')

@php $customer = auth('customer')->user(); @endphp

<div class="aq-modern-content aq-account-page">
    <div class="aq-page-header">
        <h2>Account Details</h2>
        <p>Update your personal information and secure your account.</p>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- ── Profile Form ── --}}
        <div class="col-xl-8 col-lg-7">
            <div class="aq-account-card mb-30">
                <h3 class="aq-account-card-title">Personal Information</h3>

                {{-- Avatar --}}
                <div class="aq-avatar-upload">
                    <div class="aq-avatar-preview">
                        <img id="mainAvatarPreview"
                             src="{{ $customer->avatar
                                    ? asset('storage/' . $customer->avatar)
                                    : asset('assets/img/default-avatar.png') }}"
                             alt="Profile Photo">
                        <label for="avatarUpload" class="aq-avatar-edit-btn">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                        <input type="file" id="avatarUpload" hidden accept="image/*">
                    </div>
                    <div class="aq-avatar-text">
                        <h5>Profile Photo</h5>
                        <p>Acceptable formats: JPG, PNG, SVG only.<br>Max file size is 2MB.</p>
                    </div>
                </div>

                <form class="aq-account-form"
                      action="{{ route('user.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Hidden avatar input populated by JS preview --}}
                    <input type="file" name="avatar" id="avatarInput" hidden accept="image/*">

                    <div class="row">
                        <div class="col-md-12 mb-20">
                            <label class="aq-form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $customer->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-20">
                            <label class="aq-form-label">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $customer->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-20">
                            <label class="aq-form-label">Phone Number</label>
                            <input type="tel"
                                   name="mobile"
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ old('mobile', $customer->mobile) }}"
                                   required>
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-20">
                            <label class="aq-form-label">Date of Birth</label>
                            <input type="date"
                                   name="dob"
                                   class="form-control @error('dob') is-invalid @enderror"
                                   value="{{ old('dob', $customer->dob) }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-20">
                            <label class="aq-form-label">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not' => 'Prefer not to say'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('gender', $customer->gender) === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="aq-btn-submit aq-btn-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Right Column ── --}}
        <div class="col-xl-4 col-lg-5">

            {{-- Security / Change Password --}}
            <div class="aq-account-card">
                <h3 class="aq-account-card-title">Security Settings</h3>
                <p class="text-muted mb-30 aq-security-subtitle">
                    Ensure your account is using a long, random password to stay secure.
                </p>

                @if($customer->google_id && !$customer->password)
                    <div class="alert alert-info">
                        Your account uses Google sign-in. Set a password below to enable direct login.
                    </div>
                @endif

                <form class="aq-account-form"
                      action="{{ route('user.password.update') }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    @unless($customer->google_id && !$customer->password)
                        <div class="mb-20">
                            <label class="aq-form-label">Current Password</label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endunless

                    <div class="mb-20">
                        <label class="aq-form-label">New Password</label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-25">
                        <label class="aq-form-label">Confirm New Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="aq-btn-submit w-100 outline-btn">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Danger Zone --}}
            <div class="aq-account-card mt-30 delete-account-card">
                <h3 class="aq-account-card-title text-danger mb-10">
                    <i class="fa-solid fa-triangle-exclamation"></i> Danger Zone
                </h3>
                <p class="text-muted mb-20 aq-danger-subtitle">
                    Once you delete your account, there is no going back. Please be certain.
                </p>

                <form action="{{ route('user.account.delete') }}"
                      method="POST"
                      id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="aq-btn-delete-account"
                            onclick="confirmDelete()">
                        Delete Account
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
// Avatar live preview — syncs the visible <img> and the hidden file input on the form
(function () {
    const trigger  = document.getElementById('avatarUpload');
    const formInput = document.getElementById('avatarInput');
    const preview  = document.getElementById('mainAvatarPreview');

    trigger.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Copy file to the form's actual input via DataTransfer
        const dt = new DataTransfer();
        dt.items.add(file);
        formInput.files = dt.files;

        // Show instant preview
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(file);
    });
})();

// Delete account confirmation
function confirmDelete() {
    if (confirm('Are you sure you want to permanently delete your account? This cannot be undone.')) {
        document.getElementById('deleteAccountForm').submit();
    }
}
</script>
@endpush

@endsection
<form method="POST" action="{{ route('admin.couriers.store') }}">
    @csrf

    <div class="settings-layout">

        <div class="settings-sidenav">
            <span class="settings-sidenav-label">
                Courier Management
            </span>

            <a href="#add-courier" class="active">
                <i class="fa-solid fa-plus"></i>
                Add Courier
            </a>

            <a href="#courier-list">
                <i class="fa-solid fa-truck"></i>
                Courier List
            </a>
        </div>

        <div class="settings-content">

            {{-- Add Courier --}}
            <div id="add-courier" class="settings-section">

                <h3 class="settings-section-title">
                    <i class="fa-solid fa-plus"></i>
                    Add New Courier
                </h3>

                <p class="settings-section-desc">
                    Add courier companies that can be selected while updating order tracking details.
                </p>

                <div class="form-grid">

                    <div class="field-group">
                        <label class="field-label">
                            Courier Name
                            <span class="req">*</span>
                        </label>

                        <input type="text"
                            name="name"
                            class="field-input"
                            placeholder="e.g. Delhivery"
                            required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            Website URL
                        </label>

                        <input type="url"
                            name="website_url"
                            class="field-input"
                            placeholder="https://www.delhivery.com">
                    </div>

                </div>

                <div class="toggle-row mt-3">

                    <div>
                        <div class="toggle-info-label">
                            Active
                        </div>

                        <div class="toggle-info-sub">
                            Show this courier in order tracking dropdown.
                        </div>
                    </div>

                    <label class="toggle-switch">
                        <input type="checkbox"
                            name="is_active"
                            checked>
                        <span class="toggle-track"></span>
                    </label>

                </div>

                <div style="margin-top:20px;">
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Courier
                    </button>
                </div>

            </div>

            <hr class="section-divider">

            {{-- Courier List --}}
            <div id="courier-list" class="settings-section">

                <h3 class="settings-section-title">
                    <i class="fa-solid fa-truck"></i>
                    Courier List
                </h3>

                <p class="settings-section-desc">
                    Manage available courier companies.
                </p>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Courier Name</th>
                                <th>Website</th>
                                <th width="100">Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($couriers as $courier)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $courier->name }}
                                        </strong>
                                    </td>

                                    <td>

                                        @if($courier->website_url)

                                            <a href="{{ $courier->website_url }}"
                                                target="_blank">
                                                {{ $courier->website_url }}
                                            </a>

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td>

                                        @if($courier->is_active)

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <button type="button"
                                            class="btn btn-sm btn-primary edit-courier-btn"
                                            data-id="{{ $courier->id }}"
                                            data-name="{{ $courier->name }}"
                                            data-url="{{ $courier->website_url }}"
                                            data-active="{{ $courier->is_active }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.couriers.delete', $courier) }}"
                                            method="POST"
                                            style="display:inline-block">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this courier?')">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">
                                        No courier found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</form>
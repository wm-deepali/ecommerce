@extends('layouts.user-app')

@section('content')

<div class="aq-modern-content aq-notification-page">

    <div class="aq-page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Notifications</h2>
            <p>Stay updated with your orders and exclusive offers.</p>
        </div>

        @if($notifications->whereNull('read_at')->count())
            <button
                id="markAllReadBtn"
                class="aq-btn-read-all">
                <i class="fa-solid fa-check-double"></i>
                Mark all as read
            </button>
        @endif
    </div>

    <div class="aq-notification-list">

        @forelse($notifications as $notification)

            <a href="{{ $notification->url ?: 'javascript:void(0)' }}"
               class="aq-notification-card notification-item {{ !$notification->read_at ? 'unread' : '' }}"
               data-id="{{ $notification->id }}">

                <div class="aq-notification-icon {{ $notification->color }}">
                    <i class="fa-solid {{ $notification->icon }}"></i>
                </div>

                <div class="aq-notification-content">

                    <h4>{{ $notification->title }}</h4>

                    <p>
                        {{ $notification->message }}
                    </p>

                    <span class="aq-notification-time">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>

                </div>

                @if(!$notification->read_at)
                    <div class="aq-unread-dot"></div>
                @endif

            </a>

        @empty

            <div class="text-center py-5">

                <i class="fa-regular fa-bell-slash fa-3x text-muted mb-3"></i>

                <h5>No Notifications Yet</h5>

                <p class="text-muted">
                    You're all caught up.
                </p>

            </div>

        @endforelse

    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

</div>

@endsection

@push('scripts')
<script>

$(document).ready(function () {

    $('#markAllReadBtn').on('click', function () {

        $.ajax({
            url: "{{ route('user.notifications.read-all') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {

                $('.aq-notification-card')
                    .removeClass('unread');

                $('.aq-unread-dot').remove();

                $('#markAllReadBtn').remove();

                $('.notification-badge').hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Done',
                    text: 'All notifications marked as read.',
                    timer: 1500,
                    showConfirmButton: false
                });

            }
        });

    });

    $('.notification-item').on('click', function () {

        let notificationId = $(this).data('id');

        $.ajax({
            url: '/notifications/' + notificationId + '/read',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            }
        });

    });

});

</script>
@endpush
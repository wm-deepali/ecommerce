<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title', 'My Account') | Chikankari Luxury Curation</title>
    <meta name="description"
        content="@yield('meta_description', 'Manage your personal information and security settings for your premium Chikankari account.')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Critical CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-luxury.css') }}" />

    <!-- Non-Critical CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}" media="print"
        onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.css') }}" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}" media="print"
        onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}" media="print"
        onload="this.media='all'" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    @stack('styles')
</head>

<body class="aq-cart-page">
    <main>
        <div class="aq-modern-dashboard">

            <!-- Sidebar -->
            <aside class="aq-modern-sidebar" id="aqSidebar">
                <button class="aq-sidebar-close-btn"
                    onclick="document.getElementById('aqSidebar').classList.remove('open')" aria-label="Close sidebar">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="aq-sidebar-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ $general?->logo
    ? asset('storage/' . $general->logo)
    : asset('assets/img/corporate/Oudhyana_img/logo.png')  }}"
                            alt="{{ $general?->site_name ?? config('app.name') }}" />
                    </a>
                </div>

                <div class="aq-sidebar-user">
                    @php
                        $customer = auth('customer')->user();
                        $avatarSrc = $customer->avatar
                            ? asset('storage/' . $customer->avatar)
                            : asset('assets/img/corporate/gallery_bridal_lehenga.png');
                        $memberLabel = $customer->orders()->count() >= 5
                            ? 'Premium Member'
                            : 'Member';
                    @endphp

                    <img src="{{ $avatarSrc }}" alt="{{ $customer->name }}" id="sidebarUserAvatar" />
                    <div class="aq-sidebar-user-info">
                        <h4>{{ $customer->name }}</h4>
                        <p>{{ $memberLabel }}</p>
                    </div>
                </div>

                <nav class="aq-sidebar-nav" aria-label="Account navigation">
                    @php

                        $unreadNotifications = auth('customer')->check()
                            ? auth('customer')
                                ->user()
                                ->notifications()
                                ->whereNull('read_at')
                                ->count()
                            : 0;

                        $currentRoute = request()->route()->getName();

                        $navItems = [
                            [
                                'route' => 'user.dashboard.index',
                                'icon' => 'fa-solid fa-border-all',
                                'label' => 'Dashboard',
                                'badge' => null,
                            ],
                            [
                                'route' => 'user.orders.index',
                                'icon' => 'fa-solid fa-box-open',
                                'label' => 'My Orders',
                                'badge' => null,
                            ],
                            [
                                'route' => 'wishlist.index',
                                'icon' => 'fa-regular fa-heart',
                                'label' => 'Wishlist',
                                'badge' => null,
                            ],
                            [
                                'route' => 'user.address.index',
                                'icon' => 'fa-solid fa-map-location-dot',
                                'label' => 'Addresses',
                                'badge' => null,
                            ],
                            [
                                'route' => 'user.account.details',
                                'icon' => 'fa-regular fa-user',
                                'label' => 'Account Details',
                                'badge' => null,
                            ],
                            [
                                'route' => 'user.notifications',
                                'icon' => 'fa-solid fa-bell',
                                'label' => 'Notifications',
                                'badge' => $unreadNotifications,
                            ],
                        ];
                    @endphp

                    <ul>
                        @foreach ($navItems as $item)
                            <li class="{{ $currentRoute === $item['route'] ? 'active' : '' }}">
                                <a href="{{ route($item['route']) }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                    @if ($item['badge'] > 0)
                                        <span class="badge notification-badge">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="aq-sidebar-bottom">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="aq-logout-btn">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="aq-modern-main">

                <!-- Topbar -->
                <header class="aq-modern-topbar">
                    <button class="aq-sidebar-toggle-btn"
                        onclick="document.getElementById('aqSidebar').classList.add('open')" aria-label="Open sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div class="aq-topbar-search">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" placeholder="Search settings...">
                    </div>

                    <div class="aq-topbar-actions">
                        <button class="aq-icon-btn" onclick="window.location.href='{{ route('user.notifications') }}'">
                            <i class="fa-regular fa-bell"></i>

                            @if($unreadNotifications > 0)
                                <span class="indicator"></span>
                            @endif
                        </button>
                        <button class="aq-btn-store" onclick="window.location.href='{{ route('home') }}'">
                            <i class="fa-solid fa-store"></i> Back to Store
                        </button>
                    </div>
                </header>

                <!-- Flash Messages -->
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: @json(session('success')),
                                confirmButtonColor: '#800020',
                                timer: 3000,
                                timerProgressBar: true
                            });
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: @json(session('error')),
                                confirmButtonColor: '#800020'
                            });
                        });
                    </script>
                @endif

                @yield('content')

            </div>
        </div>
    </main>

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
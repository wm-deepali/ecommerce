@extends('layouts.user-app')
@section('content')

<div class="aq-modern-content aq-wishlist-page">
    <div class="aq-page-header">
        <h2>My Wishlist</h2>
        <p>View and manage the luxury pieces you've saved for later.</p>
    </div>

    @if($wishlists->isEmpty())
        <div class="aq-wishlist-empty">
            <i class="fa-regular fa-heart fa-3x"></i>
            <p>Your wishlist is empty.</p>
            <a href="{{ route('categories') }}" class="aq-btn-primary">Browse Collections</a>
        </div>
    @else
       

        <div class="aq-wishlist-grid" id="wishlist-grid">
            @foreach($wishlists as $item)
              @php $product = $item->product; @endphp

@php
    $stockVariants = $product->variants->where('type', 'stock');
    $wishlistStock = $stockVariants->count()
        ? $stockVariants->sum('stock')
        : $product->stock;
    $isSoldOut = $wishlistStock < $product->min_qty;
@endphp

                <div class="aq-wishlist-card" id="wl-card-{{ $item->id }}">

                    {{-- Remove button --}}
                    <button
                        class="aq-wishlist-remove"
                        data-url="{{ route('wishlist.remove', $product->id) }}"
                        data-card="wl-card-{{ $item->id }}"
                        title="Remove from wishlist">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    {{-- Product image + Move to Cart overlay --}}
                    <div class="aq-wishlist-img-wrapper">
                      <img
    src="{{ $product->display_image ?? asset('assets/img/placeholder.png') }}"
    alt="{{ $product->name }}"
    loading="lazy">

@if($isSoldOut)
    <span class="aq-wishlist-soldout-badge"
        style="position:absolute;top:10px;left:10px;background:#b3261e;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;padding:3px 10px;border-radius:4px;letter-spacing:.3px;z-index:2;">
        Sold Out
    </span>
@endif

                        <div class="aq-wishlist-overlay">
                             @if($isSoldOut)
        <span class="aq-btn-cart-overlay" style="background:#999;cursor:not-allowed;pointer-events:none;">
            Sold Out
        </span>
    @else
                            <button
                                class="aq-btn-cart-overlay"
                                data-url="{{ route('wishlist.moveToCart', $product->id) }}"
                                data-card="wl-card-{{ $item->id }}"
                                data-name="{{ $product->name }}">
                                Move to Cart
                            </button>
                            @endif
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="aq-wishlist-info">
                        <span class="aq-wishlist-cat">
                            {{ $product->subcategory->name ?? $product->category->name ?? '—' }}
                        </span>
                        <h4>
                            <a href="{{ route('product.details', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h4>
                        <div class="aq-wishlist-price">
                            ₹ {{ number_format($product->price) }}
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
(function () {
    const CSRF = '{{ csrf_token() }}';

    function post(url) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ _method: 'DELETE' }),
        }).then(r => r.json());
    }

    function postMove(url) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
        }).then(r => r.json());
    }

    function removeCard(cardId) {
        const card = document.getElementById(cardId);
        if (!card) return;
        card.style.transition = 'opacity 0.28s, transform 0.28s';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.92)';
        setTimeout(() => {
            card.remove();
            checkEmpty();
        }, 300);
    }

  

    function checkEmpty() {
        const grid = document.getElementById('wishlist-grid');
        if (grid && grid.querySelectorAll('.aq-wishlist-card').length === 0) {
            grid.closest('.aq-modern-content').innerHTML = `
                <div class="aq-page-header">
                    <h2>My Wishlist</h2>
                    <p>View and manage the luxury pieces you've saved for later.</p>
                </div>
                <div class="aq-wishlist-empty">
                    <i class="fa-regular fa-heart fa-3x"></i>
                    <p>Your wishlist is empty.</p>
                    <a href="{{ route('categories') }}" class="aq-btn-primary">Browse Collections</a>
                </div>`;
        }
    }

    function toast(msg, type = 'success') {
        const t = document.createElement('div');
        t.className = 'aq-toast aq-toast--' + type;
        t.textContent = msg;
        document.body.appendChild(t);
        requestAnimationFrame(() => t.classList.add('show'));
        setTimeout(() => {
            t.classList.remove('show');
            setTimeout(() => t.remove(), 300);
        }, 2800);
    }

    // Remove
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.aq-wishlist-remove');
        if (!btn) return;
        e.preventDefault();
        const url  = btn.dataset.url;
        const card = btn.dataset.card;
        post(url)
            .then(res => {
                if (res.success) {
                    removeCard(card);
                    toast('Item removed from wishlist.');
                    updateWishlistBadge(-1);
                } else {
                    toast('Something went wrong.', 'error');
                }
            })
            .catch(() => toast('Something went wrong.', 'error'));
    });

    // Move to Cart
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.aq-btn-cart-overlay');
        if (!btn) return;
        e.preventDefault();
        const url  = btn.dataset.url;
        const card = btn.dataset.card;
        const name = btn.dataset.name;
        btn.disabled = true;
        btn.textContent = 'Adding…';
        postMove(url)
            .then(res => {
                if (res.success) {
                    removeCard(card);
                    toast(`"${name}" moved to cart.`);
                    updateWishlistBadge(-1);
                    updateCartBadge(1);
                } else {
                    toast('Something went wrong.', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Move to Cart';
                }
            })
            .catch(() => {
                toast('Something went wrong.', 'error');
                btn.disabled = false;
                btn.textContent = 'Move to Cart';
            });
    });

    // Badge helpers — adjust selectors to match your nav
    function updateWishlistBadge(delta) {
        const badge = document.querySelector('.aq-wishlist-badge');
        if (!badge) return;
        const current = parseInt(badge.textContent) || 0;
        const next = Math.max(0, current + delta);
        badge.textContent = next;
        badge.style.display = next === 0 ? 'none' : '';
    }

    function updateCartBadge(delta) {
        const badge = document.querySelector('.aq-cart-badge');
        if (!badge) return;
        const current = parseInt(badge.textContent) || 0;
        badge.textContent = current + delta;
    }
})();
</script>
@endpush

@endsection
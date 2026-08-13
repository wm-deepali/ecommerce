@extends('layouts.app')
@section('content')

    <main class="aq-cart-page">

        <!-- Hero Section -->
        <section class="aq-catpage-hero aq-apparel-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Colour Chart</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Colour Chart</span>
                </div>
            </div>
        </section>

        <!-- Colour Chart Grid -->
        <section class="aq-cart-wrapper" id="aqColourChartSection">
            <div class="container">
                <div class="row g-3">

                    <div class="col-6 col-md-3">
                        <div class="aq-summary-card p-2">
                            <img src="{{ asset('assets/img/colour-chart-2.jpeg') }}" alt="Colour Chart 1"
                                class="img-fluid rounded aq-colour-chart-img"
                                style="width: 100%; height: auto; display: block; cursor: zoom-in;">
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="aq-summary-card p-2">
                            <img src="{{ asset('assets/img/colour-chart-1.jpeg') }}" alt="Colour Chart 2"
                                class="img-fluid rounded aq-colour-chart-img"
                                style="width: 100%; height: auto; display: block; cursor: zoom-in;">
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="aq-summary-card p-2">
                            <img src="{{ asset('assets/img/colour-chart-4.jpeg') }}" alt="Colour Chart 3"
                                class="img-fluid rounded aq-colour-chart-img"
                                style="width: 100%; height: auto; display: block; cursor: zoom-in;">
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="aq-summary-card p-2">
                            <img src="{{ asset('assets/img/colour-chart-3.jpeg') }}" alt="Colour Chart 4"
                                class="img-fluid rounded aq-colour-chart-img"
                                style="width: 100%; height: auto; display: block; cursor: zoom-in;">
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- Zoom Modal -->
    <div id="aqColourZoomModal" style="
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        ">
        <span id="aqColourZoomClose" style="
                position: absolute;
                top: 16px;
                right: 24px;
                color: #fff;
                font-size: 32px;
                cursor: pointer;
                line-height: 1;
                z-index: 10000;
            ">&times;</span>

        <div style="
                width: 100%;
                height: 100%;
                overflow: auto;
                display: flex;
                align-items: center;
                justify-content: center;
                touch-action: pinch-zoom;
            ">
            <img id="aqColourZoomImg" src="" alt="Zoomed Colour Chart"
                style="
                    max-width: 100%;
                    max-height: 100%;
                    width: auto;
                    height: auto;
                    touch-action: pinch-zoom;
                ">
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('aqColourZoomModal');
            var modalImg = document.getElementById('aqColourZoomImg');
            var closeBtn = document.getElementById('aqColourZoomClose');
            var images = document.querySelectorAll('.aq-colour-chart-img');

            images.forEach(function (img) {
                img.addEventListener('click', function () {
                    modalImg.src = this.src;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeModal() {
                modal.style.display = 'none';
                modalImg.src = '';
                document.body.style.overflow = '';
            }

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        })();
    </script>

@endsection
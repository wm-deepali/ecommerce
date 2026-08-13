@extends('layouts.app')

@section('meta_title', $page->meta_title ?? $page->heading)

@section('meta_description', $page->meta_description ?? '')

@section('content')

<main>

    <!-- Hero Section -->
    <section class="aq-catpage-hero">
        <div class="aq-hero-glow"></div>

        <div class="aq-floating-gift-box aq-floating-shape-1">
            <i class="fa-solid fa-gift"></i>
        </div>

        <div class="aq-floating-gift-box aq-floating-shape-2">
            <i class="fa-solid fa-gem"></i>
        </div>

        <div class="aq-catpage-hero-content">
            <h1 class="aq-catpage-title">{{ $page->heading }}</h1>

            <div class="aq-catpage-breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>{{ $page->heading }}</span>
            </div>
        </div>
    </section>

    <div class="aq-terms-parent-wrapper pt-120 pb-120">
        <div class="container">

            <div class="aq-terms-content-wrapper">

                <h2 class="aq-terms-title">
                    {{ $page->heading }}
                </h2>

                <p class="aq-terms-update-date">
                    Last Updated:
                    {{ $page->updated_at ? $page->updated_at->format('F d, Y') : now()->format('F d, Y') }}
                </p>

                {!! $page->content !!}

            </div>

        </div>
    </div>

</main>

@endsection
@extends('site.master_layout')

@section('title', 'Blog')
@section('description', 'Procurement insights and industry updates from Good Procurement Service Ltd — coming soon.')

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-blog.css') }}">
@endpush

@section('main')
    <!-- Page Header Section Start -->
    <div class="page-header gps-blog-header bg-section parallaxie">
        <video class="gps-hero-video" autoplay muted loop playsinline preload="none" aria-hidden="true">
            <source src="{{ asset('site/assets/videos/hero-blog.mp4') }}" type="video/mp4">
        </video>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">our blog</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">blog</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    <!-- Page Blog Start -->
    <div class="gps-blog-listing">
        <div class="container">
            <div class="gps-blog-listing-grid">
                <div class="gps-blog-listing-copy wow fadeInUp">
                    <span class="gps-blog-eyebrow">Coming Soon</span>
                    <h2 class="gps-blog-listing-headline">Our blog is <em>coming soon</em></h2>
                    <p class="gps-blog-listing-lede">We're putting together procurement insights and industry updates. In the meantime, reach out directly &mdash; <a href="{{ url('/') }}#contact">see the contact section</a> on our home page.</p>
                    <div class="gps-blog-listing-actions">
                        <a href="{{ url('/') }}#contact" class="btn-default">See the contact section</a>
                        <a href="{{ url('/') }}" class="gps-blog-inline-link">Back to home</a>
                    </div>
                </div>
                <div class="gps-blog-preview wow fadeInUp" data-wow-delay="0.2s">
                    <div class="gps-blog-preview-label">What we'll be covering</div>
                    <ul class="gps-blog-preview-list">
                        <li><span>Oil &amp; Gas</span><span>Sourcing &amp; supply</span></li>
                        <li><span>Construction</span><span>Materials &amp; vendors</span></li>
                        <li><span>Corporate</span><span>Procurement process</span></li>
                        <li><span>Maritime</span><span>Logistics &amp; timelines</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Blog End -->
@endsection

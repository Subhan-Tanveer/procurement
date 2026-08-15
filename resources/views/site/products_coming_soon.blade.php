@extends('site.master_layout')

@section('title', 'Products — Coming Soon')
@section('description', 'Our product catalog is on its way. In the meantime, tell us what you need and we will source it directly.')
@section('robots', 'noindex, follow')

@section('main')
    <div class="gps-section gps-coming-soon">
        <div class="container">
            <div class="gps-coming-soon-panel wow fadeInUp">
                <span class="gps-kicker" style="justify-content: center; display: flex;">Good Procurement Shop &middot; Coming Soon</span>
                <h1 class="gps-headline text-anime-style-3" data-cursor="-opaque">Something good is coming.</h1>
                <p class="gps-lede">We're putting the finishing touches on our product catalog. In the meantime, tell us what you need sourced and we'll get you a straightforward quote directly.</p>
                <div class="gps-coming-soon-divider" aria-hidden="true"></div>
                <a href="{{ url('/') }}#contact" class="btn-default">Request a Quote</a>
            </div>
        </div>
    </div>
@endsection

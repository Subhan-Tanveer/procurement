{{-- Content Two Column: Two-column text content --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $image1 = $resolveImage($content['image_1'] ?? null);
    $image2 = $resolveImage($content['image_2'] ?? null);
@endphp
<div class="page-block pb-content-twocol bg-section">
    <div class="container">
        @if(($content['section_title'] ?? false) || ($content['section_subtitle'] ?? false))
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        @if($content['section_subtitle'] ?? false)
                            <h3 class="wow fadeInUp">{{ $content['section_subtitle'] }}</h3>
                        @endif
                        @if($content['section_title'] ?? false)
                            <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['section_title'] }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="row pb-twocol-row">
            <div class="col-lg-6">
                <div class="pb-twocol-card wow fadeInUp">
                    @if($image1)
                        <div class="pb-twocol-image">
                            <figure><img src="{{ $image1 }}" alt=""></figure>
                        </div>
                    @endif
                    <div class="pb-twocol-body">
                        <div class="service-entry">
                            {!! $content['column_1'] ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pb-twocol-card wow fadeInUp" data-wow-delay="0.2s">
                    @if($image2)
                        <div class="pb-twocol-image">
                            <figure><img src="{{ $image2 }}" alt=""></figure>
                        </div>
                    @endif
                    <div class="pb-twocol-body">
                        <div class="service-entry">
                            {!! $content['column_2'] ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-content-twocol {
        position: relative;
    }
    .pb-twocol-card {
        background: var(--white-color);
        border-radius: 16px;
        overflow: hidden;
        height: calc(100% - 30px);
        margin-bottom: 30px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .pb-twocol-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
    }
    .pb-twocol-image {
        overflow: hidden;
    }
    .pb-twocol-image figure {
        margin: 0;
    }
    .pb-twocol-image img {
        width: 100%;
        aspect-ratio: 1 / 0.5;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }
    .pb-twocol-card:hover .pb-twocol-image img {
        transform: scale(1.05);
    }
    .pb-twocol-body {
        padding: 35px 35px 40px;
        position: relative;
    }
    .pb-twocol-body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 35px;
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, var(--accent-color), var(--primary-color));
        border-radius: 2px;
    }
    .pb-twocol-body .service-entry {
        margin-bottom: 0;
        padding-top: 10px;
    }
    .pb-twocol-body .service-entry h2,
    .pb-twocol-body .service-entry h3 {
        font-family: var(--accent-font);
        color: var(--primary-color);
    }
    .pb-twocol-body .service-entry p {
        font-size: 16px;
        line-height: 1.75;
        color: var(--text-color);
    }
    .pb-twocol-body .service-entry blockquote {
        border-left: 3px solid var(--accent-color);
        padding: 15px 20px;
        margin: 20px 0;
        background: rgba(120, 181, 71, 0.04);
        border-radius: 0 10px 10px 0;
        font-style: italic;
        color: var(--primary-color);
    }
    .pb-twocol-body .service-entry img {
        border-radius: 10px;
        max-width: 100%;
        height: auto;
    }
    @media (max-width: 991px) {
        .pb-twocol-body {
            padding: 25px 25px 30px;
        }
        .pb-twocol-body::before {
            left: 25px;
        }
    }
</style>
@endpush

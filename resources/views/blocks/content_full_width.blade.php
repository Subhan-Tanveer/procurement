{{-- Content Full Width: Full-width content section --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $sectionImage = $resolveImage($content['image'] ?? null);
@endphp
<div class="page-block pb-content-full">
    <div class="container">
        @if(($content['section_title'] ?? false) || ($content['section_subtitle'] ?? false))
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title">
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

        @if($sectionImage)
            <div class="row">
                <div class="col-lg-12 wow fadeInUp">
                    <div class="pb-content-featured-image">
                        <figure>
                            <img src="{{ $sectionImage }}" alt="{{ $content['section_title'] ?? '' }}">
                        </figure>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="pb-content-body wow fadeInUp" data-wow-delay="0.15s">
                    <div class="service-entry">
                        {!! $content['content'] ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-content-full {
        position: relative;
    }
    .pb-content-full .section-title {
        position: relative;
        padding-left: 20px;
    }
    .pb-content-full .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 4px;
        background: linear-gradient(to bottom, var(--accent-color), var(--primary-color));
        border-radius: 2px;
    }
    .pb-content-featured-image {
        margin-bottom: 40px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }
    .pb-content-featured-image figure {
        margin: 0;
    }
    .pb-content-featured-image img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        display: block;
    }
    .pb-content-body {
        position: relative;
    }
    .pb-content-body .service-entry {
        margin-bottom: 0;
    }
    .pb-content-body .service-entry h2 {
        font-family: var(--accent-font);
        color: var(--primary-color);
        margin-top: 10px;
    }
    .pb-content-body .service-entry h3 {
        font-family: var(--accent-font);
        color: var(--primary-color);
    }
    .pb-content-body .service-entry p {
        font-size: 17px;
        line-height: 1.8;
        color: var(--text-color);
    }
    .pb-content-body .service-entry blockquote {
        border-left: 4px solid var(--accent-color);
        padding: 20px 30px;
        margin: 30px 0;
        background: rgba(120, 181, 71, 0.04);
        border-radius: 0 12px 12px 0;
        font-size: 18px;
        font-style: italic;
        color: var(--primary-color);
    }
    .pb-content-body .service-entry img {
        border-radius: 12px;
        max-width: 100%;
        height: auto;
    }
    @media (max-width: 991px) {
        .pb-content-featured-image img {
            max-height: 300px;
        }
        .pb-content-body .service-entry p {
            font-size: 15px;
        }
    }
</style>
@endpush

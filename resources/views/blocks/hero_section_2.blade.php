{{-- Hero Section 2: Split hero with content left, image right --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (is_array($path)) {
            $path = $path['url'] ?? $path['path'] ?? null;
        }
        if (!$path) return null;
        $path = (string) $path;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) return asset($path);
        if (\Illuminate\Support\Str::startsWith($path, 'public/')) return asset(\Illuminate\Support\Str::replaceFirst('public/', 'storage/', $path));
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $heroImage = $resolveImage($content['image'] ?? null);
@endphp
<div class="hero-split bg-section page-block pb-hero-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-content pb-hero-copy">
                    @if($content['subheading'] ?? false)
                        <h3 class="wow fadeInUp">{{ $content['subheading'] }}</h3>
                    @endif

                    <h1 class="text-anime-style-3" data-cursor="-opaque">
                        {{ $content['heading'] ?? 'Welcome' }}
                    </h1>

                    @if($content['description'] ?? false)
                        <p class="wow fadeInUp" data-wow-delay="0.2s">{{ $content['description'] }}</p>
                    @endif

                    @if($content['cta_text'] ?? false)
                        <div class="section-content-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="{{ $content['cta_link'] ?? '#' }}" class="btn-default btn-highlighted"><span>{{ $content['cta_text'] }}</span></a>
                        </div>
                    @endif
                </div>
            </div>

            @if($heroImage)
                <div class="col-lg-6">
                    <div class="hero-split-image pb-hero-media wow fadeInUp" data-wow-delay="0.2s">
                        <figure class="image-anime">
                            <img src="{{ $heroImage }}" alt="{{ $content['heading'] ?? '' }}">
                        </figure>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-hero-2 {
        position: relative;
        overflow: hidden;
        padding: 110px 0;
    }

    .pb-hero-2::before {
        content: '';
        position: absolute;
        width: 520px;
        height: 520px;
        right: -180px;
        top: -140px;
        background: radial-gradient(circle, rgba(120,181,71,0.15) 0%, rgba(120,181,71,0) 70%);
        pointer-events: none;
    }

    .pb-hero-2 .pb-hero-copy {
        max-width: 560px;
        position: relative;
        z-index: 1;
    }

    .pb-hero-2 .pb-hero-copy h3 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        background: rgba(66, 102, 147, 0.1);
        color: var(--primary-color);
        padding: 8px 16px;
        border-radius: 999px;
        margin: 0 0 18px;
    }

    .pb-hero-2 .pb-hero-copy h1 {
        font-size: clamp(34px, 4vw, 58px);
        line-height: 1.08;
        margin: 0 0 18px;
    }

    .pb-hero-2 .pb-hero-copy p {
        font-size: 18px;
        line-height: 1.7;
        margin: 0 0 26px;
        color: color-mix(in srgb, var(--text-color) 85%, #000 15%);
    }

    .pb-hero-2 .pb-hero-media figure {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(16, 33, 54, 0.15);
    }

    .pb-hero-2 .pb-hero-media img {
        width: 100%;
        height: auto;
        aspect-ratio: 5 / 4;
        object-fit: cover;
    }

    @media (max-width: 991px) {
        .pb-hero-2 {
            padding: 80px 0;
        }

        .pb-hero-2 .pb-hero-copy {
            max-width: 100%;
        }

        .pb-hero-2 .pb-hero-media {
            margin-top: 28px;
        }
    }

    @media (max-width: 575px) {
        .pb-hero-2 .pb-hero-copy h1 {
            font-size: 32px;
        }

        .pb-hero-2 .pb-hero-copy p {
            font-size: 16px;
        }
    }
</style>
@endpush

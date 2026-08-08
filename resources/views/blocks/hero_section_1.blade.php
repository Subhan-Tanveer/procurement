{{-- Hero Section 1: Full-width hero with background image --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $heroImage = $resolveImage($content['image'] ?? null);
@endphp
<div class="hero bg-section dark-section page-block pb-hero-1" @if($heroImage) style="background-image: url('{{ $heroImage }}'); background-size: cover; background-position: center;" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-content pb-hero-content">
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
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-hero-1 .pb-hero-content {
        max-width: 680px;
        padding: 20px 0 40px;
    }

    .pb-hero-1 .pb-hero-content h3 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        background: rgba(15, 22, 31, 0.6);
        color: var(--white-color);
        padding: 8px 16px;
        border-radius: 999px;
        margin: 0 0 18px;
    }

    .pb-hero-1 .pb-hero-content h1 {
        font-size: clamp(36px, 4.2vw, 64px);
        line-height: 1.08;
        margin: 0 0 18px;
        text-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
    }

    .pb-hero-1 .pb-hero-content p {
        font-size: 18px;
        line-height: 1.7;
        margin: 0 0 28px;
        color: rgba(255, 255, 255, 0.8);
    }

    .pb-hero-1 .pb-hero-content .section-content-btn {
        margin-top: 8px;
    }

    @media (max-width: 991px) {
        .pb-hero-1 .pb-hero-content {
            padding: 10px 0 30px;
        }

        .pb-hero-1 .pb-hero-content h1 {
            font-size: clamp(32px, 6vw, 44px);
        }

        .pb-hero-1 .pb-hero-content p {
            font-size: 16px;
        }
    }
</style>
@endpush

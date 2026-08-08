{{-- Logo Showcase: Partner/client logos --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
@endphp
<div class="page-block bg-section">
    <div class="container">
        @if($content['section_title'] ?? false)
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['section_title'] }}</h2>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 align-items-center justify-content-center">
            @foreach(($content['logos'] ?? []) as $index => $logo)
                @php $logoImg = $resolveImage($logo['image'] ?? null); @endphp
                @if($logoImg)
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="pb-logo-item wow fadeInUp" data-wow-delay="{{ $index * 0.1 }}s">
                            @if($logo['link'] ?? false)
                                <a href="{{ $logo['link'] }}" target="_blank" rel="noopener">
                                    <img src="{{ $logoImg }}" alt="{{ $logo['name'] ?? '' }}" loading="lazy" decoding="async">
                                </a>
                            @else
                                <img src="{{ $logoImg }}" alt="{{ $logo['name'] ?? '' }}" loading="lazy" decoding="async">
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-logo-item {
        padding: 20px;
        background: var(--white-color);
        border-radius: 10px;
        border: 1px solid var(--divider-color);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .pb-logo-item:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }
    .pb-logo-item img {
        max-width: 120px;
        max-height: 50px;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: filter 0.3s ease, opacity 0.3s ease;
    }
    .pb-logo-item:hover img {
        filter: grayscale(0%);
        opacity: 1;
    }
</style>
@endpush

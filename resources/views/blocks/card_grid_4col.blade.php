{{-- Card Grid - 4 Columns --}}
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
    $blockDefaults = isset($blockType) ? ($blockType->default_data ?? []) : [];
    $sectionTitle = !empty($content['section_title']) ? $content['section_title'] : ($blockDefaults['section_title'] ?? null);
    $sectionSubtitle = !empty($content['section_subtitle']) ? $content['section_subtitle'] : ($blockDefaults['section_subtitle'] ?? null);
@endphp
<div class="service-offer-box page-block pb-card-grid pb-card-grid-4 bg-section">
    <div class="container">
        @if($sectionTitle || $sectionSubtitle)
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        @if($sectionSubtitle)
                            <h3 class="wow fadeInUp">{{ $sectionSubtitle }}</h3>
                        @endif
                        @if($sectionTitle)
                            <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $sectionTitle }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            @foreach(($content['cards'] ?? []) as $index => $card)
                @php
                    $hasIcon = !empty($card['icon']);
                    $isFaIcon = $hasIcon && str_contains($card['icon'], 'fa-');
                    $cardImage = $resolveImage($card['image'] ?? null)
                        ?: (($hasIcon && !$isFaIcon) ? $resolveImage($card['icon']) : null);
                @endphp
                <div class="col-xl-3 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="{{ $index * 0.15 }}s">
                        <div class="service-item-image-prime">
                            @if($cardImage)
                                @if($card['link'] ?? false)
                                    <a href="{{ $card['link'] }}" data-cursor-text="View">
                                        <figure><img src="{{ $cardImage }}" alt="{{ $card['title'] ?? '' }}"></figure>
                                    </a>
                                @else
                                    <figure><img src="{{ $cardImage }}" alt="{{ $card['title'] ?? '' }}"></figure>
                                @endif
                            @else
                                <div class="pb-card-placeholder">
                                    @if($isFaIcon)
                                        <i class="{{ $card['icon'] }}"></i>
                                    @elseif($hasIcon)
                                        <img src="{{ $resolveImage($card['icon']) }}" alt="">
                                    @else
                                        <i class="fa-solid fa-cube"></i>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="service-item-body-prime">
                            @if($hasIcon)
                                <div class="icon-box">
                                    @if($isFaIcon)
                                        <i class="{{ $card['icon'] }}"></i>
                                    @else
                                        <img src="{{ $resolveImage($card['icon']) }}" alt="">
                                    @endif
                                </div>
                            @endif
                            <div class="service-item-content-prime">
                                <h3>
                                    @if($card['link'] ?? false)
                                        <a href="{{ $card['link'] }}">{{ $card['title'] ?? '' }}</a>
                                    @else
                                        {{ $card['title'] ?? '' }}
                                    @endif
                                </h3>
                                @if($card['description'] ?? false)
                                    <p>{{ $card['description'] }}</p>
                                @endif
                            </div>
                            @if($card['link'] ?? false)
                                <div class="service-item-btn-prime">
                                    <a href="{{ $card['link'] }}" class="readmore-btn">
                                        <span>{{ $card['link_text'] ?? 'Read More' }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-card-grid-4 .service-item-image-prime img {
        aspect-ratio: 1 / 0.64;
    }
    .pb-card-grid-4 .service-item-body-prime {
        padding: 0 24px 24px;
    }
    .pb-card-grid-4 .service-item-body-prime .icon-box {
        width: 54px;
        height: 54px;
        background-color: var(--accent-color);
        border: 3px solid var(--white-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -27px 0 18px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .pb-card-grid-4 .service-item-prime:hover .icon-box {
        background-color: var(--primary-color);
        transform: scale(1.08);
    }
    .pb-card-grid-4 .service-item-body-prime .icon-box i {
        font-size: 18px;
        color: var(--white-color);
    }
    .pb-card-grid-4 .service-item-body-prime .icon-box img {
        max-width: 22px;
        filter: brightness(10);
    }
    .pb-card-grid-4 .service-item-content-prime h3 {
        font-size: 17px;
    }
    .pb-card-grid-4 .service-item-content-prime p {
        font-size: 14px;
    }
    .pb-card-placeholder {
        aspect-ratio: 1 / 0.64;
        background: linear-gradient(135deg, var(--primary-color) 0%, color-mix(in srgb, var(--primary-color) 70%, var(--accent-color)) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pb-card-placeholder i {
        font-size: 42px;
        color: rgba(255, 255, 255, 0.25);
    }
    .pb-card-placeholder img {
        max-width: 100%;
        max-height: 60px;
        object-fit: contain;
        opacity: 0.3;
        filter: brightness(10);
    }
</style>
@endpush

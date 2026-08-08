{{-- Card Grid - 2 Columns --}}
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
<div class="service-offer-box page-block pb-card-grid pb-card-grid-2">
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
                <div class="col-lg-6 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                        <div class="service-item-image-prime">
                            @if($cardImage)
                                @if($card['link'] ?? false)
                                    <a href="{{ $card['link'] }}" data-cursor-text="View">
                                        <figure><img src="{{ $cardImage }}" alt="{{ $card['title'] ?? '' }}"></figure>
                                    </a>
                                @else
                                    <figure><img src="{{ $cardImage }}" alt="{{ $card['title'] ?? '' }}"></figure>
                                @endif
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
                                        <span>{{ $card['link_text'] ?? 'Learn More' }}</span>
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
    .pb-card-grid-2 .service-item-image-prime figure,
    .pb-card-grid-2 .service-item-image-prime img {
        width: 100%;
        display: block;
    }
    .pb-card-grid-2 .service-item-image-prime img {
        aspect-ratio: 1 / 0.52;
        object-fit: cover;
    }
    .pb-card-grid-2 .service-item-body-prime .icon-box {
        width: 66px;
        height: 66px;
        background-color: var(--accent-color);
        border: 3px solid var(--white-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -33px 0 22px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .pb-card-grid-2 .service-item-prime:hover .icon-box {
        background-color: var(--primary-color);
        transform: scale(1.08);
    }
    .pb-card-grid-2 .service-item-body-prime .icon-box i {
        font-size: 24px;
        color: var(--white-color);
    }
    .pb-card-grid-2 .service-item-body-prime .icon-box img {
        max-width: 28px;
        filter: brightness(10);
    }
</style>
@endpush

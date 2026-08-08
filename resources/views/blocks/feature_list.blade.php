{{-- Feature List: Icon and text features --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $features = $content['features'] ?? [];
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

        <div class="service-offer-box">
            <div class="service-offer-item-list">
                @foreach($features as $index => $feature)
                    <div class="service-offer-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                        @php $featureIcon = $resolveImage($feature['icon'] ?? null); @endphp
                        <div class="icon-box">
                            @if($featureIcon)
                                <img src="{{ $featureIcon }}" alt="{{ $feature['title'] ?? '' }}">
                            @else
                                <img src="{{ asset('site/assets/images/icon-service-offer-1.svg') }}" alt="">
                            @endif
                        </div>
                        <div class="service-offer-item-content">
                            @if($feature['title'] ?? false)
                                <h3>{{ $feature['title'] }}</h3>
                            @endif
                            @if($feature['description'] ?? false)
                                <p>{{ $feature['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

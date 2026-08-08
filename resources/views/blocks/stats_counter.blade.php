{{-- Stats Counter: Statistics/numbers section --}}
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

        <div class="world-map-counter-box wow fadeInUp">
            @foreach(($content['stats'] ?? []) as $index => $stat)
                <div class="world-map-counter-item">
                    @php $statIcon = $resolveImage($stat['icon'] ?? null); @endphp
                    @if($statIcon)
                        <div class="icon-box">
                            <img src="{{ $statIcon }}" alt="{{ $stat['label'] ?? '' }}">
                        </div>
                    @endif
                    <div class="world-map-counter-content">
                        <h2><span class="counter">{{ preg_replace('/[^0-9]/', '', $stat['number'] ?? '0') }}</span>{{ preg_replace('/[0-9]/', '', $stat['number'] ?? '') }}</h2>
                        <p>{{ $stat['label'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

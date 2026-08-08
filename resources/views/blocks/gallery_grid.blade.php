{{-- Gallery Grid: Image gallery --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
@endphp
<div class="page-gallery page-block">
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

        <div class="row gallery-items page-gallery-box">
            @foreach(($content['images'] ?? []) as $index => $image)
                @php $imgUrl = $resolveImage($image['image'] ?? null); @endphp
                @if($imgUrl)
                    <div class="col-lg-4 col-6">
                        <div class="photo-gallery wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                            <a href="{{ $imgUrl }}" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ $imgUrl }}" alt="{{ $image['caption'] ?? '' }}">
                                </figure>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

{{-- About Section: Image and content section --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $aboutImage = $resolveImage($content['image'] ?? null);
    $imageOnLeft = ($content['image_position'] ?? 'right') === 'left';
@endphp
<div class="about-us page-block">
    <div class="container">
        <div class="row align-items-center">
            @if($imageOnLeft && $aboutImage)
                <div class="col-xl-5 col-lg-6">
                    <div class="about-us-image-box wow fadeInUp">
                        <div class="about-us-image">
                            <figure class="image-anime">
                                <img src="{{ $aboutImage }}" alt="{{ $content['heading'] ?? '' }}">
                            </figure>
                        </div>
                    </div>
                </div>
            @endif

            <div class="{{ $aboutImage ? 'col-xl-7 col-lg-6' : 'col-lg-12' }}">
                <div class="section-title">
                    @if($content['subheading'] ?? false)
                        <h3 class="wow fadeInUp">{{ $content['subheading'] }}</h3>
                    @endif
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['heading'] ?? 'About Us' }}</h2>
                </div>

                @if($content['description'] ?? false)
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ $content['description'] }}</p>
                @endif

                @if($content['features'] ?? false)
                    <div class="about-us-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="about-us-item-content">
                            <ul>
                                @foreach($content['features'] as $feature)
                                    <li>{{ $feature['text'] ?? '' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$imageOnLeft && $aboutImage)
                <div class="col-xl-5 col-lg-6">
                    <div class="about-us-image-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="about-us-image">
                            <figure class="image-anime">
                                <img src="{{ $aboutImage }}" alt="{{ $content['heading'] ?? '' }}">
                            </figure>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

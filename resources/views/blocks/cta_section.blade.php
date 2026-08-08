{{-- Call to Action Section: CTA banner --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
    $ctaBackground = $resolveImage($content['background_image'] ?? null);
@endphp
<div class="hero bg-section dark-section parallaxie page-block" @if($ctaBackground) style="background-image: url('{{ $ctaBackground }}');" @endif>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="section-content">
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['heading'] ?? 'Ready to Get Started?' }}</h2>
                    @if($content['description'] ?? false)
                        <p class="wow fadeInUp" data-wow-delay="0.2s">{{ $content['description'] }}</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="section-content-btn wow fadeInUp" data-wow-delay="0.4s">
                    <a href="{{ $content['cta_link'] ?? '#contact' }}" class="btn-default btn-highlighted"><span>{{ $content['cta_text'] ?? 'Contact Us' }}</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

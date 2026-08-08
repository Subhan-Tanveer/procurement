{{-- Map with Location Cards --}}
<div class="page-block">
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

        <div class="row">
            <div class="col-lg-{{ ($content['locations'] ?? []) ? '8' : '12' }}">
                <div class="wow fadeInUp" style="border-radius: 10px; overflow: hidden; height: 100%; min-height: 400px;">
                    @if($content['map_embed_url'] ?? false)
                        <iframe src="{{ $content['map_embed_url'] }}"
                                width="100%" height="100%" style="border: 0; min-height: 400px;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div style="height: 100%; min-height: 400px; background: var(--secondary-color); display: flex; align-items: center; justify-content: center; color: var(--text-color);">
                            <div class="text-center">
                                <i class="fa-solid fa-map-location-dot" style="font-size: 48px; margin-bottom: 12px; display: block;"></i>
                                <p>Add a Google Maps embed URL</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($content['locations'] ?? [])
                <div class="col-lg-4">
                    <div class="contact-info-list contact-info-list-vertical">
                        @foreach($content['locations'] as $index => $location)
                            <div class="contact-info-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                                <div class="icon-box">
                                    <img src="{{ asset('site/assets/images/icon-location-white.svg') }}" alt="">
                                </div>
                                <div class="contact-info-item-content">
                                    <h3>{{ $location['title'] ?? '' }}</h3>
                                    @if($location['address'] ?? false)
                                        <p>{{ $location['address'] }}</p>
                                    @endif
                                    @if($location['phone'] ?? false)
                                        <p><a href="tel:{{ preg_replace('/\s+/', '', $location['phone']) }}">{{ $location['phone'] }}</a></p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

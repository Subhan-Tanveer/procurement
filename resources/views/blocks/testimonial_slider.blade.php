{{-- Testimonial Slider: Testimonial carousel --}}
@php
    $testimonialId = 'testimonialSlider_' . uniqid();
@endphp
<div class="our-testimonials bg-section page-block">
    <div class="container">
        @if($content['section_title'] ?? false)
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        @if($content['section_subtitle'] ?? false)
                            <h3 class="wow fadeInUp">{{ $content['section_subtitle'] }}</h3>
                        @endif
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['section_title'] }}</h2>
                    </div>
                </div>
            </div>
        @endif

        <div class="testimonial-slider wow fadeInUp">
            <div class="swiper" id="{{ $testimonialId }}">
                <div class="swiper-wrapper" data-cursor-text="Drag">
                    @foreach(($content['testimonials'] ?? []) as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="testimonial-content">
                                    <p>"{{ $testimonial['testimonial'] ?? '' }}"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="author-content">
                                        <h3>{{ $testimonial['client_name'] ?? '' }}</h3>
                                        @if($testimonial['client_position'] ?? false)
                                            <p>{{ $testimonial['client_position'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="testimonial-pagination"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('{{ $testimonialId }}');
        if (!el || typeof Swiper === 'undefined') return;
        new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: '#{{ $testimonialId }} .testimonial-pagination', clickable: true },
            breakpoints: {
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
            },
        });
    });
</script>
@endpush

{{-- Testimonial Grid: Grid layout for testimonials --}}
<div class="page-testimonials page-block">
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
            @foreach(($content['testimonials'] ?? []) as $index => $testimonial)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="testimonial-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
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
    </div>
</div>

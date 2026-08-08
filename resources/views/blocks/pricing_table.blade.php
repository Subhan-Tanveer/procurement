{{-- Pricing Table: Pricing comparison --}}
<div class="page-pricing page-block">
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

        @php $plans = $content['plans'] ?? []; @endphp
        <div class="row justify-content-center">
            @foreach($plans as $index => $plan)
                @php $isFeatured = $index === 1 && count($plans) >= 3; @endphp
                <div class="col-xl-4 col-md-6">
                    <div class="pricing-item {{ $isFeatured ? 'highlighted-box' : '' }} wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                        <div class="pricing-item-header">
                            <div class="pricing-item-content">
                                <h3>{{ $plan['name'] ?? '' }}</h3>
                                @if($plan['description'] ?? false)
                                    <p>{{ $plan['description'] }}</p>
                                @endif
                            </div>
                            <div class="pricing-item-price">
                                <h2>{{ $plan['price'] ?? '' }}<sub>{{ $plan['period'] ?? '' }}</sub></h2>
                            </div>
                        </div>

                        @if($plan['features'] ?? false)
                            <div class="pricing-item-list">
                                <ul>
                                    @foreach(explode("\n", $plan['features']) as $feature)
                                        @if(trim($feature))
                                            <li>{{ trim($feature) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($plan['cta_text'] ?? false)
                            <div class="pricing-item-btn">
                                <a href="{{ $plan['cta_link'] ?? '#' }}" class="btn-default {{ $isFeatured ? 'btn-highlighted' : '' }}"><span>{{ $plan['cta_text'] }}</span></a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

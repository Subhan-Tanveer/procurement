{{-- FAQ Accordion: FAQ section --}}
@php
    $accordionId = 'faqAccordion_' . uniqid();
@endphp
<div class="page-faqs page-block">
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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-accordion" id="{{ $accordionId }}">
                    @foreach(($content['faqs'] ?? []) as $index => $faq)
                        <div class="accordion-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                            <h2 class="accordion-header" id="{{ $accordionId }}_h{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $accordionId }}_c{{ $index }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-controls="{{ $accordionId }}_c{{ $index }}">
                                    {{ $faq['question'] ?? '' }}
                                </button>
                            </h2>
                            <div id="{{ $accordionId }}_c{{ $index }}"
                                 class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                 aria-labelledby="{{ $accordionId }}_h{{ $index }}"
                                 data-bs-parent="#{{ $accordionId }}">
                                <div class="accordion-body">
                                    <p>{{ $faq['answer'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

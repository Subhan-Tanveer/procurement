{{-- Timeline: Journey/timeline section --}}
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

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="pb-timeline-wrap">
                    @foreach(($content['events'] ?? []) as $index => $event)
                        @php $isLeft = $index % 2 === 0; @endphp
                        <div class="pb-timeline-row wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                            <div class="pb-timeline-dot">
                                <span>{{ $event['year'] ?? ($index + 1) }}</span>
                            </div>
                            <div class="pb-timeline-card {{ $isLeft ? 'pb-timeline-left' : 'pb-timeline-right' }}">
                                <h3>{{ $event['title'] ?? '' }}</h3>
                                @if($event['description'] ?? false)
                                    <p>{{ $event['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pb-timeline-wrap {
        position: relative;
        padding: 20px 0;
    }
    .pb-timeline-wrap::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--divider-color);
        transform: translateX(-50%);
    }
    .pb-timeline-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 40px;
        position: relative;
    }
    .pb-timeline-dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }
    .pb-timeline-dot span {
        display: flex;
        width: 50px;
        height: 50px;
        background: var(--accent-color);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-family: var(--accent-font);
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 0 0 6px rgba(120,181,71,0.15);
    }
    .pb-timeline-card {
        width: 45%;
        background: var(--white-color);
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }
    .pb-timeline-left { margin-right: auto; text-align: right; }
    .pb-timeline-right { margin-left: auto; }
    .pb-timeline-card h3 {
        font-family: var(--accent-font);
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0 0 8px;
    }
    .pb-timeline-card p {
        font-size: 14px;
        color: var(--text-color);
        line-height: 1.7;
        margin: 0;
    }
    @media (max-width: 767px) {
        .pb-timeline-wrap::before { left: 25px; }
        .pb-timeline-dot { left: 25px; }
        .pb-timeline-dot span { width: 44px; height: 44px; font-size: 13px; }
        .pb-timeline-card { width: auto; margin-left: 70px !important; margin-right: 0 !important; text-align: left !important; }
    }
</style>
@endpush

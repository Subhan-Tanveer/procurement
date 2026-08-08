{{-- Scrolling Ticker: Scrolling text --}}
@php
    $text = $content['text'] ?? 'Welcome to Good Procurement Service Ltd';
    $speed = $content['speed'] ?? 50;
    $duration = max(10, 100 - $speed) . 's';
    $tickerId = 'ticker_' . uniqid();
@endphp
<div class="page-block pb-ticker dark-section" style="padding: 0; overflow: hidden;">
    <div class="pb-ticker-track" id="{{ $tickerId }}" style="display: flex; white-space: nowrap; animation: pb-ticker-scroll {{ $duration }} linear infinite; will-change: transform;">
        @for($i = 0; $i < 8; $i++)
            <div style="display: inline-flex; align-items: center; padding: 22px 0; flex-shrink: 0;">
                <span style="font-family: var(--accent-font); font-size: clamp(18px, 2vw, 28px); font-weight: 700; color: #fff; padding: 0 24px;">
                    {{ $text }}
                </span>
                <span style="width: 10px; height: 10px; background: var(--accent-color); border-radius: 50%; flex-shrink: 0;"></span>
            </div>
        @endfor
    </div>
</div>

@push('styles')
<style>
    @keyframes pb-ticker-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .pb-ticker:hover .pb-ticker-track {
        animation-play-state: paused;
    }
</style>
@endpush

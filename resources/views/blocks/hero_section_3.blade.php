{{-- Hero Section 3: Hero with video background --}}
@php
    $videoUrl = $content['video_url'] ?? '';
    $isYouTube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
    $isVimeo = str_contains($videoUrl, 'vimeo.com');
    $videoId = '';

    if ($isYouTube) {
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $m);
        $videoId = $m[1] ?? '';
    } elseif ($isVimeo) {
        preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m);
        $videoId = $m[1] ?? '';
    }
@endphp
<div class="hero bg-section dark-section page-block" style="position: relative; overflow: hidden;">
    @if($isYouTube && $videoId)
        <div class="hero-bg-video">
            <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&modestbranding=1&rel=0" style="position: absolute; top: 50%; left: 50%; width: 120vw; height: 120vh; transform: translate(-50%, -50%); border: 0; pointer-events: none;" allow="autoplay"></iframe>
        </div>
    @elseif($isVimeo && $videoId)
        <div class="hero-bg-video">
            <iframe src="https://player.vimeo.com/video/{{ $videoId }}?background=1&autoplay=1&loop=1&muted=1" style="position: absolute; top: 50%; left: 50%; width: 120vw; height: 120vh; transform: translate(-50%, -50%); border: 0; pointer-events: none;" allow="autoplay"></iframe>
        </div>
    @elseif($videoUrl)
        <div class="hero-bg-video">
            <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset($videoUrl) }}" type="video/mp4"></video>
        </div>
    @endif

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-content">
                    @if($content['subheading'] ?? false)
                        <h3 class="wow fadeInUp">{{ $content['subheading'] }}</h3>
                    @endif

                    <h1 class="text-anime-style-3" data-cursor="-opaque">{{ $content['heading'] ?? 'Welcome' }}</h1>

                    @if($content['description'] ?? false)
                        <p class="wow fadeInUp" data-wow-delay="0.2s">{{ $content['description'] }}</p>
                    @endif

                    @if($content['cta_text'] ?? false)
                        <div class="section-content-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="{{ $content['cta_link'] ?? '#' }}" class="btn-default btn-highlighted"><span>{{ $content['cta_text'] }}</span></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

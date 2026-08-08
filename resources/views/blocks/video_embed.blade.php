{{-- Video Embed: Video section --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };

    $videoUrl = $content['video_url'] ?? '';
    $thumbnail = $resolveImage($content['thumbnail'] ?? null);
    $isYoutube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
    $isVimeo = str_contains($videoUrl, 'vimeo.com');
    $videoId = '';
    $embedUrl = $videoUrl;

    if ($isYoutube) {
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $m);
        $videoId = $m[1] ?? '';
        $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1';
        $autoThumb = $thumbnail ?? ('https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg');
    } elseif ($isVimeo) {
        preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m);
        $videoId = $m[1] ?? '';
        $embedUrl = 'https://player.vimeo.com/video/' . $videoId . '?autoplay=1';
        $autoThumb = $thumbnail;
    } else {
        $autoThumb = $thumbnail;
    }

    $playerId = 'videoPlayer_' . uniqid();
@endphp
<div class="page-video-gallery page-block">
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
                <div class="video-gallery-image wow fadeInUp" id="{{ $playerId }}" data-cursor-text="Play" style="position: relative; aspect-ratio: 16/9; border-radius: 10px; overflow: hidden; cursor: pointer;" onclick="pbPlayVideo(this, '{{ $embedUrl }}')">
                    @if($autoThumb)
                        <figure>
                            <img src="{{ $autoThumb }}" alt="{{ $content['section_title'] ?? 'Video' }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </figure>
                    @endif
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2);">
                        <div style="width: 80px; height: 80px; background: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: transform 0.3s ease;">
                            <i class="fa-solid fa-play" style="color: #fff; font-size: 28px; margin-left: 4px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function pbPlayVideo(el, url) {
    var iframe = document.createElement('iframe');
    iframe.src = url;
    iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:none;';
    iframe.allow = 'autoplay; fullscreen; picture-in-picture';
    iframe.allowFullscreen = true;
    el.innerHTML = '';
    el.appendChild(iframe);
    el.style.cursor = 'default';
    el.onclick = null;
}
</script>
@endpush

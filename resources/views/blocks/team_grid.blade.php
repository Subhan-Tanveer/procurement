{{-- Team Grid: Team members --}}
@php
    $resolveImage = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'page-builder/')) return asset('storage/' . $path);
        return asset($path);
    };
@endphp
<div class="page-block bg-section">
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
            @foreach(($content['members'] ?? []) as $index => $member)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="team-member-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                        @php $photo = $resolveImage($member['photo'] ?? null); @endphp
                        <div class="team-member-image">
                            @if($photo)
                                <figure class="image-anime">
                                    <img src="{{ $photo }}" alt="{{ $member['name'] ?? '' }}">
                                </figure>
                            @endif
                        </div>
                        <div class="team-member-content">
                            <h3>{{ $member['name'] ?? '' }}</h3>
                            @if($member['position'] ?? false)
                                <p>{{ $member['position'] }}</p>
                            @endif
                            @if($member['bio'] ?? false)
                                <p>{{ Str::limit($member['bio'], 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('styles')
<style>
    .team-member-item {
        background: var(--white-color);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team-member-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .team-member-image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .team-member-content {
        padding: 25px;
        text-align: center;
    }
    .team-member-content h3 {
        font-family: var(--accent-font);
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0 0 5px;
    }
    .team-member-content p {
        font-size: 14px;
        color: var(--text-color);
        margin: 0 0 5px;
    }
    .team-member-content p:first-of-type {
        color: var(--accent-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
</style>
@endpush

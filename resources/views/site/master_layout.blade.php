<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('gps_theme');
                var theme = saved || (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    @php
        // Note: @section('name', $value) already HTML-escapes $value when it stores it,
        // so these are rendered with {!! !!} below (not {{ }}) to avoid double-escaping.
        // The literal fallback strings here are escaped manually for the same reason.
        $seoTitle = trim($__env->yieldContent('title')) !== '' ? trim($__env->yieldContent('title')) . ' | Good Procurement Service Ltd' : e('Good Procurement Service Ltd | Procurement You Can Actually Rely On');
        $seoDescription = trim($__env->yieldContent('description')) !== '' ? trim($__env->yieldContent('description')) : e('Professional procurement and supply services across Oil & Gas, Construction, Technology, Maritime, and Corporate sectors in Nigeria. Get a straightforward quote from Good Procurement Service Ltd.');
        $seoRobots = trim($__env->yieldContent('robots')) !== '' ? trim($__env->yieldContent('robots')) : 'index, follow';
    @endphp
    <title>{!! $seoTitle !!}</title>
	<!-- Meta -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="{!! $seoDescription !!}">
	<meta name="keywords" content="procurement services, oil and gas procurement, construction procurement, corporate procurement, supplier management, logistics coordination, Nigeria">
	<meta name="author" content="Good Procurement Service Ltd">
	<meta name="theme-color" content="#426693">
	<meta name="robots" content="{{ $seoRobots }}">
	<link rel="canonical" href="{{ url()->current() }}">

	<!-- Open Graph / Facebook / WhatsApp / LinkedIn -->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Good Procurement Service Ltd">
	<meta property="og:title" content="{!! $seoTitle !!}">
	<meta property="og:description" content="{!! $seoDescription !!}">
	<meta property="og:image" content="{{ asset('site/assets/images/gps-og-cover.jpg') }}">
	<meta property="og:url" content="{{ url()->current() }}">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="{!! $seoTitle !!}">
	<meta name="twitter:description" content="{!! $seoDescription !!}">
	<meta name="twitter:image" content="{{ asset('site/assets/images/gps-og-cover.jpg') }}">

	<!-- Organization structured data -->
	@php
		$orgSchema = [
			'@context' => 'https://schema.org',
			'@type' => 'Organization',
			'name' => 'Good Procurement Service Ltd',
			'url' => url('/'),
			'logo' => asset('site/assets/images/gps logo.png'),
			'contactPoint' => [
				'@type' => 'ContactPoint',
				'telephone' => '+234-816-836-3332',
				'contactType' => 'customer service',
				'areaServed' => 'NG',
				'availableLanguage' => 'English',
			],
			'address' => [
				'@type' => 'PostalAddress',
				'addressLocality' => 'Warri',
				'addressRegion' => 'Delta State',
				'addressCountry' => 'NG',
			],
			'sameAs' => [
				'https://www.linkedin.com/company/goodprocure/',
				'https://x.com/goodprocure',
			],
		];
	@endphp
	<script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

	<!-- Page Title -->
	<!-- Favicon Icons -->
	<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('site/assets/images/gps fav.png') }}">
	<link rel="icon" type="image/png" sizes="64x64" href="{{ asset('site/assets/images/gps fav.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('site/assets/images/gps fav.png') }}">
	<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('site/assets/images/gps fav.png') }}">
	<!-- Google Fonts Css-->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&amp;family=Poppins:wght@500;600;700;800&amp;family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=IBM+Plex+Mono:wght@400;500&amp;display=swap" rel="stylesheet">
	<!-- Bootstrap Css -->
	<link href="{{ asset('site/assets/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<!-- SlickNav Css -->
	<link href="{{ asset('site/assets/css/slicknav.min.css') }}" rel="stylesheet">
	<!-- Swiper Css -->
	<link rel="stylesheet" href="{{ asset('site/assets/css/swiper-bundle.min.css') }}">
	<!-- Font Awesome Icon Css-->
	<link href="{{ asset('site/assets/css/all.min.css') }}" rel="stylesheet" media="screen">
	<!-- Animated Css -->
	<link href="{{ asset('site/assets/css/animate.css') }}" rel="stylesheet">
	<!-- Mouse Cursor Css File -->
	<link rel="stylesheet" href="{{ asset('site/assets/css/mousecursor.css') }}">
	<!-- Main Custom Css -->
	<link href="{{ asset('site/assets/css/custom.css') }}" rel="stylesheet" media="screen">
	<!-- GPS Theme Tokens (dark/light) -->
	<link href="{{ asset('site/assets/css/gps-theme.css') }}" rel="stylesheet" media="screen">
	<!-- GPS Refine Layer (3D, motion, glass panels) -->
	<link href="{{ asset('site/assets/css/gps-refine.css') }}" rel="stylesheet" media="screen">
	<!-- GPS Motion Layer (scroll animation safety net) -->
	<link href="{{ asset('site/assets/css/gps-motion.css') }}" rel="stylesheet" media="screen">
	@stack('styles')
</head>
<body>
<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('site/assets/images/gps fav.png') }}" alt=""></div>
		</div>
	</div>
    @include('site.partials.header')

    <main>
        @include('partials.flash', ['wrapClass' => 'gps-alert-wrap container'])
        @yield('main')
    </main>

    @include('site.partials.footer')

    <!-- Cookie Consent Banner -->
    <div id="gps-cookie-consent" class="gps-cookie-consent" hidden>
        <div class="gps-cookie-consent-inner">
            <p>We use essential cookies to remember your preferences, protect forms, and keep the website working properly. See our <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
            <div class="gps-cookie-consent-actions">
                <button type="button" id="gps-cookie-decline" class="gps-cookie-btn gps-cookie-btn-ghost">Decline</button>
                <button type="button" id="gps-cookie-accept" class="gps-cookie-btn">Accept</button>
            </div>
        </div>
    </div>
    <script>
        (function () {
            var KEY = 'gps_cookie_consent';
            var banner = document.getElementById('gps-cookie-consent');
            if (!banner) return;
            if (!localStorage.getItem(KEY)) {
                banner.hidden = false;
            }
            function setConsent(value) {
                localStorage.setItem(KEY, value);
                banner.hidden = true;
            }
            document.getElementById('gps-cookie-accept').addEventListener('click', function () { setConsent('accepted'); });
            document.getElementById('gps-cookie-decline').addEventListener('click', function () { setConsent('declined'); });
        })();
    </script>

      <!-- Jquery Library File -->
    <script src="{{ asset('site/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Circle Progress Js File -->
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="{{ asset('site/assets/js/bootstrap.min.js') }}"></script>
    <!-- SlickNav js file -->
    <script src="{{ asset('site/assets/js/jquery.slicknav.js') }}"></script>
    <!-- Swiper js file -->
    <script src="{{ asset('site/assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Counter js file -->
    <script src="{{ asset('site/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Parallax js -->
    <script src="{{ asset('site/assets/js/parallaxie.js') }}"></script>
    <!-- MagicCursor js file -->
    <script src="{{ asset('site/assets/js/gsap.min.js') }}"></script>
    <!-- Text Effect js file -->
    <script src="{{ asset('site/assets/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/ScrollTrigger.min.js') }}"></script>
    <!-- Wow js file -->
    <script src="{{ asset('site/assets/js/wow.min.js') }}"></script>
    <!-- Main Custom js file -->
    <script src="{{ asset('site/assets/js/function.js') }}"></script>
    <!-- GPS Refine Layer js file (theme toggle, 3D scene, motion) -->
    <script src="{{ asset('site/assets/js/gps-refine.js') }}"></script>
    <!-- GPS Motion Layer js file (scroll animation system) -->
    <script src="{{ asset('site/assets/js/gps-motion.js') }}"></script>
    @stack('scripts')

</body>
</html>

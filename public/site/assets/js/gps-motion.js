/* ----------------------------------------------------------------------------------------
 * GoodProcure — Motion Layer
 * Every .wow-marked element (already present on all 10 pages from the original template)
 * gets picked up here and given a varied, high-impact GSAP/ScrollTrigger entrance instead
 * of the old flat WOW.js fadeInUp — WOW.js itself is disabled in function.js. Siblings
 * inside the same list/grid cycle through different variants so nothing reveals uniformly.
 * Also: magnetic buttons, parallax imagery, a pinned hero release, and a scroll-scrubbed
 * tilt on the 3D network scene. Fully respects prefers-reduced-motion.
 * -------------------------------------------------------------------------------------- */
(function () {
	'use strict';
	if (typeof gsap === 'undefined') return;

	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var isTouch = 'ontouchstart' in window;

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	ready(function () {
		if (typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);

		if (reducedMotion) {
			document.querySelectorAll('.wow').forEach(function (el) { el.style.opacity = '1'; });
			return;
		}

		/* ---------- Entrance variant library ---------- */
		var VARIANTS = {
			fadeUp: { from: { y: 70, opacity: 0 }, to: { y: 0, opacity: 1 } },
			fadeDown: { from: { y: -60, opacity: 0 }, to: { y: 0, opacity: 1 } },
			slideLeft: { from: { x: -100, opacity: 0 }, to: { x: 0, opacity: 1 } },
			slideRight: { from: { x: 100, opacity: 0 }, to: { x: 0, opacity: 1 } },
			scaleIn: { from: { scale: 0.8, opacity: 0 }, to: { scale: 1, opacity: 1 } },
			flip3D: { from: { rotateX: -80, opacity: 0, transformPerspective: 900, transformOrigin: '50% 0%' }, to: { rotateX: 0, opacity: 1 } },
			skewReveal: { from: { y: 60, skewY: 6, opacity: 0 }, to: { y: 0, skewY: 0, opacity: 1 } },
			rotateIn: { from: { rotate: -7, scale: 0.9, opacity: 0 }, to: { rotate: 0, scale: 1, opacity: 1 } },
			clipReveal: { from: { clipPath: 'inset(0% 0% 100% 0%)', opacity: 1 }, to: { clipPath: 'inset(0% 0% 0% 0%)', opacity: 1 } }
		};
		var VARIANT_NAMES = Object.keys(VARIANTS);

		function reveal(el, variantName, opts) {
			opts = opts || {};
			var v = VARIANTS[variantName] || VARIANTS.fadeUp;
			gsap.set(el, v.from);
			gsap.to(el, Object.assign({
				ease: opts.ease || 'power3.out',
				duration: opts.duration || 1,
				delay: opts.delay || 0,
				scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' }
			}, v.to));
		}

		/* ---------- Known repeating groups get a curated per-family variant cycle ---------- */
		var FAMILIES = [
			{ parent: '.gps-service-list', cycle: ['slideLeft', 'slideRight'] },
			{ parent: '.gps-process-grid', cycle: ['flip3D'] },
			{ parent: '.gps-matters-list', cycle: ['slideLeft'] },
			{ parent: '.gps-why-list', cycle: ['scaleIn', 'rotateIn'] },
			{ parent: '.gps-faq-list', cycle: ['skewReveal'] },
			{ parent: '.gps-products-grid', cycle: ['scaleIn', 'flip3D'] },
			{ parent: '.gps-footer-top', cycle: ['fadeUp'] },
			{ parent: '.gps-about-points', cycle: ['slideLeft'] },
			{ parent: '.gps-service-extra', cycle: ['slideLeft', 'slideRight'] }
		];

		var wowEls = Array.prototype.slice.call(document.querySelectorAll('.wow'));
		var globalIndex = 0;

		wowEls.forEach(function (el) {
			if (el.closest('.gps-marquee')) return; // marquee already animates continuously — don't fight it

			el.classList.remove('fadeInUp', 'fadeIn');

			var family = FAMILIES.find(function (f) {
				return el.parentElement && el.parentElement.closest(f.parent);
			});

			var variantName;
			var delay = Math.min(parseFloat(el.getAttribute('data-wow-delay')) || 0, 0.4);

			if (family) {
				var siblingIndex = Array.prototype.indexOf.call(el.parentElement.children, el);
				variantName = family.cycle[siblingIndex % family.cycle.length];
				delay = (siblingIndex % 4) * 0.08;
			} else {
				variantName = VARIANT_NAMES[globalIndex % VARIANT_NAMES.length];
			}

			globalIndex++;
			reveal(el, variantName, { delay: delay });
		});

		/* ---------- Parallax imagery (continuous scroll-linked drift, not just entrance) ---------- */
		var parallaxTargets = Array.prototype.filter.call(
			document.querySelectorAll(
				'.gps-about-figure img, .gps-why-figure img, .gps-product-card-media img, .hero-fade-slideshow img'
			),
			// The team bubble avatars are tightly-cropped circles with no
			// extra image margin, so any parallax shift immediately exposes
			// empty space at the top/bottom edge of the circle.
			function (img) { return !img.closest('.gps-team-bubble'); }
		);
		parallaxTargets.forEach(function (img) {
			gsap.fromTo(img, { yPercent: -8 }, {
				yPercent: 8,
				ease: 'none',
				scrollTrigger: { trigger: img, start: 'top bottom', end: 'bottom top', scrub: 0.6 }
			});
		});

		/* ---------- 3D network scene: scroll-scrubbed tilt on top of its own internal animation ---------- */
		var networkScene = document.querySelector('.gps-network-scene');
		if (networkScene) {
			gsap.fromTo(networkScene, { rotateX: 6, rotateY: -4, scale: 0.96 }, {
				rotateX: -3,
				rotateY: 3,
				scale: 1,
				ease: 'none',
				scrollTrigger: { trigger: networkScene, start: 'top bottom', end: 'bottom top', scrub: 0.8 }
			});
		}

		/* ---------- Pinned hero release (homepage only) ---------- */
		var hero = document.querySelector('.hero-elite');
		if (hero && typeof ScrollTrigger !== 'undefined') {
			var heroVideo = hero.querySelector('.gps-hero-video');
			var heroContent = hero.querySelector('.hero-content-elite');
			ScrollTrigger.create({
				trigger: hero,
				start: 'top top',
				end: '+=45%',
				pin: true,
				pinSpacing: true,
				scrub: 0.6,
				onUpdate: function (self) {
					var p = self.progress;
					if (heroVideo) gsap.set(heroVideo, { scale: 1 + p * 0.12, filter: 'brightness(' + (1 - p * 0.35) + ')' });
					if (heroContent) gsap.set(heroContent, { opacity: 1 - p * 1.1, y: p * -60 });
				}
			});
		}

		/* ---------- Magnetic buttons ---------- */
		if (!isTouch) {
			document.querySelectorAll('.btn-default').forEach(function (btn) {
				var xTo = gsap.quickTo(btn, 'x', { duration: 0.4, ease: 'power3' });
				var yTo = gsap.quickTo(btn, 'y', { duration: 0.4, ease: 'power3' });
				btn.addEventListener('mousemove', function (e) {
					var r = btn.getBoundingClientRect();
					xTo((e.clientX - r.left - r.width / 2) * 0.35);
					yTo((e.clientY - r.top - r.height / 2) * 0.35);
				});
				btn.addEventListener('mouseleave', function () {
					xTo(0);
					yTo(0);
				});
			});
		}

		if (typeof ScrollTrigger !== 'undefined') {
			ScrollTrigger.addEventListener('refreshInit', function () {});
			window.addEventListener('load', function () { ScrollTrigger.refresh(); });
		}
	});
})();

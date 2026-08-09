/* ----------------------------------------------------------------------------------------
 * GoodProcure — Refine Layer JS
 * Theme toggle, hero canvas backdrop, 3D supply-chain network (three.js, lazy-loaded),
 * scroll-drawn process lines (GSAP ScrollTrigger — already loaded globally), 3D tilt cards.
 * Everything here respects prefers-reduced-motion and degrades on narrow/mobile viewports.
 * -------------------------------------------------------------------------------------- */
(function () {
	'use strict';

	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var isMobileViewport = window.innerWidth < 768;

	/* Theme now always mirrors the OS color-scheme setting — see the boot script in
	   master_layout.blade.php. No manual toggle here anymore. */

	/* ---------- Hero / page-header background video ---------- */
	function initHeroVideos() {
		document.querySelectorAll('.gps-hero-video').forEach(function (video) {
			if (reducedMotion) {
				video.removeAttribute('autoplay');
				video.pause();
				video.style.display = 'none';
				return;
			}
			// If the clip hasn't been supplied yet (404) or fails to decode, fall back
			// to the section's existing poster/background image instead of a broken box.
			video.addEventListener('error', function () {
				video.style.display = 'none';
			}, true);
			video.play().catch(function () { /* autoplay blocked — poster stays visible */ });
		});
	}

	/* ---------- Hero cinematic canvas (2D particle network, brand-colored) ---------- */
	function initHeroCanvas() {
		var wrap = document.querySelector('.gps-hero-canvas-wrap');
		if (!wrap || reducedMotion) return;

		var canvas = document.createElement('canvas');
		wrap.appendChild(canvas);
		var ctx = canvas.getContext('2d');
		var width, height, particles;
		var PARTICLE_COUNT = isMobileViewport ? 22 : 46;

		function resize() {
			width = canvas.width = wrap.clientWidth;
			height = canvas.height = wrap.clientHeight;
		}

		function makeParticles() {
			particles = [];
			for (var i = 0; i < PARTICLE_COUNT; i++) {
				particles.push({
					x: Math.random() * width,
					y: Math.random() * height,
					vx: (Math.random() - 0.5) * 0.35,
					vy: (Math.random() - 0.5) * 0.35
				});
			}
		}

		function frame() {
			ctx.clearRect(0, 0, width, height);
			ctx.strokeStyle = '#33C7FF';
			ctx.fillStyle = '#FFB020';

			for (var i = 0; i < particles.length; i++) {
				var p = particles[i];
				p.x += p.vx;
				p.y += p.vy;
				if (p.x < 0 || p.x > width) p.vx *= -1;
				if (p.y < 0 || p.y > height) p.vy *= -1;

				ctx.beginPath();
				ctx.arc(p.x, p.y, 1.6, 0, Math.PI * 2);
				ctx.fill();

				for (var j = i + 1; j < particles.length; j++) {
					var q = particles[j];
					var dx = p.x - q.x, dy = p.y - q.y;
					var dist = Math.sqrt(dx * dx + dy * dy);
					if (dist < 140) {
						ctx.globalAlpha = 1 - dist / 140;
						ctx.lineWidth = 1;
						ctx.beginPath();
						ctx.moveTo(p.x, p.y);
						ctx.lineTo(q.x, q.y);
						ctx.stroke();
						ctx.globalAlpha = 1;
					}
				}
			}
			requestAnimationFrame(frame);
		}

		resize();
		makeParticles();
		window.addEventListener('resize', function () {
			resize();
			makeParticles();
		});
		requestAnimationFrame(frame);
	}

	/* ---------- 3D supply-chain network scene ---------- */
	function initNetworkScene() {
		var container = document.querySelector('.gps-network-scene');
		if (!container) return;

		if (reducedMotion || isMobileViewport) {
			container.classList.add('gps-fallback-active');
			return;
		}

		var loaded = false;
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting && !loaded) {
					loaded = true;
					loadThreeAndBuildScene(container).catch(function () {
						container.classList.add('gps-fallback-active');
					});
				}
			});
		}, { rootMargin: '200px' });
		observer.observe(container);
	}

	function loadThreeAndBuildScene(container) {
		return import('https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js').then(function (THREE) {
			var width = container.clientWidth;
			var height = container.clientHeight;

			var scene = new THREE.Scene();
			var camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 100);
			camera.position.set(0, 0, 9);

			var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
			renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
			renderer.setSize(width, height);
			container.appendChild(renderer.domElement);

			var labels = ['Sourcing', 'Vendor Management', 'Quality Assurance', 'Supply Chain'];
			var positions = [
				new THREE.Vector3(-3, 1.6, 0),
				new THREE.Vector3(3, 1.6, 0),
				new THREE.Vector3(-3, -1.6, 0),
				new THREE.Vector3(3, -1.6, 0)
			];

			var nodeGroup = new THREE.Group();
			var nodeMat = new THREE.MeshBasicMaterial({ color: 0xffb020 });
			var nodeGeo = new THREE.SphereGeometry(0.28, 24, 24);
			positions.forEach(function (pos) {
				var mesh = new THREE.Mesh(nodeGeo, nodeMat);
				mesh.position.copy(pos);
				nodeGroup.add(mesh);
			});
			scene.add(nodeGroup);

			var lineMat = new THREE.LineBasicMaterial({ color: 0x33c7ff, transparent: true, opacity: 0.55 });
			var edges = [[0, 1], [0, 2], [1, 3], [2, 3], [0, 3], [1, 2]];
			edges.forEach(function (edge) {
				var geo = new THREE.BufferGeometry().setFromPoints([positions[edge[0]], positions[edge[1]]]);
				scene.add(new THREE.Line(geo, lineMat));
			});

			var particleCount = 120;
			var particleGeo = new THREE.BufferGeometry();
			var particlePositions = new Float32Array(particleCount * 3);
			var particleEdge = new Array(particleCount);
			var particleT = new Array(particleCount);
			for (var i = 0; i < particleCount; i++) {
				particleEdge[i] = edges[i % edges.length];
				particleT[i] = Math.random();
			}
			particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
			var particleMat = new THREE.PointsMaterial({ color: 0xffb020, size: 0.06 });
			var particles = new THREE.Points(particleGeo, particleMat);
			scene.add(particles);

			var clock = new THREE.Clock();
			var rafId;

			function animate() {
				rafId = requestAnimationFrame(animate);
				var dt = clock.getDelta();

				for (var i = 0; i < particleCount; i++) {
					particleT[i] += dt * 0.15;
					if (particleT[i] > 1) particleT[i] -= 1;
					var a = positions[particleEdge[i][0]];
					var b = positions[particleEdge[i][1]];
					var t = particleT[i];
					particlePositions[i * 3] = a.x + (b.x - a.x) * t;
					particlePositions[i * 3 + 1] = a.y + (b.y - a.y) * t;
					particlePositions[i * 3 + 2] = a.z + (b.z - a.z) * t;
				}
				particleGeo.attributes.position.needsUpdate = true;

				nodeGroup.rotation.y = Math.sin(clock.elapsedTime * 0.2) * 0.15;
				scene.rotation.x = Math.sin(clock.elapsedTime * 0.15) * 0.05;

				renderer.render(scene, camera);
			}
			animate();

			function onResize() {
				var w = container.clientWidth;
				var h = container.clientHeight;
				camera.aspect = w / h;
				camera.updateProjectionMatrix();
				renderer.setSize(w, h);
			}
			window.addEventListener('resize', onResize);

			var mql = window.matchMedia('(prefers-reduced-motion: reduce)');
			mql.addEventListener('change', function (e) {
				if (e.matches) {
					cancelAnimationFrame(rafId);
					container.classList.add('gps-fallback-active');
					renderer.domElement.remove();
				}
			});
		});
	}

	/* ---------- Scroll-drawn process progress line ---------- */
	function initProcessLines() {
		if (reducedMotion || typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
		gsap.registerPlugin(ScrollTrigger);

		document.querySelectorAll('.gps-process-line-path').forEach(function (path) {
			var wrap = path.closest('.gps-process-line-wrap');
			if (!wrap) return;
			gsap.to(path, {
				strokeDashoffset: 0,
				ease: 'none',
				scrollTrigger: {
					trigger: wrap,
					start: 'top 75%',
					end: 'bottom 60%',
					scrub: 0.6
				}
			});
		});
	}

	/* ---------- Service card 3D tilt-on-hover ---------- */
	function initTiltCards() {
		if (reducedMotion || isMobileViewport || 'ontouchstart' in window) return;

		document.querySelectorAll('.service-item-elite').forEach(function (card) {
			card.addEventListener('mousemove', function (e) {
				var rect = card.getBoundingClientRect();
				var relX = (e.clientX - rect.left) / rect.width - 0.5;
				var relY = (e.clientY - rect.top) / rect.height - 0.5;
				card.style.transform = 'rotateX(' + (relY * -6) + 'deg) rotateY(' + (relX * 6) + 'deg) translateY(-2px)';
			});
			card.addEventListener('mouseleave', function () {
				card.style.transform = '';
			});
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		initHeroVideos();
		initHeroCanvas();
		initNetworkScene();
		initProcessLines();
		initTiltCards();
	});
})();

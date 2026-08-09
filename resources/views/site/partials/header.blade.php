	<header class="main-header header-elite">
		<div class="header-sticky bg-section">
			<nav class="navbar navbar-expand-lg">
				<div class="container-fluid">
					<!-- Logo Start -->
					<a class="navbar-brand brand-logo-elite" href="{{ url('/') }}">
						<img src="{{ asset('site/assets/images/gps logo.png') }}" alt="Good Procurement Service Ltd">
					</a>
					<!-- Logo End -->

                    <!-- Main Menu Start -->
                    <div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#about">About Us</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#services">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/blog') }}">Blog</a></li>
                                <!-- PAGES SUBMENU - COMMENTED OUT (Pages not yet implemented)
                                <li class="nav-item submenu"><a class="nav-link" href="#">Pages</a>
                                    <ul>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/service-details') }}">Service Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/blog-details') }}">Blog Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/projects') }}">Projects</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/project-details') }}">Project Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/team') }}">Our Team</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/team-details') }}">Team Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/pricing') }}">Pricing Plan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/testimonials') }}">Testimonials</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/gallery') }}">Image Gallery</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/video-gallery') }}">Video Gallery</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/faqs') }}">FAQs</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('/404') }}">404</a></li>
                                    </ul>
                                </li>
                                END PAGES SUBMENU -->
                                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#contact">Contact Us</a></li>
                            </ul>
                        </div>

                        <!-- Header Contact Box Start -->
                        <div class="header-contact-box">
                            <!-- Theme Toggle Start -->
                            <button type="button" class="gps-theme-toggle" aria-label="Toggle dark and light mode">
                                <svg class="gps-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"></path></svg>
                                <svg class="gps-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"></path></svg>
                            </button>
                            <!-- Theme Toggle End -->
                            <!-- Header Contact Item Start -->
                            <div class="header-contact-item">
                                <div class="icon-box">
                                    <img src="{{ asset('site/assets/images/icon-phone-white.svg') }}" alt="">
                                </div>
                                <div class="header-contact-item-content">
                                    <p>Need Help!</p>
                                    <h3><a href="tel:+2348168363332">+234 816 836 3332</a></h3>
                                </div>
                            </div>
                            <!-- Header Contact Item End -->

                            <!-- Header Btn Start -->
                            <div class="header-btn">
                                <a href="{{ url('/') }}#contact" class="btn-default">Get a Quote</a>
                            </div>
                            <!-- Header Btn End -->
                        </div>
                        <!-- Hedaer Contact Box End -->
                    </div>
					<!-- Main Menu End -->
					<div class="navbar-toggle"></div>
				</div>
			</nav>
			<div class="responsive-menu"></div>
		</div>
	</header>

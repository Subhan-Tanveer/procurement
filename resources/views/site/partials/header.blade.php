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

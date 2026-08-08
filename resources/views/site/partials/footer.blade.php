    <footer class="gps-footer">
        <div class="container">
            <div class="gps-footer-top">
                <!-- Footer Brand Start -->
                <div class="gps-footer-brand">
                    <a href="{{ url('/') }}" class="gps-footer-logo">
                        <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="Good Procurement Service Ltd">
                    </a>
                    <p>Good Procurement Service Ltd delivers professional procurement solutions, connecting businesses with quality materials, equipment, and supplies across Oil &amp; Gas, Construction, and Corporate sectors.</p>
                    <div class="gps-footer-social">
                        <a href="https://www.linkedin.com/company/goodprocure/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://x.com/goodprocure" target="_blank" rel="noopener" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
                <!-- Footer Brand End -->

                <!-- Footer Links Start -->
                <div class="gps-footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/') }}#about">About Us</a></li>
                        <li><a href="{{ url('/') }}#services">Services</a></li>
                        <li><a href="{{ url('/blog') }}">Latest News</a></li>
                    </ul>
                </div>
                <!-- Footer Links End -->

                <!-- Footer Services Start -->
                <div class="gps-footer-col">
                    <h3>Our Services</h3>
                    <ul>
                        <li><a href="{{ route('services.show', 'office-admin-corporate-procurement') }}">Office &amp; Corporate</a></li>
                        <li><a href="{{ route('services.show', 'technology-it-procurement') }}">Technology &amp; IT</a></li>
                        <li><a href="{{ route('services.show', 'construction-infrastructure-procurement') }}">Construction &amp; Infrastructure</a></li>
                        <li><a href="{{ route('services.show', 'oil-gas-procurement') }}">Oil &amp; Gas</a></li>
                    </ul>
                </div>
                <!-- Footer Services End -->

                <!-- Footer Contact Start -->
                <div class="gps-footer-col gps-footer-contact">
                    <h3>Let's Connect</h3>
                    <a href="tel:+2348168363332" class="gps-footer-phone">+234 816 836 3332</a>
                    <a href="{{ url('/') }}#contact" class="btn-default">Get a Quote</a>
                </div>
                <!-- Footer Contact End -->
            </div>

            <div class="gps-footer-bottom">
                <p>Copyright &copy; {{ date('Y') }} Good Procurement Service Ltd. All Rights Reserved.</p>
                <p><a href="{{ route('privacy') }}">Privacy Policy</a> &middot; <a href="{{ route('terms') }}">Terms of Service</a></p>
            </div>
        </div>
    </footer>

@extends('site.master_layout')

@section('title', 'Procurement You Can Actually Rely On')
@section('description', 'Good Procurement Service Ltd delivers professional procurement and supply services across Oil & Gas, Construction, Technology, Maritime, and Corporate sectors in Nigeria. Get a straightforward quote.')

@push('styles')
<link rel="stylesheet" href="{{ asset('site/assets/css/gps-home.css') }}">
<style>
    .gps-hero-title {
        font-weight: 500;
    }
    .gps-hero-service-board {
        position: absolute;
        left: 26px;
        right: 26px;
        bottom: 26px;
        z-index: 3;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        padding: 20px;
        border-radius: 20px;
        background: linear-gradient(180deg, rgba(7, 18, 34, 0.18), rgba(7, 18, 34, 0.78));
        backdrop-filter: blur(8px);
    }
    .gps-hero-service-chip {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 15px;
        /* border-radius: 15px; */
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    .gps-hero-service-copy { min-width: 0; }
    .gps-hero-service-kicker {
        display: block;
        margin-bottom: 6px;
        color: rgba(255,255,255,0.72);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }
    .gps-hero-service-title {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.42;
    }
    .gps-hero-service-state {
        flex-shrink: 0;
        margin-top: 1px;
        padding: 6px 9px;
        /* border-radius: 999px; */
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .gps-hero-service-state.is-growing {
        color: #0e3c1f;
        background: #9ddf7a;
    }
    .gps-hero-service-state.is-progress {
        color: #5c4300;
        background: #f4d37f;
    }
    .gps-why-us-copy {
        padding-right: 24px;
    }
    .gps-why-us-visual {
        margin-bottom: 28px;
    }
    .gps-why-us-visual figure {
        margin: 0;
        border-radius: 20px;
        overflow: hidden;
    }
    .gps-why-us-visual img {
        display: block;
        width: 100%;
        max-height: 320px;
        object-fit: cover;
    }
    .gps-why-us-card {
        height: 100%;
    }
    .gps-why-us-card-row {
        row-gap: 24px;
    }
    @media (max-width: 991px) {
        .gps-hero-title {
            max-width: none;
        }
        .gps-hero-service-board {
            position: relative;
            left: auto;
            right: auto;
            bottom: auto;
            margin-top: 20px;
            grid-template-columns: 1fr;
            padding: 15px;
            border-radius: 16px;
        }
        .gps-why-us-copy {
            padding-right: 0;
            margin-bottom: 28px;
        }
        .gps-why-us-visual img {
            max-height: 260px;
        }
    }
    @media (max-width: 575px) {
        .gps-hero-title {
            font-weight: 500;
            line-height: 1.15;
        }
        .gps-hero-service-chip {
            padding: 12px;
            gap: 12px;
        }
        .gps-hero-service-title {
            font-size: 13px;
        }
        .gps-hero-service-state {
            font-size: 9px;
            padding: 5px 8px;
        }
        .gps-why-us-visual {
            margin-bottom: 20px;
        }
        .gps-why-us-visual img {
            max-height: 220px;
        }
    }
</style>
@endpush

@section('main')
    <!-- Hero Section Start -->
    <div class="hero-elite bg-section">
        <video class="gps-hero-video" autoplay muted loop playsinline preload="none" poster="{{ asset('site/assets/images/hero-image-1-elite.jpg') }}" aria-hidden="true">
            <source src="{{ asset('site/assets/videos/hero-home.mp4') }}" type="video/mp4">
        </video>
        <div class="gps-video-overlay" aria-hidden="true"></div>
        <div class="gps-hero-canvas-wrap" aria-hidden="true"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Hero Content Start -->
                    <div class="hero-content-elite">
                        <!-- Hero Content Header Start -->
                        <div class="hero-content-header-elite">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h3 class="wow fadeInUp">Welcome to Good Procurement Service Ltd</h3>
                                <h1 class="text-anime-style-3 gps-hero-title" data-cursor="-opaque">Procurement You Can Actually Rely On.</h1>
                                <p class="hero-tagline-elite wow fadeInUp" data-wow-delay="0.1s">Done Right.</p>
                                <p class="wow fadeInUp" data-wow-delay="0.2s">We're a professional procurement and supply company helping businesses across Nigeria access quality materials, equipment, and supplies reliably, efficiently, and cost-effectively across Oil &amp; Gas, Construction, Corporate Services, and Maritime. We're growing into Healthcare and Hospitality too.</p>
                                <p class="wow fadeInUp" data-wow-delay="0.3s"> We are a growing company, and that means you get our full attention. Not just call centers, not just account managers but a dedicated team that listens, understands your needs, and follows through.</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- Section Button Start -->
                            <div class="section-btn-elite wow fadeInUp" data-wow-delay="0.4s">
                                <a href="{{ url('/') }}#contact" class="btn-default">Request a Free Quote</a>
                                <a href="https://wa.me/2348168363332" target="_blank" rel="noopener" class="btn-default gps-btn-ghost" style="margin-left: 12px;">Talk to Us</a>
                            </div>
                            <!-- Section Button End -->
                        </div>
                        <!-- Hero Content Header End -->

                        <!-- Hero Content Body Start -->
                        <div class="hero-content-body-elite wow fadeInUp" data-wow-delay="0.5s">
                            <ul>
                                <li>Reliable Sourcing & Supply</li>
                                <li>Cost-Effective Solutions</li>
                                <li>Expert Supplier Management</li>
                            </ul>
                        </div>
                        <!-- Hero Content Body End -->
                    </div>
                    <!-- Hero Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Marquee Ticker Start -->
    <div class="gps-marquee" aria-hidden="true">
        @php
            $gpsTickerTags = ['Reliable Sourcing', 'Vendor Management', 'Quality Assurance', 'Supply Chain', 'Honest Timelines', 'Direct Communication', 'Clear Quotations', 'Careful Vetting'];
        @endphp
        <div class="gps-marquee-track">
            @for ($i = 0; $i < 2; $i++)
                @foreach ($gpsTickerTags as $tag)
                    <span>{{ $tag }}</span>
                @endforeach
            @endfor
        </div>
    </div>
    <!-- Marquee Ticker End -->

    <!-- Trust Strip Start -->
    <div class="gps-trust-strip">
        <div class="container">
            <div class="gps-trust-strip-inner">
                <div>
                    <h3>Growing company. Full attention.</h3>
                    <p>Every client gets the kind of direct, hands-on service that gets diluted once a company scales. You're not a small account to us.</p>
                </div>
                <div class="gps-trust-tags">
                    <span>Careful Vetting</span>
                    <span>Direct Communication</span>
                    <span>Honest Timelines</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Trust Strip End -->

    <!-- Why This Matters Section Start -->
    <div class="gps-section gps-section--tight">
        <div class="container">
            <div class="gps-kicker wow fadeInUp">Why This Matters</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">You already understand procurement. You just call it something else.</h2>
            <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">Procurement is just a formal word for something you already understand. It means making sure what you asked for is actually what shows up, at a fair price, from someone who didn't cut corners to get it to you. We've all been there. You want something specific and can't find the right source, so you settle, or worse, you pay too much for something that turns out to be fake. That's the gap we exist to close.</p>

            <div class="gps-matters-grid">
                <div class="gps-matters-list wow fadeInUp" data-wow-delay="0.2s">
                    <div class="gps-matters-row">
                        <div class="gps-matters-num">01</div>
                        <div>
                            <div class="gps-matters-term">Sourcing</div>
                            <p class="gps-matters-def">Finding the real thing, not a knockoff.</p>
                        </div>
                    </div>
                    <div class="gps-matters-row">
                        <div class="gps-matters-num">02</div>
                        <div>
                            <div class="gps-matters-term">Vendor Management</div>
                            <p class="gps-matters-def">One person to call, not ten to chase.</p>
                        </div>
                    </div>
                    <div class="gps-matters-row">
                        <div class="gps-matters-num">03</div>
                        <div>
                            <div class="gps-matters-term">Quality Assurance</div>
                            <p class="gps-matters-def">We check it before you have to.</p>
                        </div>
                    </div>
                    <div class="gps-matters-row">
                        <div class="gps-matters-num">04</div>
                        <div>
                            <div class="gps-matters-term">Supply Chain</div>
                            <p class="gps-matters-def">Getting it from source to you, without the runaround.</p>
                        </div>
                    </div>
                </div>

                <!-- Matters Visual Start -->
                <div class="gps-matters-visual wow fadeInUp" data-wow-delay="0.3s">
                    <figure style="margin:0; height:100%; border-radius:20px; overflow:hidden;">
                        <img src="{{ asset('site/assets/images/hero-image-1-elite.jpg') }}" alt="Good Procurement team checking inventory" style="width:100%; height:100%; min-height:360px; object-fit:cover; display:block;" loading="lazy" decoding="async">
                    </figure>
                </div>
                <!-- Matters Visual End -->
            </div>
        </div>
    </div>
    <!-- Why This Matters Section End -->

    <!-- About Us Section Start -->
    <div class="gps-section gps-section--tight" id="about">
        <div class="container">
            <div class="gps-about-grid">
                <div class="gps-about-figure">
                    <figure class="image-anime reveal" style="margin:0;">
                        <img src="{{ asset('site/assets/images/about-us-image-elite.jpg') }}?v={{ filemtime(public_path('site/assets/images/about-us-image-elite.jpg')) }}" alt="Good Procurement team member reviewing supplies" loading="lazy" decoding="async">
                    </figure>
                </div>

                <div>
                    <div class="gps-kicker wow fadeInUp">About Us</div>
                    <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">Your procurement partner, done properly, every time.</h2>
                    <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">We provide comprehensive procurement services. From sourcing quality materials to managing suppliers and coordinating timely delivery. We support Oil &amp; Gas, Construction, Corporate Services, and Maritime operations, and we're growing into Healthcare and Hospitality too.</p>

                    <div class="gps-about-points wow fadeInUp" data-wow-delay="0.4s">
                        <div class="gps-about-point">
                            <div class="gps-about-point-mark">01</div>
                            <div>
                                <h3>Industry Focus</h3>
                                <p>We're starting with Office &amp; Corporate, IT, Construction &amp; Infrastructure, and Oil &amp; Gas &amp; Maritime procurement. These are the categories we can execute reliably right now. Healthcare and Hospitality are next as we grow.</p>
                            </div>
                        </div>
                        <div class="gps-about-point">
                            <div class="gps-about-point-mark">02</div>
                            <div>
                                <h3>Direct Support</h3>
                                <p>No call center, no account handoffs. You deal directly with the people managing your sourcing.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-callout wow fadeInUp" data-wow-delay="0.5s">
                        <h4>Growing steadily, doing it right.</h4>
                        <p>We're a growing company, and we'd rather show that plainly than borrow a track record that isn't ours. What you get: careful sourcing, honest timelines, and a team building its reputation with every order, starting with yours.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Section End -->

    <!-- Founder Quote Section Start -->
    <div class="gps-section gps-section--tight">
        <div class="container">
            <div class="gps-quote wow fadeInUp">
                <div class="gps-quote-mark" aria-hidden="true">&ldquo;</div>
                <p>I started Good Procurement Service Ltd because I saw how limited we were by where we could shop. You want something specific, but if you can't get it, you end up settling for something you don't really like or nothing at all. And deep down, you're never truly happy with it.</p>
                <p>That's when I realized the real problem: a supply chain gap. People and businesses were paying exorbitant prices for fake, ingenuine goods when they could have gotten the real thing for less  often without even knowing they'd been sold a fake.</p>
                <p>I realized there are people who don't want to worry about it  and that there are people like me who are willing to go through thick and thin to get them the real deal. This company exists for that sole reason.</p>
                <div class="gps-quote-sign">Joseph Ogumba, Founder, Good Procurement Service Ltd</div>
            </div>
        </div>
    </div>
    <!-- Founder Quote Section End -->

    <!-- Our Services Section Start -->
    <div class="gps-section bg-section" id="services">
        <div class="container">
            <div class="gps-kicker wow fadeInUp">Our Services</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">Procurement built around your industry</h2>
            <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">Six categories, chosen for what we can execute reliably today.</p>

            @php
                $serviceCards = [
                    [
                        'slug' => 'office-admin-corporate-procurement',
                        'icon' => 'fa-solid fa-briefcase',
                        'name' => 'Office, Admin & Corporate Procurement',
                        'description' => 'Everyday operational needs for corporate offices, with recurring demand and quick turnaround.',
                    ],
                    [
                        'slug' => 'technology-it-procurement',
                        'icon' => 'fa-solid fa-laptop',
                        'name' => 'Technology & Digital (IT) Procurement',
                        'description' => 'Supporting your technology infrastructure needs.',
                    ],
                    [
                        'slug' => 'construction-infrastructure-procurement',
                        'icon' => 'fa-solid fa-hard-hat',
                        'name' => 'Construction & Infrastructure Procurement',
                        'description' => 'Light to medium construction and infrastructure sourcing, project by project.',
                    ],
                    [
                        'slug' => 'oil-gas-procurement',
                        'icon' => 'fa-solid fa-gas-pump',
                        'name' => 'Oil & Gas Procurement & Consumables',
                        'description' => 'Sourcing for oil and gas operations, right-sized to where we are today and growing with every engagement.',
                    ],
                    [
                        'slug' => 'maritime-supply',
                        'icon' => 'fa-solid fa-ship',
                        'name' => 'Maritime Supply',
                        'description' => 'Vessel supply for marine and offshore operations.',
                    ],
                    [
                        'slug' => 'site-camp-welfare-supplies',
                        'icon' => 'fa-solid fa-bed',
                        'name' => 'Site & Camp Welfare Supplies',
                        'description' => 'Everyday living essentials for men on site or on the rig, so working away from home does not mean going without.',
                    ],
                ];
            @endphp
            <div class="gps-service-list">
                @foreach($serviceCards as $index => $card)
                    <a href="{{ route('services.show', $card['slug']) }}" class="gps-service-row wow fadeInUp" data-wow-delay="{{ number_format($index * 0.1, 1) }}s">
                        <div class="gps-service-num">{{ sprintf('%02d', $index + 1) }}</div>
                        <div class="gps-service-copy">
                            <h3>{{ $card['name'] }}</h3>
                            <p>{{ $card['description'] }}</p>
                        </div>
                        <div class="gps-service-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></div>
                    </a>
                @endforeach
            </div>

            <div class="gps-service-extra">
                <div class="gps-panel">
                    <span class="gps-panel-badge">Across Every Category</span>
                    <p><strong>Logistics and fleet support</strong> runs underneath everything above. If it needs to be moved on a project, we can procure the vehicle to move it. That includes work vehicles like Hiluxes, heavy-duty equipment, and general delivery, customs clearing, and expediting where needed, mostly for Oil &amp; Gas operations but available generally on request.</p>
                </div>
                <div class="gps-panel">
                    <span class="gps-panel-badge">Something Else?</span>
                    <p>If your request does not fit neatly into the categories above, ask anyway. If it is something we can reasonably and safely source, we will find a way to get it to you.</p>
                </div>
            </div>

            <!-- Section Footer Text Start -->
            <p class="gps-section-footer-note wow fadeInUp" data-wow-delay="0.4s">These are real, deliverable services today, and we're building deeper capability in Oil &amp; Gas and Maritime as we grow. On the roadmap: Healthcare and Hospitality procurement. <a href="{{ url('/') }}#contact">Get Free Quote</a></p>
            <!-- Section Footer Text End -->
        </div>
    </div>
    <!-- Our Services Section End -->

    <!-- How It Works Section Start -->
    <div class="gps-section" id="how">
        <div class="container">
            <div class="gps-kicker wow fadeInUp">How It Works</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">Three steps, no surprises.</h2>

            <div class="gps-process-grid">
                <div class="gps-process-step wow fadeInUp">
                    <div class="gps-process-num">01</div>
                    <h4>Just Tell Us What You Need</h4>
                    <p>Send us what you need via WhatsApp, email, or the form below. No sales pitch, no pressure.</p>
                </div>
                <div class="gps-process-step wow fadeInUp" data-wow-delay="0.1s">
                    <div class="gps-process-num">02</div>
                    <h4>We Handle the Back-and-Forth</h4>
                    <p>A clear quotation, with pricing and delivery cost laid out, and the order confirmed once you approve.</p>
                </div>
                <div class="gps-process-step wow fadeInUp" data-wow-delay="0.2s">
                    <div class="gps-process-num">03</div>
                    <h4>We Coordinate Delivery</h4>
                    <p>We coordinate delivery through our logistics network, trusted delivery partners, or other suitable arrangements based on your location and requirements. Delivery timelines depend on the product, availability, location, and nature of the order.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- How It Works Section End -->

    <!-- Our Approach Section Start -->
    <div class="gps-section gps-section--tight bg-section">
        <div class="container">
            <div class="gps-kicker wow fadeInUp">Our Approach</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">How we make procurement feel straightforward.</h2>
            <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">No mystery, no padded promises, no endless chasing. We keep the process simple, visible, and practical from first request to final delivery.</p>

            <div class="gps-process-grid">
                <div class="gps-process-step wow fadeInUp">
                    <div class="gps-process-num">01</div>
                    <h4>Understand the Need</h4>
                    <p>We start with what you actually need: specifications, quantity, delivery location, timing, and any quality concerns that matter to the job.</p>
                </div>
                <div class="gps-process-step wow fadeInUp" data-wow-delay="0.1s">
                    <div class="gps-process-num">02</div>
                    <h4>Source Carefully</h4>
                    <p>We compare credible options, screen suppliers properly, and avoid the shortcuts that usually lead to fake goods, poor fit, or wasted spend.</p>
                </div>
                <div class="gps-process-step wow fadeInUp" data-wow-delay="0.2s">
                    <div class="gps-process-num">03</div>
                    <h4>Confirm Clearly</h4>
                    <p>You get a clear quotation with pricing, delivery expectations, and the practical details you need before you commit to anything.</p>
                </div>
                <div class="gps-process-step wow fadeInUp" data-wow-delay="0.3s">
                    <div class="gps-process-num">04</div>
                    <h4>Follow Through</h4>
                    <p>We stay on the order until it lands properly, confirm arrival, and remain available if something needs to be resolved after delivery.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Approach Section End -->

    <!-- What To Expect Section Start -->
    <div class="gps-section gps-section--tight">
        <div class="container">
            <div class="gps-kicker wow fadeInUp">What to Expect</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">We're building our track record, starting now.</h2>

            <div class="gps-panel wow fadeInUp" data-wow-delay="0.2s" style="margin-top: 40px;">
                <span class="gps-panel-badge">No Reviews Yet</span>
                <p>We don't have a wall of testimonials yet. What we do have is a straightforward way of working: a detailed quotation before you commit, delivery confirmation on arrival, a follow-up call within 3 days, and any issue addressed within 24 hours. Ask us for references as we complete our first engagements. We're happy to connect you directly with early clients.</p>
            </div>
        </div>
    </div>
    <!-- What To Expect Section End -->

    <!-- Why Us Section Start -->
    <div class="gps-section">
        <div class="container">
            <div class="gps-why-grid">
                <div>
                    <span class="gps-panel-badge" style="background:transparent; border:1px solid var(--accent-color); color: var(--accent-color); padding: 8px 16px;">Why Us</span>
                    <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque" style="margin-top: 22px;">Built for clients who want it done properly, not noisily.</h2>
                    <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">We are not trying to sound bigger than we are. The value is simpler than that: direct communication, careful sourcing, and a team that treats each order like its reputation depends on it, because it does.</p>
                </div>

                <div>
                    <div class="gps-why-figure wow fadeInUp" data-wow-delay="0.1s">
                        <img src="{{ asset('site/assets/images/board.jpg') }}" alt="Good Procurement team coordinating sourcing and delivery" loading="lazy" decoding="async">
                    </div>
                    <div class="gps-why-list">
                        <div class="gps-why-item wow fadeInUp">
                            <h4>Direct Communication</h4>
                            <p>You speak with the people handling the work. That reduces confusion, speeds up decisions, and keeps accountability clear.</p>
                        </div>
                        <div class="gps-why-item wow fadeInUp" data-wow-delay="0.1s">
                            <h4>Care Before Convenience</h4>
                            <p>We would rather source the right item honestly than push the nearest substitute just to close the request quickly.</p>
                        </div>
                        <div class="gps-why-item wow fadeInUp" data-wow-delay="0.2s">
                            <h4>Clear Quotations</h4>
                            <p>Pricing, delivery cost, and timing are laid out clearly so you can make a decision without guesswork or backdoor surprises.</p>
                        </div>
                        <div class="gps-why-item wow fadeInUp" data-wow-delay="0.3s">
                            <h4>Growing With Discipline</h4>
                            <p>We are building steadily, which means the process still gets attention. You are not being passed through layers just to place an order.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Why Us Section End -->

    <!-- Where We Work Section Start -->
    <div class="gps-section gps-section--tight bg-section">
        @include('blocks.map_location_cards', ['content' => [
            'section_title' => 'Based here, serving here. No map of offices we do not have.',
            'map_embed_url' => 'https://www.google.com/maps?q=Warri,+Delta+State,+Nigeria&output=embed',
            'locations' => [
                [
                    'title' => 'Warri, Delta State',
                    'address' => 'Warri, Delta State, Nigeria. Serving clients across Warri, Port Harcourt, and Lagos, Nigeria.',
                    'phone' => '+234 816 836 3332',
                ],
            ],
        ]])
    </div>
    <!-- Where We Work Section End -->

    <!-- FAQ Section Start -->
    <div class="gps-section gps-section--tight bg-section">
        <div class="container">
            <div class="gps-faq-grid">
                <div>
                    <div class="gps-kicker wow fadeInUp">FAQ</div>
                    <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque">Straight answers to the practical questions.</h2>
                    <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s">The basics of how we work, what to expect, and how to know if we are the right fit for your request.</p>
                </div>

                <div class="gps-faq-list" id="accordion">
                    <div class="gps-faq-item wow fadeInUp">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                How do I request a quote?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>Send us what you need through the form, WhatsApp, or email. We will review the request and come back with a clear quotation before anything is confirmed.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-faq-item wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                What if my request is not listed under your services?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>Ask anyway. If it is something we can source reasonably, safely, and properly, we will tell you. If it is outside our range, we will say that clearly too.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-faq-item wow fadeInUp" data-wow-delay="0.2s">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                How long does delivery usually take?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>Delivery timelines depend on the product, availability, quantity, location, and nature of the order. We will state the expected timeline clearly when we send your quotation.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-faq-item wow fadeInUp" data-wow-delay="0.3s">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Do you handle one-off requests only?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>No. We can support one-off procurement requests as well as repeat or recurring supply needs where a client needs consistency over time.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-faq-item wow fadeInUp" data-wow-delay="0.4s">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                How do you handle payment?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>Payment can be made by bank transfer, Moniepoint, Paystack, or cash, depending on the request and what is most practical for the transaction.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gps-faq-item wow fadeInUp" data-wow-delay="0.5s">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                What happens if there is an issue after delivery?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <p>We do not disappear after delivery. If there is a problem, we address it directly and work to resolve it quickly instead of leaving you to chase suppliers on your own.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->

    <!-- Contact / Request a Quote Section Start -->
    <div class="gps-section" id="contact">
        <div class="container">
            <div class="gps-kicker wow fadeInUp" style="justify-content:center; display:flex;">Ready to Talk?</div>
            <h2 class="gps-headline text-anime-style-3" data-cursor="-opaque" style="text-align:center;">Get a straightforward quote.</h2>
            <p class="gps-lede wow fadeInUp" data-wow-delay="0.2s" style="margin: 0 auto; text-align:center;">Tell us what you need sourced or managed, and we'll get back to you with a clear answer. Not a sales pitch.</p>

            <div class="gps-contact-panel wow fadeInUp" style="margin-top: 64px;">
                <h2 data-cursor="-opaque">Fill in your details</h2>

                <form action="{{ route('quotations.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="gps-form-label">Full Name *</label>
                            <input type="text" name="customer_name" class="gps-form-control" placeholder="Your name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="gps-form-label">Phone Number *</label>
                            <input type="tel" name="customer_phone" class="gps-form-control" placeholder="Your phone number" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="gps-form-label">Email</label>
                            <input type="email" name="customer_email" class="gps-form-control" placeholder="you@company.com" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="gps-form-label">Company Name</label>
                            <input type="text" name="customer_company" class="gps-form-control" placeholder="Your company" value="{{ old('customer_company') }}">
                            @error('customer_company')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 mb-4">
                            <label class="gps-form-label">Services Needed</label>
                            <select name="subject" class="gps-form-control">
                                <option value="Quote Request — Office, Admin & Corporate Procurement">Office, Admin &amp; Corporate Procurement</option>
                                <option value="Quote Request — Technology & Digital (IT) Procurement">Technology &amp; Digital (IT) Procurement</option>
                                <option value="Quote Request — Construction & Infrastructure Procurement">Construction &amp; Infrastructure Procurement</option>
                                <option value="Quote Request — Oil & Gas Procurement & Consumables">Oil &amp; Gas Procurement &amp; Consumables</option>
                                <option value="Quote Request — Maritime Supply">Maritime Supply</option>
                                <option value="Quote Request — Site & Camp Welfare Supplies">Site &amp; Camp Welfare Supplies</option>
                                <option value="Quote Request — Logistics & Fleet Support (incl. Vehicle Rental)">Logistics &amp; Fleet Support (incl. Vehicle Rental)</option>
                                <option value="Quote Request — Other / Not Listed">Other / Not Listed</option>
                            </select>
                            @error('subject')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 mb-5">
                            <label class="gps-form-label">Anything Else We Should Know?</label>
                            <textarea name="message" class="gps-form-control" rows="4" placeholder="Tell us more...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn-default"><span>Request a Free Quote</span></button>
                        </div>
                    </div>
                </form>
            </div>

                {{-- <div class="col-lg-5">
                    <div class="contact-us-content dark-section wow fadeInUp" data-wow-delay="0.2s">
                        <div class="contact-us-body">
                            <h3>Reach us directly</h3>
                            <div class="contact-info-list contact-info-list-vertical">
                                <div class="contact-info-item">
                                    <div class="icon-box"><img src="{{ asset('site/assets/images/icon-phone-white.svg') }}" alt=""></div>
                                    <div class="contact-info-item-content">
                                        <h3>Phone &amp; WhatsApp</h3>
                                        <p><a href="tel:+2348168363332">+234 816 836 3332</a></p>
                                        <p><a href="https://wa.me/2348168363332" target="_blank" rel="noopener">Chat on WhatsApp</a></p>
                                    </div>
                                </div>
                                <div class="contact-info-item">
                                    <div class="icon-box"><img src="{{ asset('site/assets/images/icon-mail-white.svg') }}" alt=""></div>
                                    <div class="contact-info-item-content">
                                        <h3>Email</h3>
                                        <p><a href="mailto:goodprocurementservice@gmail.com">goodprocurementservice@gmail.com</a></p>
                                    </div>
                                </div>
                                <div class="contact-info-item">
                                    <div class="icon-box"><img src="{{ asset('site/assets/images/icon-location-white.svg') }}" alt=""></div>
                                    <div class="contact-info-item-content">
                                        <h3>Instagram</h3>
                                        <p><a href="https://www.instagram.com/goodprocurement.ng" target="_blank" rel="noopener">@goodprocurement.ng</a></p>
                                    </div>
                                </div>
                            </div>
                            <p style="margin-top: 30px; font-family: var(--mono-font); font-size: 12px; letter-spacing: 0.05em; color: rgba(255,255,255,0.7);">REGISTERED COMPANY &middot; PROFESSIONAL SERVICE</p>
                            <p style="margin-top: 8px; font-family: var(--mono-font); font-size: 12px; color: rgba(255,255,255,0.55);">Payment via bank transfer, Moniepoint, Paystack, or cash.</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Contact / Request a Quote Section End -->
@endsection

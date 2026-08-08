@extends('site.master_layout')

@section('title', 'Terms of Service')
@section('description', 'The terms that apply when you request a quote, place an order, or use the Good Procurement Service Ltd website.')

@section('main')
    <!-- Page Header Section Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Terms of Service</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">terms of service</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    <div class="our-approach" style="padding: 90px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="service-entry">
                        <p style="color: var(--text-color); font-size: 14px;"><em>Last updated: {{ now()->format('F j, Y') }}</em></p>

                        <p>These terms apply when you use this website, request a quote, place an order, submit a supplier application, or otherwise engage our procurement services. By doing so, you agree to these terms.</p>

                        <h2>Quotes &amp; Pricing</h2>
                        <p>Submitting a quote request does not create an order. Pricing is confirmed only when we issue a written quotation, and that quotation remains valid only for the period stated on it. Any prices shown on the website are indicative unless we confirm them in writing.</p>

                        <h2>Orders &amp; Payment</h2>
                        <p>An order is confirmed only after you accept a quotation and we receive payment or otherwise agree commercial terms in writing. We may accept payment by bank transfer, Moniepoint, Paystack, cash, or any other method we approve. Delivery timelines are estimates unless expressly agreed otherwise, and we will notify you if a material change occurs.</p>

                        <h2>Delivery</h2>
                        <p>We may deliver using our own transport, a trusted logistics partner, or another delivery method suitable for the job. You should inspect items promptly on arrival and notify us within 24 hours if anything is missing, incorrect, or visibly damaged.</p>

                        <h2>Cancellations &amp; Returns</h2>
                        <p>Because many items are sourced to order, cancellations may not be possible once a supplier has been engaged or procurement has materially progressed. Where an item is faulty or materially different from the confirmed specification, contact us promptly so we can assess an appropriate remedy, which may include repair, replacement, refund, or another reasonable resolution.</p>

                        <h2>Supplier Applications</h2>
                        <p>Submitting a supplier application does not guarantee approval, onboarding, listing, or future business. Information, specifications, and pricing submitted by suppliers are reviewed internally and may be accepted, rejected, held, or used only as reference during internal evaluation.</p>

                        <h2>Website Use</h2>
                        <p>You must not misuse this website. This includes attempting to disrupt operations, interfere with forms or tracking tools, gain unauthorized access to restricted areas, submit false or misleading information, or use the site for any unlawful or harmful purpose.</p>

                        <h2>Restricted Internal Systems</h2>
                        <p>Certain digital systems, dashboards, workflows, and management tools are reserved for authorized personnel handling operations, approvals, supplier review, and related internal functions. No public right of access is granted to those restricted areas unless we expressly issue it.</p>

                        <h2>Liability</h2>
                        <p>We take reasonable care in sourcing, coordination, and delivery. However, to the extent permitted by law, we are not liable for indirect, incidental, special, or consequential losses, or for delays and failures caused by matters outside our reasonable control.</p>

                        <h2>Changes to These Terms</h2>
                        <p>We may update these terms from time to time. The version in effect at the relevant time of use, quote, order, or supplier submission is the version that applies, unless we expressly agree otherwise in writing.</p>

                        <h2>Contact Us</h2>
                        <p>Questions about these terms can be sent to <a href="mailto:goodprocurementservice@gmail.com">goodprocurementservice@gmail.com</a> or <a href="tel:+2348168363332">+234 816 836 3332</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('site.master_layout')

@section('title', 'Privacy Policy')
@section('description', 'How Good Procurement Service Ltd collects, uses, and protects the information you share with us.')

@section('main')
    <!-- Page Header Section Start -->
    <div class="page-header bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Privacy Policy</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">privacy policy</li>
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

                        <p>Good Procurement Service Ltd ("we", "us", "our") respects your privacy. This policy explains what information we collect, why we collect it, how we use it, and the choices available to you.</p>

                        <h2>What We Collect</h2>
                        <p>We collect only the information needed to run our website, respond to requests, and manage business operations.</p>
                        <ul>
                            <li><strong>Quote and contact requests</strong> — such as your name, phone number, email address, company name, and details of the items or services you want us to source.</li>
                            <li><strong>Order tracking information</strong> — such as the reference number you enter to check order status.</li>
                            <li><strong>Supplier application information</strong> — such as organization details, contact details, product information, specifications, and supporting material submitted through our supplier application process.</li>
                            <li><strong>Restricted internal account information</strong> — limited account details for authorized personnel who manage quotations, orders, supplier review, content, and operational workflows.</li>
                        </ul>
                        <p>We do not use advertising trackers on this website.</p>

                        <h2>Cookies</h2>
                        <p>We use a limited number of cookies and similar storage tools that are necessary for the website to function properly. These help us remember your cookie preference, protect forms from misuse, and support restricted internal sessions used by authorized personnel. We do not use cookies for advertising.</p>

                        <h2>How We Use Your Information</h2>
                        <ul>
                            <li>To respond to quote requests and prepare quotations.</li>
                            <li>To process orders and provide order updates.</li>
                            <li>To review supplier applications and related submissions.</li>
                            <li>To operate and secure restricted internal systems used by authorized personnel.</li>
                            <li>To maintain records required for customer support, operations, legal compliance, and business administration.</li>
                        </ul>
                        <p>We do not sell your information to third parties.</p>

                        <h2>When We May Share Information</h2>
                        <p>We may share information only where necessary to operate our services, meet legal obligations, or protect our legitimate business interests. This may include payment providers, delivery or logistics partners, technology service providers, professional advisers, or regulatory authorities where required.</p>

                        <h2>How We Protect Your Information</h2>
                        <p>We use reasonable technical and organizational measures to protect the information we hold. Passwords are encrypted where applicable, and access to customer, supplier, and operational data is limited to authorized personnel who need it for legitimate work purposes.</p>

                        <h2>How Long We Keep Information</h2>
                        <p>We keep information only for as long as it is reasonably needed for procurement operations, supplier review, legal compliance, dispute handling, record keeping, or internal administration.</p>

                        <h2>Your Rights</h2>
                        <p>Subject to applicable law, including the Nigeria Data Protection Act (2023), you may ask us to provide access to the information we hold about you, correct inaccurate information, or delete information where there is no lawful basis for us to retain it. To make a request, contact us using the details below.</p>

                        <h2>Contact Us</h2>
                        <p>Questions about this policy or your personal information can be sent to <a href="mailto:goodprocurementservice@gmail.com">goodprocurementservice@gmail.com</a> or <a href="tel:+2348168363332">+234 816 836 3332</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

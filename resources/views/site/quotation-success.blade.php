@extends('site.master_layout')

@section('title', 'Quotation Submitted')
@section('robots', 'noindex, nofollow')

@section('main')
@php
  $whatsappNumber = config('app.whatsapp_number') ?? '+234 800 000 0000';
  $whatsappDigits = preg_replace('/\D+/', '', $whatsappNumber);
  $whatsappLink = $whatsappDigits ? 'https://wa.me/' . $whatsappDigits : '#';
@endphp
<div class="page-header bg-section" style="padding: 120px 0 60px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="section-title">
          <h3 class="wow fadeInUp">thank you</h3>
          <h1 class="text-anime-style-3" data-cursor="-opaque">Quotation Submitted</h1>
          <p class="wow fadeInUp" data-wow-delay="0.2s">We’ve received your request and our team is reviewing it now. You’ll receive an email update as soon as it’s approved.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="contact-us-section" style="padding: 60px 0 90px;">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-3">
              <i class="fa-solid fa-circle-check" style="font-size: 40px; color: var(--accent-color);"></i>
              <div>
                <h4 class="mb-1">We’re reviewing your quotation</h4>
                <p class="text-muted mb-0">Here’s what happens next.</p>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="p-3 rounded-3 border">
                  <div class="fw-semibold mb-1">1. Review & Approval</div>
                  <div class="text-muted small">Our team checks availability, pricing, and delivery details.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 rounded-3 border">
                  <div class="fw-semibold mb-1">2. Invoice Sent</div>
                  <div class="text-muted small">If approved, an invoice is emailed to you for payment.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 rounded-3 border">
                  <div class="fw-semibold mb-1">3. Payment Confirmation</div>
                  <div class="text-muted small">Once paid, your order is confirmed and processed.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 rounded-3 border">
                  <div class="fw-semibold mb-1">4. Delivery & Tracking</div>
                  <div class="text-muted small">Receive an order number and track delivery anytime.</div>
                </div>
              </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-4">
              <a href="{{ route('orders.track') }}" class="btn-default"><span>Track an Order</span></a>
              <a href="{{ route('products.index') }}" class="btn-default btn-highlighted"><span>Browse Products</span></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="fa-brands fa-whatsapp" style="font-size: 28px; color: #25D366;"></i>
              <h5 class="mb-0">Need to add more details?</h5>
            </div>
            <p class="text-muted mb-3">Your quote is under review. You can send additional info or questions on WhatsApp and we’ll get back to you.</p>
            <div class="p-3 rounded-3 border mb-3">
              <div class="text-muted small">WhatsApp</div>
              <div class="fw-semibold">{{ $whatsappNumber }}</div>
            </div>
            <a href="{{ $whatsappLink }}" class="btn-default btn-highlighted w-100 text-center">
              <span>Chat on WhatsApp</span>
            </a>
            <div class="text-muted small mt-3">We typically respond within 1 business day.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

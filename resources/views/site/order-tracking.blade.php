@extends('site.master_layout')

@section('title', 'Order Tracking')
@section('description', 'Track your Good Procurement Service Ltd order status and delivery in real time.')
@section('robots', 'noindex, follow')

@push('styles')
<style>
  /* ===== ORDER TRACKING PAGE ===== */
  .ot-hero {
    background: linear-gradient(135deg, #34526f 0%, #426693 55%, #5a82ad 100%);
    padding: 138px 0 96px;
    position: relative;
    overflow: hidden;
  }
  .ot-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(120,181,71,.1);
    pointer-events: none;
  }
  .ot-hero::after {
    content: '';
    position: absolute;
    bottom: -120px; left: -60px;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    pointer-events: none;
  }
  .ot-hero-inner { position: relative; z-index: 1; }
  .ot-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(120,181,71,.2);
    border: 1px solid rgba(120,181,71,.35);
    color: #a3d678;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 24px;
  }
  .ot-hero h1 {
    font-size: clamp(36px, 5vw, 58px);
    font-weight: 900;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
  }
  .ot-hero p {
    font-size: 19px;
    color: rgba(255,255,255,.7);
    max-width: 620px;
    line-height: 1.8;
    margin-bottom: 0;
    font-weight: 500;
  }

  /* Search form */
  .ot-search-section {
    margin-top: -62px;
    padding-bottom: 76px;
    position: relative;
    z-index: 5;
  }
  .ot-search-card {
    background: #fff;
    border-radius: 20px;
    padding: 46px 48px;
    box-shadow: 0 8px 40px -10px rgba(66,102,147,.22), 0 2px 8px rgba(0,0,0,.06);
  }
  .ot-search-title {
    font-size: 24px;
    font-weight: 800;
    color: #1e2d3d;
    margin-bottom: 10px;
  }
  .ot-search-subtitle {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 32px;
    line-height: 1.8;
    font-weight: 500;
  }
  .ot-search-card .form-label {
    font-size: 15px;
    color: #426693;
    font-weight: 700;
    margin-bottom: 10px;
  }
  .ot-search-card .form-control {
    border-radius: 12px;
    border: 1.5px solid #dde4ed;
    padding: 16px 20px;
    font-size: 16px;
    font-weight: 600;
    transition: border-color .2s, box-shadow .2s;
  }
  .ot-search-card .form-control:focus {
    border-color: #426693;
    box-shadow: 0 0 0 3px rgba(66,102,147,.12);
  }
  .ot-search-card .btn-track {
    background: linear-gradient(135deg, #426693, #34526f);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 16px 36px;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: .3px;
    transition: transform .2s, box-shadow .2s;
  }
  .ot-search-card .btn-track:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(66,102,147,.35);
    color: #fff;
  }

  /* Results section */
  .ot-results {
    padding-bottom: 100px;
  }

  /* Order header card */
  .ot-order-header {
    background: linear-gradient(135deg, #34526f 0%, #426693 100%);
    border-radius: 20px;
    padding: 36px 40px;
    color: #fff;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
  }
  .ot-order-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(120,181,71,.1);
  }
  .ot-order-header::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 40%;
    width: 200px; height: 150px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
  }
  .ot-order-header-inner { position: relative; z-index: 1; }
  .ot-order-number {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    opacity: .6;
    margin-bottom: 14px;
    font-weight: 700;
  }
  .ot-order-id {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 14px;
    line-height: 1.2;
  }
  .ot-order-customer {
    font-size: 16px;
    opacity: .78;
    font-weight: 500;
    line-height: 1.8;
    padding-top: 4px;
  }
  .ot-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    border: 2px solid rgba(255,255,255,.3);
    background: rgba(255,255,255,.15);
    color: #fff;
    margin-bottom: 8px;
  }
  .ot-status-pill.delivered { background: #78B547; border-color: #78B547; }
  .ot-status-pill.dispatched { background: #c97308; border-color: #c97308; }
  .ot-order-total { font-size: 15px; opacity: .72; font-weight: 600; }

  /* Progress Tracker */
  .ot-progress-card {
    background: #fff;
    border-radius: 20px;
    padding: 34px 38px;
    box-shadow: 0 2px 16px rgba(66,102,147,.08);
    margin-bottom: 30px;
    border: 1px solid #dde4ed;
  }
  .ot-progress-title {
    font-size: 22px;
    font-weight: 800;
    color: #1e2d3d;
    margin-bottom: 34px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .ot-progress-title::before {
    content: '';
    width: 5px; height: 22px;
    background: #78B547;
    border-radius: 2px;
    display: inline-block;
  }
  .ot-steps {
    display: flex;
    align-items: flex-start;
    gap: 0;
    position: relative;
  }
  .ot-step {
    flex: 1;
    text-align: center;
    position: relative;
  }
  .ot-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 22px;
    left: 50%;
    right: -50%;
    height: 3px;
    background: #e0e7ef;
    z-index: 0;
    transition: background .4s;
  }
  .ot-step.done:not(:last-child)::after { background: #78B547; }
  .ot-step-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: #f0f4f8;
    border: 3px solid #dde4ed;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    font-size: 20px;
    position: relative;
    z-index: 1;
    color: #94a3b8;
    transition: all .3s;
  }
  .ot-step.done .ot-step-icon {
    background: #78B547;
    border-color: #78B547;
    color: #fff;
    box-shadow: 0 4px 16px rgba(120,181,71,.35);
  }
  .ot-step.active .ot-step-icon {
    background: #426693;
    border-color: #426693;
    color: #fff;
    box-shadow: 0 4px 16px rgba(66,102,147,.35);
    animation: pulse-step 2s infinite;
  }
  @keyframes pulse-step {
    0%, 100% { box-shadow: 0 4px 16px rgba(66,102,147,.35); }
    50% { box-shadow: 0 4px 24px rgba(66,102,147,.6); }
  }
  .ot-step-label {
    font-size: 14px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .ot-step.done .ot-step-label  { color: #5f9a33; }
  .ot-step.active .ot-step-label { color: #426693; }

  /* Info cards grid */
  .ot-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
    margin-bottom: 30px;
  }
  .ot-info-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px 30px;
    border: 1px solid #dde4ed;
    box-shadow: 0 2px 12px rgba(66,102,147,.06);
  }
  .ot-info-card .ic-label {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ot-info-card .ic-label::before {
    content: '';
    display: inline-block;
    width: 4px; height: 14px;
    border-radius: 2px;
    background: #426693;
  }
  .ot-info-card .ic-value {
    font-size: 19px;
    font-weight: 800;
    color: #1e2d3d;
    margin-bottom: 8px;
  }
  .ot-info-card .ic-sub { font-size: 15px; color: #64748b; line-height: 1.8; font-weight: 500; }
  .ot-info-card .ic-tracking-ref {
    display: inline-block;
    background: #f4f7fb;
    border: 1px solid #dde4ed;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 700;
    font-family: monospace;
    color: #426693;
    margin-top: 10px;
  }

  /* Timeline */
  .ot-timeline-card {
    background: #fff;
    border-radius: 20px;
    padding: 34px 38px;
    box-shadow: 0 2px 16px rgba(66,102,147,.08);
    margin-bottom: 30px;
    border: 1px solid #dde4ed;
  }
  .ot-timeline-title {
    font-size: 22px;
    font-weight: 800;
    color: #1e2d3d;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .ot-timeline-title::before {
    content: '';
    width: 5px; height: 22px;
    background: #426693;
    border-radius: 2px;
    display: inline-block;
  }
  .ot-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
  }
  .ot-timeline::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, #78B547, #dde4ed);
    border-radius: 1px;
  }
  .ot-tl-item {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding-bottom: 28px;
    position: relative;
  }
  .ot-tl-item:last-child { padding-bottom: 0; }
  .ot-tl-dot {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #78B547;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    color: #78B547;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(120,181,71,.2);
  }
  .ot-tl-item:first-child .ot-tl-dot {
    background: #78B547;
    color: #fff;
    box-shadow: 0 4px 16px rgba(120,181,71,.4);
  }
  .ot-tl-content {
    background: #f4f7fb;
    border: 1px solid #dde4ed;
    border-radius: 16px;
    padding: 18px 22px;
    flex: 1;
    margin-top: 1px;
  }
  .ot-tl-item:first-child .ot-tl-content {
    background: linear-gradient(135deg, rgba(66,102,147,.06), rgba(120,181,71,.06));
    border-color: rgba(120,181,71,.2);
  }
  .ot-tl-status {
    font-weight: 800;
    font-size: 17px;
    color: #1e2d3d;
    text-transform: capitalize;
    margin-bottom: 6px;
  }
  .ot-tl-time { font-size: 14px; color: #64748b; font-weight: 600; }
  .ot-tl-note { font-size: 15px; color: #475569; margin-top: 8px; line-height: 1.8; font-weight: 500; }

  /* Items table */
  .ot-items-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(66,102,147,.08);
    border: 1px solid #dde4ed;
    margin-bottom: 30px;
  }
  .ot-items-header {
    padding: 24px 28px;
    border-bottom: 1px solid #dde4ed;
    font-size: 22px;
    font-weight: 800;
    color: #1e2d3d;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .ot-items-header::before {
    content: '';
    width: 5px; height: 22px;
    background: #78B547;
    border-radius: 2px;
    display: inline-block;
  }
  .ot-items-table { width: 100%; border-collapse: collapse; font-size: 16px; }
  .ot-items-table thead tr { background: linear-gradient(90deg, #34526f, #426693); }
  .ot-items-table th {
    padding: 16px 20px;
    color: rgba(255,255,255,.85);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-weight: 800;
  }
  .ot-items-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #dde4ed;
    color: #1e2d3d;
    font-weight: 600;
  }
  .ot-items-table tbody tr:last-child td { border-bottom: none; }
  .ot-items-table tbody tr:hover { background: #f4f7fb; }
  .ot-items-table .item-name { font-weight: 800; font-size: 17px; }
  .ot-items-table .item-spec { font-size: 14px; color: #64748b; margin-top: 6px; font-weight: 500; line-height: 1.7; }
  .ot-items-table tfoot tr { background: #f4f7fb; }
  .ot-items-table tfoot td { font-weight: 800; }

  /* Empty state */
  .ot-empty-state {
    text-align: center;
    padding: 60px 28px;
  }
  .ot-empty-icon {
    width: 80px; height: 80px;
    background: #f4f7fb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 32px;
    color: #94a3b8;
  }
  .ot-help-card {
    background: linear-gradient(135deg,rgba(66,102,147,.06),rgba(120,181,71,.06));
    border:1px solid rgba(66,102,147,.15);
    border-left:4px solid #426693;
    border-radius:18px;
    padding:26px 30px;
  }
  .ot-help-title {
    font-size:18px;
    color:#1e2d3d;
    font-weight:800;
    margin-bottom:8px;
  }
  .ot-help-body {
    font-size:16px;
    color:#64748b;
    line-height:1.9;
    font-weight:500;
  }
  .ot-help-body a {
    color:#426693;
    font-weight:700;
  }

  @media (max-width: 768px) {
    .ot-hero {
      padding: 120px 0 88px;
    }
    .ot-search-card { padding: 30px 22px; }
    .ot-order-header { padding: 26px 22px; }
    .ot-progress-card, .ot-timeline-card { padding: 26px 22px; }
    .ot-items-header { padding: 20px 22px; }
    .ot-info-grid { grid-template-columns: 1fr; }
    .ot-steps { flex-wrap: wrap; gap: 24px; }
    .ot-step:not(:last-child)::after { display: none; }
    .ot-step { flex: 0 0 calc(50% - 12px); }
  }
</style>
@endpush

@section('main')

{{-- Hero --}}
<div class="ot-hero">
  <div class="container">
    <div class="ot-hero-inner">
      <div class="ot-hero-eyebrow">
        <i class="fa-solid fa-truck-fast"></i> Order Tracking
      </div>
      <h1>Track Your Order</h1>
      <p>Enter your order number and email address to get real-time updates on your delivery status.</p>
    </div>
  </div>
</div>

{{-- Search Card (overlaps hero) --}}
<div class="ot-search-section">
  <div class="container">
    <div class="ot-search-card">
      <div class="ot-search-title">Find Your Order</div>
      <div class="ot-search-subtitle">Enter the order number from your confirmation email along with the email address used when placing the order.</div>

      @if($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius:12px; border-left:4px solid #dc3545;">
          @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
      @endif

      <form action="{{ route('orders.track.submit') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Order Number</label>
            <input type="text" name="order_number" class="form-control"
                   placeholder="e.g. ORD-2024-001"
                   value="{{ old('order_number', $order->order_number ?? '') }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                   placeholder="your@email.com"
                   value="{{ old('email', $order->customer_email ?? '') }}" required>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-track w-100">
              <i class="fa-solid fa-magnifying-glass me-2"></i> Track Order
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Results --}}
@if(isset($order))
<div class="ot-results">
  <div class="container">

    {{-- Order Header Card --}}
    <div class="ot-order-header wow fadeInUp">
      <div class="ot-order-header-inner">
        <div class="row align-items-center">
          <div class="col-md-7">
            <div class="ot-order-number">Order Reference</div>
            <div class="ot-order-id">{{ $order->order_number }}</div>
            <div class="ot-order-customer">
              <i class="fa-solid fa-user me-1" style="opacity:.6;"></i>
              {{ $order->customer_name }} &nbsp;·&nbsp; {{ $order->customer_email }}
            </div>
          </div>
          <div class="col-md-5 text-md-end mt-3 mt-md-0">
            @php
              $pillClass = in_array($order->status, ['delivered']) ? 'delivered' :
                           (in_array($order->status, ['dispatched']) ? 'dispatched' : '');
            @endphp
            <div class="ot-status-pill {{ $pillClass }} ms-md-auto d-inline-flex">
              <i class="fa-solid fa-circle-check"></i>
              {{ ucfirst($order->status) }}
            </div>
            <div class="ot-order-total">
              Total: <strong>{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Progress Steps --}}
    @php
      $steps = [
        ['key' => 'pending',    'label' => 'Placed',     'icon' => 'fa-solid fa-clipboard-check'],
        ['key' => 'processing', 'label' => 'Processing', 'icon' => 'fa-solid fa-gear'],
        ['key' => 'dispatched', 'label' => 'Dispatched', 'icon' => 'fa-solid fa-box'],
        ['key' => 'delivered',  'label' => 'Delivered',  'icon' => 'fa-solid fa-house'],
      ];
      $statusOrder = ['pending' => 0, 'processing' => 1, 'dispatched' => 2, 'delivered' => 3];
      $currentIdx  = $statusOrder[$order->status] ?? 0;
    @endphp
    <div class="ot-progress-card wow fadeInUp" data-wow-delay="0.1s">
      <div class="ot-progress-title">Order Progress</div>
      <div class="ot-steps">
        @foreach($steps as $i => $step)
          @php
            $isDone   = $i < $currentIdx;
            $isActive = $i === $currentIdx;
          @endphp
          <div class="ot-step {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
            <div class="ot-step-icon">
              @if($isDone)
                <i class="fa-solid fa-check"></i>
              @else
                <i class="{{ $step['icon'] }}"></i>
              @endif
            </div>
            <div class="ot-step-label">{{ $step['label'] }}</div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Info Grid --}}
    <div class="ot-info-grid wow fadeInUp" data-wow-delay="0.15s">
      <div class="ot-info-card">
        <div class="ic-label">Delivery Address</div>
        <div class="ic-value">{{ $order->delivery_contact ?? $order->customer_name }}</div>
        <div class="ic-sub">
          {{ $order->delivery_address ?? 'Address not provided yet.' }}
          @if($order->delivery_phone)
            <br>{{ $order->delivery_phone }}
          @endif
        </div>
      </div>
      <div class="ot-info-card">
        <div class="ic-label">Shipping & Tracking</div>
        <div class="ic-value">{{ $order->carrier ?? 'Not yet assigned' }}</div>
        @if($order->tracking_ref)
          <div class="ic-tracking-ref"><i class="fa-solid fa-barcode me-1"></i> {{ $order->tracking_ref }}</div>
        @else
          <div class="ic-sub">Tracking reference will appear once your order is dispatched.</div>
        @endif
      </div>
    </div>

    {{-- Timeline --}}
    <div class="ot-timeline-card wow fadeInUp" data-wow-delay="0.2s">
      <div class="ot-timeline-title">Status History</div>
      @php $timeline = $order->statusHistory->sortByDesc('created_at'); @endphp
      @if($timeline->count() > 0)
        <div class="ot-timeline">
          @foreach($timeline as $history)
          <div class="ot-tl-item">
            <div class="ot-tl-dot">
              <i class="fa-solid fa-check"></i>
            </div>
            <div class="ot-tl-content">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div class="ot-tl-status">{{ ucfirst($history->status) }}</div>
                <div class="ot-tl-time">
                  <i class="fa-regular fa-clock me-1"></i>
                  {{ $history->created_at->format('M d, Y · h:i A') }}
                </div>
              </div>
              @if($history->note)
                <div class="ot-tl-note">{{ $history->note }}</div>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="ot-empty-state">
          <div class="ot-empty-icon"><i class="fa-regular fa-clock"></i></div>
          <div style="font-size:17px; color:#64748b; font-weight:600;">No status updates yet. Check back soon.</div>
        </div>
      @endif
    </div>

    {{-- Order Items --}}
    <div class="ot-items-card wow fadeInUp" data-wow-delay="0.25s">
      <div class="ot-items-header">Order Items</div>
      <div class="table-responsive">
        <table class="ot-items-table">
          <thead>
            <tr>
              <th>Item</th>
              <th class="text-center" style="width:80px;">Qty</th>
              <th class="text-end" style="width:120px;">Unit Price</th>
              <th class="text-end" style="width:130px;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
            <tr>
              <td>
                <div class="item-name">{{ $item->product_name }}</div>
                @if($item->specifications)
                  <div class="item-spec">{{ $item->specifications }}</div>
                @endif
              </td>
              <td class="text-center">{{ $item->quantity }}</td>
              <td class="text-end">{{ $order->currency }} {{ number_format($item->unit_price, 2) }}</td>
              <td class="text-end fw-semibold">{{ $order->currency }} {{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end" style="padding:18px 20px;">Total Amount</td>
              <td class="text-end" style="padding:18px 20px; font-size:18px; color:#426693; font-weight:800;">
                {{ $order->currency }} {{ number_format($order->total_amount, 2) }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Help Note --}}
    <div class="ot-help-card wow fadeInUp" data-wow-delay="0.3s">
      <div class="ot-help-title">
        <i class="fa-solid fa-circle-info me-2" style="color:#426693;"></i> Need help with your order?
      </div>
      <div class="ot-help-body">
        Contact our support team at
        <a href="mailto:info@goodprocurement.com">info@goodprocurement.com</a>
        and reference your order number <strong>{{ $order->order_number }}</strong>.
      </div>
    </div>

  </div>
</div>
@endif

@endsection

@extends('admin.layouts.app')

@section('title', 'Quotation Details - ' . $quotation->quote_number)

@push('styles')
<style>
  /* ===== GOOD PROCUREMENTS DOCUMENTS ===== */
  :root {
    --gps-primary: #4c89bb;
    --gps-primary-dark: #3b719d;
    --gps-accent: #7aac56;
    --gps-accent-dark: #699446;
    --gps-dark: #33546c;
    --gps-ink: #314556;
    --gps-muted: #7b8d9d;
    --gps-border: #e3ebf2;
    --gps-bg: #fbfdff;
    --gps-soft: #f6f9fc;
  }

  .page-title-box {
    margin-bottom: 24px;
  }

  .col-lg-8 > .card,
  .col-lg-4 > .card {
    margin-bottom: 24px;
  }

  .card {
    border: 1px solid #e5edf3;
    box-shadow: none;
  }

  .card-header {
    padding: 18px 22px;
  }

  .card-body {
    padding: 22px;
  }

  .form-label {
    margin-bottom: 8px;
    font-weight: 700;
  }

  .form-control,
  .form-select,
  textarea.form-control {
    padding: 12px 14px;
  }

  .doc-sheet {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--gps-border);
    overflow: hidden;
    font-family: 'Instrument Sans', 'Segoe UI', Arial, sans-serif;
    color: var(--gps-ink);
    font-size: 14px;
    line-height: 1.6;
    box-shadow: none;
  }

  .doc-strip {
    height: 4px;
  }

  .doc-strip.invoice { background: #d9eaf7; }
  .doc-strip.receipt { background: #deefd0; }

  .inv-head {
    padding: 36px 40px 30px;
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    gap: 28px;
    border-bottom: 1px solid var(--gps-border);
    background: #ffffff;
  }

  .inv-head-brand {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    flex: 1 1 auto;
  }

  .inv-head-logo {
    width: 82px;
    height: 82px;
    object-fit: contain;
    flex-shrink: 0;
  }

  .inv-head-company {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding-top: 4px;
  }

  .inv-head-name {
    font-size: 29px;
    font-weight: 900;
    color: var(--gps-primary-dark);
    line-height: 1.05;
    letter-spacing: -0.03em;
  }

  .inv-head-tagline {
    font-size: 11px;
    color: var(--gps-muted);
    text-transform: uppercase;
    letter-spacing: 2.4px;
    font-weight: 700;
  }

  .inv-head-contact {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 18px;
    font-size: 13px;
    color: var(--gps-muted);
    margin-top: 8px;
    line-height: 1.8;
    font-weight: 600;
  }

  .inv-head-contact span {
    display: inline-block;
    padding-right: 4px;
  }

  .inv-head-right {
    min-width: 240px;
    flex-shrink: 0;
    text-align: right;
    padding: 20px 22px;
    border: 1px solid var(--gps-border);
    border-radius: 18px;
    background: var(--gps-soft);
  }

  .inv-type-label {
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 3.2px;
    text-transform: uppercase;
    color: var(--gps-primary);
    line-height: 1.2;
    margin-bottom: 10px;
  }

  .inv-number {
    font-size: 21px;
    font-weight: 800;
    color: var(--gps-ink);
    margin-bottom: 14px;
    line-height: 1.25;
  }

  .inv-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
  }
  .inv-status-pill.paid    { background: #dcfce7; color: #166534; }
  .inv-status-pill.unpaid  { background: #fef3c7; color: #92400e; }
  .inv-status-pill.pending { background: #f1f5f9; color: #475569; }

  .inv-meta-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 0;
    border-bottom: 1px solid var(--gps-border);
    background: #fff;
  }

  .inv-meta-cell {
    padding: 24px 26px;
    border-right: 1px solid var(--gps-border);
  }
  .inv-meta-cell:last-child { border-right: none; }

  .inv-meta-cell .mc-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.8px;
    color: var(--gps-muted);
    font-weight: 800;
    margin-bottom: 8px;
  }

  .inv-meta-cell .mc-value {
    font-size: 15px;
    font-weight: 800;
    color: var(--gps-ink);
    line-height: 1.45;
  }

  .inv-meta-cell .mc-sub {
    font-size: 13px;
    color: var(--gps-muted);
    line-height: 1.8;
    margin-top: 8px;
    font-weight: 500;
  }

  .inv-body { padding: 0; }

  .inv-table {
    width: 100%;
    border-collapse: collapse;
  }

  .inv-table thead tr {
    background: var(--gps-soft);
    border-bottom: 2px solid var(--gps-border);
  }

  .inv-table th {
    padding: 16px 24px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.8px;
    color: var(--gps-muted);
    font-weight: 800;
  }

  .inv-table td {
    padding: 20px 24px;
    border-bottom: 1px solid var(--gps-border);
    vertical-align: middle;
  }

  .inv-table tbody tr:last-child td { border-bottom: none; }
  .inv-table tbody tr:hover { background: #f9fbfd; }
  .inv-table .td-name  { font-weight: 700; color: var(--gps-ink); font-size: 15px; }
  .inv-table .td-spec  { font-size: 12px; color: var(--gps-muted); margin-top: 6px; line-height: 1.7; }
  .inv-table .td-total { font-weight: 800; color: var(--gps-primary); }

  .inv-totals {
    display: flex;
    justify-content: flex-end;
    padding: 24px 28px 26px;
    border-top: 1px solid var(--gps-border);
    background: #fafcff;
  }

  .inv-totals-box {
    min-width: 280px;
  }

  .inv-totals-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0 10px;
    font-size: 14px;
    color: var(--gps-muted);
    border-bottom: 1px dashed var(--gps-border);
    margin-bottom: 12px;
  }

  .inv-totals-grand {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 4px;
  }

  .inv-totals-grand .tg-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 800;
    color: var(--gps-muted);
  }

  .inv-totals-grand .tg-value {
    font-size: 28px;
    font-weight: 900;
    color: var(--gps-primary);
  }

  .inv-bank {
    padding: 24px 28px;
    border-top: 1px solid var(--gps-border);
    background: #fff;
  }

  .inv-bank-title {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 800;
    color: var(--gps-primary);
    margin-bottom: 14px;
  }

  .inv-bank-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
  }

  .inv-bank-item {
    padding: 16px 18px;
    border: 1px solid var(--gps-border);
    border-radius: 14px;
    background: #ffffff;
  }

  .inv-bank-item .bi-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--gps-muted);
    font-weight: 700;
    margin-bottom: 6px;
  }

  .inv-bank-item .bi-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--gps-ink);
  }

  .inv-footer {
    padding: 18px 28px 22px;
    border-top: 1px solid var(--gps-border);
    background: var(--gps-bg);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }

  .inv-footer .fn {
    font-size: 13px;
    color: var(--gps-muted);
    line-height: 1.8;
    font-weight: 500;
  }

  .inv-footer img  {
    height: 28px;
    opacity: .42;
    flex-shrink: 0;
  }

  .rec-head {
    padding: 36px 40px 30px;
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    gap: 28px;
    border-bottom: 1px solid var(--gps-border);
    background: #ffffff;
  }

  .rec-type-label {
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 3.2px;
    text-transform: uppercase;
    color: var(--gps-accent-dark);
    line-height: 1.2;
    margin-bottom: 10px;
  }

  .rec-paid-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #dcfce7;
    color: #166534;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
  }

  .doc-print-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    border-radius: 10px;
    padding: 9px 16px;
    cursor: pointer;
    border: 1px solid var(--gps-border);
    background: #fff;
    color: var(--gps-muted);
    transition: all .15s;
  }

  .doc-print-btn:hover { border-color: var(--gps-primary); color: var(--gps-primary); }

  .doc-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-bottom: 16px;
  }

  .status-detail-list {
    display: grid;
    gap: 16px;
  }

  .status-detail {
    padding: 18px 18px;
    border-radius: 14px;
    border: 1px solid var(--gps-border);
    background: #ffffff;
  }

  .status-detail-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.6px;
    color: var(--gps-muted);
    font-weight: 800;
    margin-bottom: 6px;
  }

  .status-detail-value {
    font-size: 14px;
    font-weight: 800;
    color: var(--gps-ink);
    line-height: 1.5;
  }

  .status-detail-sub {
    font-size: 12px;
    color: var(--gps-muted);
    margin-top: 4px;
    line-height: 1.6;
  }

  @media (max-width: 768px) {
    .inv-head { flex-direction: column; padding: 24px 22px; }
    .inv-head-right { text-align: left; }
    .inv-meta-row { grid-template-columns: 1fr 1fr; }
    .inv-meta-cell:nth-child(2n) { border-right: none; }
    .inv-meta-cell:nth-child(n+3) { border-top: 1px solid var(--gps-border); }
    .inv-meta-cell { padding: 20px; }
    .inv-head-logo { width: 72px; height: 72px; }
    .inv-head-name { font-size: 24px; }
    .inv-head-contact { flex-direction: column; gap: 4px; }
    .inv-head-right { min-width: 0; }
    .inv-table th,
    .inv-table td { padding: 14px 16px; }
    .inv-totals { padding: 18px 16px; }
    .inv-totals-box { min-width: 100%; }
    .inv-bank { padding: 18px 16px; }
    .inv-bank-grid { grid-template-columns: 1fr; }
    .inv-footer { flex-direction: column; align-items: flex-start; padding: 16px; }
    .rec-head { flex-direction: column; padding: 24px 22px; }
    .rec-head .inv-head-right { text-align: left; }
  }
</style>
@endpush

@section('content')
@php
  $invoiceStatus = $quotation->paid_at ? 'Paid' : ($quotation->status === 'accepted' ? 'Unpaid' : 'Pending');
  $invoicePill   = $invoiceStatus === 'Paid' ? 'paid' : ($invoiceStatus === 'Unpaid' ? 'unpaid' : 'pending');
  $invoiceBadge  = $quotation->paid_at ? 'success' : ($quotation->status === 'accepted' ? 'warning' : 'secondary');
  $invoiceNumber = 'INV-' . $quotation->quote_number;
  $invoiceDate   = $quotation->responded_at ?? $quotation->created_at;
  $dueDate       = $quotation->valid_until ?? $quotation->created_at->copy()->addDays(14);
  $paidDate      = $quotation->paid_at;
  $companyName   = 'Good Procurements';
  $companyTagline = 'Good Procurements';
  $companyEmail  = config('mail.from.address', 'info@goodprocurements.com');
  $companyPhone  = config('app.phone', '+234 800 000 0000');
  $bankName      = config('app.bank_name', 'Designated Settlement Bank');
  $bankAccount   = config('app.bank_account', '0000000000');
  $bankAccountName = config('app.bank_account_name', $companyName);
  $bankSwift     = config('app.bank_swift', 'Available On Request');
@endphp

<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Quotation: {{ $quotation->quote_number }}</h4>
        <p class="text-muted mb-1">View and manage quotation details</p>
      </div>
      <a href="{{ route('admin.quotations.index') }}" class="btn btn-outline-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back
      </a>
    </div>
  </div>
</div>

<div class="row">
  {{-- ===== LEFT COLUMN ===== --}}
  <div class="col-lg-8">

    {{-- Customer Info --}}
    <div class="card">
      <div class="card-header" style="border-left:4px solid #426693;">
        <h5 class="card-title mb-0"><i class="fi fi-rr-user me-2"></i> Customer Information</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="text-muted small fw-semibold mb-1" style="text-transform:uppercase;letter-spacing:1px;font-size:11px;">Name</div>
            <div class="fw-semibold">{{ $quotation->customer_name }}</div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small fw-semibold mb-1" style="text-transform:uppercase;letter-spacing:1px;font-size:11px;">Email</div>
            <a href="mailto:{{ $quotation->customer_email }}">{{ $quotation->customer_email }}</a>
          </div>
          @if($quotation->customer_phone)
          <div class="col-md-6">
            <div class="text-muted small fw-semibold mb-1" style="text-transform:uppercase;letter-spacing:1px;font-size:11px;">Phone</div>
            <a href="tel:{{ $quotation->customer_phone }}">{{ $quotation->customer_phone }}</a>
          </div>
          @endif
          @if($quotation->customer_company)
          <div class="col-md-6">
            <div class="text-muted small fw-semibold mb-1" style="text-transform:uppercase;letter-spacing:1px;font-size:11px;">Company</div>
            <div class="fw-semibold">{{ $quotation->customer_company }}</div>
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Requested Items --}}
    <div class="card">
      <div class="card-header" style="border-left:4px solid #78B547;">
        <h5 class="card-title mb-0"><i class="fi fi-rr-box me-2"></i> Requested Items</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0" style="font-size:14px;">
            <thead style="background:#f7f9fc;">
              <tr>
                <th class="text-muted" style="padding:11px 16px;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Product</th>
                <th class="text-muted" style="padding:11px 16px;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Qty</th>
                <th class="text-muted" style="padding:11px 16px;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Unit Price</th>
                <th class="text-muted" style="padding:11px 16px;font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($quotation->items as $item)
              <tr>
                <td style="padding:13px 16px;">
                  <div class="fw-semibold">{{ $item->product_name }}</div>
                  @if($item->product)
                    <a href="{{ route('admin.products.edit', $item->product) }}" target="_blank" style="font-size:11px;">View Product <i class="fi fi-rr-arrow-up-right-from-square"></i></a>
                  @endif
                  @if($item->specifications)
                    <div class="text-muted" style="font-size:12px;">{{ $item->specifications }}</div>
                  @endif
                </td>
                <td style="padding:13px 16px;">{{ $item->quantity }}</td>
                <td style="padding:13px 16px;">{{ $quotation->currency }} {{ number_format($item->unit_price, 2) }}</td>
                <td style="padding:13px 16px;"><strong>{{ $quotation->currency }} {{ number_format($item->total_price, 2) }}</strong></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot style="background:#f7f9fc;border-top:2px solid #e2e8f2;">
              <tr>
                <td colspan="3" class="text-end fw-bold" style="padding:13px 16px;">Total Amount</td>
                <td style="padding:13px 16px;font-size:16px;font-weight:800;color:#426693;">
                  {{ $quotation->currency }} {{ number_format($quotation->total_amount, 2) }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    {{-- ===== INVOICE ===== --}}
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title mb-0"><i class="fi fi-rr-file-invoice me-2"></i> Invoice</h5>
          <small class="text-muted">Payable once the quotation is accepted.</small>
        </div>
        <span class="badge bg-{{ $invoiceBadge }}">{{ $invoiceStatus }}</span>
      </div>
      <div class="card-body">
        <div class="doc-actions">
          <button class="doc-print-btn" onclick="printDocument('invoice-sheet')">
            <i class="fi fi-rr-print"></i> Print Invoice
          </button>
        </div>

        <div class="doc-sheet" id="invoice-sheet">
          <div class="doc-strip invoice"></div>

          {{-- Header --}}
          <div class="inv-head">
            <div class="inv-head-brand">
              <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}" class="inv-head-logo">
              <div class="inv-head-company">
                <div class="inv-head-name">{{ $companyName }}</div>
                <div class="inv-head-tagline">{{ $companyTagline }}</div>
                <div class="inv-head-contact">
                  <span>{{ $companyEmail }}</span>
                  <span>{{ $companyPhone }}</span>
                </div>
              </div>
            </div>
            <div class="inv-head-right">
              <div class="inv-type-label">Invoice</div>
              <div class="inv-number">{{ $invoiceNumber }}</div>
              <div class="inv-status-pill {{ $invoicePill }}">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                {{ $invoiceStatus }}
              </div>
            </div>
          </div>

          {{-- Meta row --}}
          <div class="inv-meta-row">
            <div class="inv-meta-cell">
              <div class="mc-label">Bill To</div>
              <div class="mc-value">{{ $quotation->customer_name }}</div>
              <div class="mc-sub">
                {{ $quotation->customer_email }}
                @if($quotation->customer_phone)<br>{{ $quotation->customer_phone }}@endif
                @if($quotation->customer_company)<br>{{ $quotation->customer_company }}@endif
              </div>
            </div>
            <div class="inv-meta-cell">
              <div class="mc-label">Issue Date</div>
              <div class="mc-value">{{ $invoiceDate?->format('M d, Y') }}</div>
              <div class="mc-sub">Quote: {{ $quotation->quote_number }}</div>
            </div>
            <div class="inv-meta-cell">
              <div class="mc-label">Due Date</div>
              <div class="mc-value">{{ $dueDate?->format('M d, Y') }}</div>
              <div class="mc-sub">{{ $invoiceStatus === 'Paid' ? 'Settled' : 'Payment due' }}</div>
            </div>
            @if($paidDate)
            <div class="inv-meta-cell">
              <div class="mc-label">Paid On</div>
              <div class="mc-value" style="color:#166534;">{{ $paidDate->format('M d, Y') }}</div>
              <div class="mc-sub">Full payment</div>
            </div>
            @else
            <div class="inv-meta-cell">
              <div class="mc-label">Currency</div>
              <div class="mc-value">{{ $quotation->currency }}</div>
              <div class="mc-sub">Status: {{ ucfirst($quotation->status) }}</div>
            </div>
            @endif
          </div>

          {{-- Items --}}
          <div class="inv-body">
            <table class="inv-table">
              <thead>
                <tr>
                  <th>Description</th>
                  <th class="text-end" style="width:70px;">Qty</th>
                  <th class="text-end" style="width:130px;">Unit Price</th>
                  <th class="text-end" style="width:130px;">Total</th>
                </tr>
              </thead>
              <tbody>
                @forelse($quotation->items as $item)
                <tr>
                  <td>
                    <div class="td-name">{{ $item->product_name }}</div>
                    @if($item->specifications)<div class="td-spec">{{ $item->specifications }}</div>@endif
                  </td>
                  <td class="text-end">{{ $item->quantity }}</td>
                  <td class="text-end">{{ $quotation->currency }} {{ number_format($item->unit_price, 2) }}</td>
                  <td class="text-end td-total">{{ $quotation->currency }} {{ number_format($item->total_price, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No items.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Totals --}}
          <div class="inv-totals">
            <div class="inv-totals-box">
              <div class="inv-totals-row">
                <span>Subtotal</span>
                <span>{{ $quotation->currency }} {{ number_format($quotation->total_amount ?? 0, 2) }}</span>
              </div>
              <div class="inv-totals-grand">
                <div class="tg-label">Total Due</div>
                <div class="tg-value">{{ $quotation->currency }} {{ number_format($quotation->total_amount ?? 0, 2) }}</div>
              </div>
            </div>
          </div>

          {{-- Bank --}}
          <div class="inv-bank">
            <div style="flex:1;min-width:200px;">
              <div class="inv-bank-title">Payment Details — Bank Transfer</div>
              <div class="inv-bank-grid">
                <div class="inv-bank-item"><div class="bi-label">Bank</div><div class="bi-value">{{ $bankName }}</div></div>
                <div class="inv-bank-item"><div class="bi-label">Account Name</div><div class="bi-value">{{ $bankAccountName }}</div></div>
                <div class="inv-bank-item"><div class="bi-label">Account No.</div><div class="bi-value">{{ $bankAccount }}</div></div>
                <div class="inv-bank-item"><div class="bi-label">SWIFT</div><div class="bi-value">{{ $bankSwift }}</div></div>
              </div>
            </div>
          </div>

          {{-- Footer --}}
          <div class="inv-footer">
            <div class="fn">
              Please quote <strong>{{ $invoiceNumber }}</strong> as your payment reference.
              Questions? <a href="mailto:{{ $companyEmail }}" style="color:#426693;">{{ $companyEmail }}</a>
            </div>
            <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}">
          </div>
        </div>
      </div>
    </div>

    {{-- ===== RECEIPT ===== --}}
    @if($quotation->paid_at)
    @php $receiptNumber = 'RC-' . $quotation->quote_number; $receiptDate = $quotation->paid_at; @endphp
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><i class="fi fi-rr-receipt me-2"></i> Payment Receipt</h5>
        <span class="badge" style="background:#78B547;">PAID</span>
      </div>
      <div class="card-body">
        <div class="doc-actions">
          <button class="doc-print-btn" onclick="printDocument('receipt-sheet')">
            <i class="fi fi-rr-print"></i> Print Receipt
          </button>
        </div>

        <div class="doc-sheet" id="receipt-sheet">
          <div class="doc-strip receipt"></div>

          {{-- Header --}}
          <div class="rec-head">
            <div class="inv-head-brand">
              <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}" class="inv-head-logo">
              <div class="inv-head-company">
                <div class="inv-head-name">{{ $companyName }}</div>
                <div class="inv-head-tagline">{{ $companyTagline }}</div>
                <div class="inv-head-contact">
                  <span>{{ $companyEmail }}</span>
                  <span>{{ $companyPhone }}</span>
                </div>
              </div>
            </div>
            <div class="inv-head-right" style="text-align:right;">
              <div class="rec-type-label">Receipt</div>
              <div class="inv-number">{{ $receiptNumber }}</div>
              <div class="rec-paid-badge"><i class="fi fi-rr-check-circle"></i> Payment Confirmed</div>
            </div>
          </div>

          {{-- Meta row --}}
          <div class="inv-meta-row">
            <div class="inv-meta-cell">
              <div class="mc-label">Received From</div>
              <div class="mc-value">{{ $quotation->customer_name }}</div>
              <div class="mc-sub">
                {{ $quotation->customer_email }}
                @if($quotation->customer_phone)<br>{{ $quotation->customer_phone }}@endif
              </div>
            </div>
            <div class="inv-meta-cell">
              <div class="mc-label">Receipt Date</div>
              <div class="mc-value">{{ $receiptDate->format('M d, Y') }}</div>
              <div class="mc-sub">{{ $receiptDate->format('h:i A') }}</div>
            </div>
            <div class="inv-meta-cell">
              <div class="mc-label">Invoice Ref.</div>
              <div class="mc-value">{{ $invoiceNumber }}</div>
              <div class="mc-sub">{{ $quotation->quote_number }}</div>
            </div>
            <div class="inv-meta-cell">
              <div class="mc-label">Status</div>
              <div class="mc-value" style="color:#166534;">Fully Paid</div>
              <div class="mc-sub">{{ $quotation->currency }}</div>
            </div>
          </div>

          {{-- Items --}}
          <div class="inv-body">
            <table class="inv-table">
              <thead>
                <tr>
                  <th>Item Description</th>
                  <th class="text-end" style="width:70px;">Qty</th>
                  <th class="text-end" style="width:130px;">Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($quotation->items as $item)
                <tr>
                  <td><div class="td-name">{{ $item->product_name }}</div></td>
                  <td class="text-end">{{ $item->quantity }}</td>
                  <td class="text-end td-total">{{ $quotation->currency }} {{ number_format($item->total_price, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No items.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Totals --}}
          <div class="inv-totals">
            <div class="inv-totals-box">
              <div class="inv-totals-grand">
                <div class="tg-label" style="color:#5f9a33;">Amount Paid</div>
                <div class="tg-value" style="color:#5f9a33;">{{ $quotation->currency }} {{ number_format($quotation->total_amount, 2) }}</div>
              </div>
            </div>
          </div>

          {{-- Footer --}}
          <div class="inv-footer">
            <div class="fn">
              Official receipt from <strong>{{ $companyName }}</strong>. Please retain for your records.
              Queries: <a href="mailto:{{ $companyEmail }}" style="color:#5f9a33;">{{ $companyEmail }}</a>
            </div>
            <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}">
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- Customer Message --}}
    @if($quotation->message)
    <div class="card">
      <div class="card-header"><h5 class="card-title mb-0"><i class="fi fi-rr-comment me-2"></i> Customer Message</h5></div>
      <div class="card-body"><p class="mb-0">{{ $quotation->message }}</p></div>
    </div>
    @endif

    {{-- Internal Notes --}}
    @if($quotation->notes)
    <div class="card border-warning">
      <div class="card-header bg-warning bg-opacity-10"><h5 class="card-title mb-0"><i class="fi fi-rr-document me-2"></i> Internal Notes</h5></div>
      <div class="card-body"><p class="mb-0">{{ $quotation->notes }}</p></div>
    </div>
    @endif

  </div>

  {{-- ===== RIGHT COLUMN ===== --}}
  <div class="col-lg-4">

    {{-- Order Action --}}
    <div class="card">
      <div class="card-header" style="border-left:4px solid #78B547;background:rgba(120,181,71,.06);">
        <h5 class="card-title mb-0" style="color:#5f9a33;">Order Actions</h5>
      </div>
      <div class="card-body">
        @if($quotation->order)
          <div class="alert alert-success mb-0">Order created: <strong>{{ $quotation->order->order_number }}</strong></div>
        @elseif(!auth()->user()->hasPermission('quotations.convert_to_order'))
          <div class="alert alert-secondary mb-0">You can view this quotation, but you do not have permission to convert it to an order.</div>
        @elseif(!$quotation->paid_at)
          <div class="alert alert-warning mb-0">Mark the invoice as paid to enable order creation.</div>
        @else
          <form action="{{ route('admin.quotations.convert-to-order', $quotation) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Convert this quotation to an order?');">
              <i class="fi fi-rr-check-circle me-2"></i> Convert to Order
            </button>
          </form>
        @endif
      </div>
    </div>

    {{-- Quotation Status --}}
    <div class="card">
      <div class="card-header" style="border-left:4px solid #426693;background:rgba(66,102,147,.06);">
        <h5 class="card-title mb-0">Quotation Status</h5>
      </div>
      <div class="card-body">
        <div class="status-detail-list">
          <div class="status-detail">
            <div class="status-detail-label">Quote Number</div>
            <div class="status-detail-value">{{ $quotation->quote_number }}</div>
          </div>

          <div class="status-detail">
            <div class="status-detail-label">Status</div>
            <div class="status-detail-value">
              <span class="badge fs-6 bg-{{ $quotation->status === 'new' ? 'secondary' : ($quotation->status === 'pending' ? 'warning' : ($quotation->status === 'quoted' ? 'primary' : ($quotation->status === 'accepted' ? 'success' : ($quotation->status === 'rejected' ? 'danger' : 'secondary')))) }}">
                {{ ucfirst($quotation->status) }}
              </span>
            </div>
          </div>

          <div class="status-detail">
            <div class="status-detail-label">Created</div>
            <div class="status-detail-value">{{ $quotation->created_at->format('M d, Y h:i A') }}</div>
            <div class="status-detail-sub">{{ $quotation->created_at->diffForHumans() }}</div>
          </div>

          @if($quotation->responded_at)
          <div class="status-detail">
            <div class="status-detail-label">Responded</div>
            <div class="status-detail-value">{{ $quotation->responded_at->format('M d, Y h:i A') }}</div>
          </div>
          @endif

          @if($quotation->approvedBy)
          <div class="status-detail">
            <div class="status-detail-label">Approved By</div>
            <div class="status-detail-value">{{ $quotation->approvedBy->name }}</div>
            <div class="status-detail-sub">{{ $quotation->approvedBy->email }}</div>
          </div>
          @endif

          @if($quotation->rejectedBy)
          <div class="status-detail">
            <div class="status-detail-label">Rejected By</div>
            <div class="status-detail-value">{{ $quotation->rejectedBy->name }}</div>
            <div class="status-detail-sub">{{ $quotation->rejectedBy->email }}</div>
          </div>
          @endif

          @if($quotation->paidBy)
          <div class="status-detail">
            <div class="status-detail-label">Marked Paid By</div>
            <div class="status-detail-value">{{ $quotation->paidBy->name }}</div>
            <div class="status-detail-sub">{{ $quotation->paidBy->email }}</div>
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Status Actions --}}
    <div class="card">
      <div class="card-header"><h5 class="card-title mb-0">Status Actions</h5></div>
      <div class="card-body">
        <div class="d-grid gap-2">
          @if(!$quotation->paid_at)
            @if($quotation->status !== 'accepted' && auth()->user()->hasPermission('quotations.accept'))
            <form action="{{ route('admin.quotations.update-status', $quotation) }}" method="POST">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="accepted">
              <button type="submit" class="btn btn-success w-100"><i class="fi fi-rr-check-circle me-2"></i> Accept Quotation</button>
            </form>
            @endif
            @if($quotation->status !== 'rejected' && auth()->user()->hasPermission('quotations.reject'))
            <form action="{{ route('admin.quotations.update-status', $quotation) }}" method="POST">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="rejected">
              <button type="submit" class="btn btn-outline-danger w-100"><i class="fi fi-rr-cross-circle me-2"></i> Reject Quotation</button>
            </form>
            @endif
          @endif
          @if($quotation->status === 'accepted' && !$quotation->paid_at && auth()->user()->hasPermission('quotations.mark_paid'))
          <div class="alert alert-warning mb-0">Invoice is unpaid. Mark as paid to generate receipt.</div>
          <form action="{{ route('admin.quotations.mark-paid', $quotation) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-primary w-100"><i class="fi fi-rr-receipt me-2"></i> Mark as Paid</button>
          </form>
          @endif
          @if(!auth()->user()->hasPermission('quotations.accept') && !auth()->user()->hasPermission('quotations.reject') && !auth()->user()->hasPermission('quotations.mark_paid'))
          <div class="alert alert-secondary mb-0">You can view this quotation, but you do not have permission to change its workflow state.</div>
          @endif
          @if($quotation->paid_at)
          <div class="alert alert-success mb-0"><i class="fi fi-rr-check-circle me-1"></i> Paid on {{ $quotation->paid_at->format('M d, Y h:i A') }}</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Update Details --}}
    <div class="card">
      <div class="card-header"><h5 class="card-title mb-0">Update Details</h5></div>
      <div class="card-body">
        @if(auth()->user()->hasPermission('quotations.update'))
        <form action="{{ route('admin.quotations.update-status', $quotation) }}" method="POST">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label">Total Amount</label>
            <input type="number" name="total_amount" class="form-control" value="{{ $quotation->total_amount }}" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Internal Notes</label>
            <textarea name="notes" class="form-control" rows="4">{{ $quotation->notes }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100"><i class="fi fi-rr-check me-2"></i> Save Details</button>
        </form>
        @else
          <div class="text-muted">This quotation is read-only for your assigned permissions.</div>
        @endif
      </div>
    </div>

    {{-- Danger Zone --}}
    @if(auth()->user()->hasPermission('quotations.update'))
      <div class="card border-danger">
        <div class="card-header bg-danger bg-opacity-10">
          <h5 class="card-title mb-0 text-danger">Danger Zone</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.quotations.destroy', $quotation) }}" method="POST"
                onsubmit="return confirm('Delete this quotation? This cannot be undone.');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger w-100"><i class="fi fi-rr-trash me-2"></i> Delete Quotation</button>
          </form>
        </div>
      </div>
    @endif

  </div>
</div>

<script>
function printDocument(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const isReceipt = elementId === 'receipt-sheet';
    const title     = isReceipt ? 'Payment Receipt' : 'Invoice';
    const allStyles = Array.from(document.querySelectorAll('style, link[rel="stylesheet"]'))
        .map(s => s.outerHTML).join('\n');
    const content = el.outerHTML;

    const win = window.open('', '_blank', 'width=900,height=700');
    win.document.write(`<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>${title} — Good Procurements</title>
  ${allStyles}
  <style>
    body {
      background: #ffffff;
      padding: 28px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    @page { margin: 12mm; }
    @media print {
      body { padding: 0; }
      .doc-sheet { box-shadow: none; }
    }
  </style>
</head>
<body>
  ${content}
  <script>
    window.onload = function() { window.print(); };
  <\/script>
</body>
</html>`);
    win.document.close();
}
</script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@500;700&family=Sora:wght@400;500;600;700&display=swap');

  .page-title-box {
    margin-bottom: 24px;
  }
  .card {
    border: 1px solid #e4ebf1;
    box-shadow: none;
  }
  .card-header {
    padding: 18px 22px;
  }
  .card-body {
    padding: 22px;
  }
  .stat-card {
    height: 100%;
    border-radius: 16px;
    background: #ffffff;
  }
  .stat-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.3px;
    color: #7b8d9d;
    font-weight: 700;
    margin-bottom: 8px;
  }
  .stat-value {
    font-size: 18px;
    font-weight: 800;
    color: #2c4153;
    line-height: 1.4;
  }
  .info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
  }
  .info-card {
    border: 1px solid #e4ebf1;
    border-radius: 16px;
    padding: 18px;
    background: #fbfdff;
  }
  .info-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.3px;
    color: #7b8d9d;
    font-weight: 700;
    margin-bottom: 10px;
  }
  .info-value {
    font-size: 15px;
    font-weight: 700;
    color: #2c4153;
    line-height: 1.7;
  }
  .info-sub {
    color: #708395;
    font-size: 13px;
    line-height: 1.7;
  }
  .order-form .form-label {
    font-weight: 700;
    margin-bottom: 8px;
  }
  .order-form .form-control,
  .order-form .form-select,
  .order-form textarea {
    padding: 12px 14px;
  }

  .receipt-sheet {
    --ink: #253b4b;
    --muted: #738697;
    --accent: #6ea53d;
    --accent-dark: #547c31;
    position: relative;
    border: 1px solid #dbe5ed;
    border-radius: 24px;
    padding: 0;
    background: #ffffff;
    overflow: hidden;
    font-family: 'Sora', 'Segoe UI', sans-serif;
    color: var(--ink);
  }
  .receipt-strip {
    height: 5px;
    background: linear-gradient(90deg, #dfead2, #b9d89a, #7aac56);
  }
  .receipt-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 22px;
    padding: 30px 32px 24px;
    border-bottom: 1px solid #e6edf3;
    background: #ffffff;
  }
  .receipt-header .brand {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    flex: 1 1 auto;
  }
  .receipt-header .brand-mark {
    width: 78px;
    height: 78px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .receipt-header img {
    width: 74px;
    height: 74px;
    object-fit: contain;
  }
  .receipt-title {
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -0.02em;
    font-family: 'Fraunces', 'Sora', serif;
  }
  .receipt-title.brand-name {
    font-weight: 700;
    color: #2a4760;
    line-height: 1.05;
  }
  .receipt-subtitle {
    margin-top: 6px;
    color: var(--muted);
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 700;
  }
  .receipt-contact {
    margin-top: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px 16px;
    color: var(--muted);
    font-size: 13px;
    font-weight: 600;
  }
  .receipt-meta {
    text-align: right;
    font-size: 13px;
    color: var(--muted);
    display: grid;
    gap: 10px;
    min-width: 220px;
    padding: 18px 20px;
    border: 1px solid #e4ebf1;
    border-radius: 18px;
    background: #f9fbfd;
  }
  .receipt-doc-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--accent-dark);
    font-weight: 800;
  }
  .receipt-doc-number {
    font-size: 20px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.35;
  }
  .receipt-badge {
    padding: 7px 14px;
    border-radius: 999px;
    background: #e6f4d9;
    color: #547c31;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1.4px;
    display: inline-flex;
    width: fit-content;
    justify-self: end;
  }
  .receipt-watermark {
    position: absolute;
    right: 26px;
    bottom: 24px;
    font-size: 76px;
    font-weight: 700;
    letter-spacing: 6px;
    color: rgba(84, 124, 49, 0.05);
    transform: rotate(-12deg);
    font-family: 'Fraunces', 'Sora', serif;
    pointer-events: none;
  }
  .receipt-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    padding: 24px 32px;
  }
  .receipt-card {
    background: #fbfdff;
    border-radius: 18px;
    padding: 18px 20px;
    border: 1px solid #e4ebf1;
  }
  .receipt-card .label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.6px;
    color: var(--muted);
    font-weight: 700;
    margin-bottom: 10px;
  }
  .receipt-card .value {
    font-weight: 700;
    line-height: 1.7;
    color: var(--ink);
  }
  .receipt-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    background: #fff;
    border-radius: 0;
    overflow: hidden;
    border-top: 1px solid #e4ebf1;
    border-bottom: 1px solid #e4ebf1;
  }
  .receipt-table th,
  .receipt-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #e8eef3;
    font-size: 14px;
  }
  .receipt-table th {
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-size: 11px;
    color: var(--muted);
    background: #f7fafc;
    font-weight: 800;
  }
  .receipt-total {
    display: flex;
    justify-content: flex-end;
    padding: 22px 32px 26px;
    background: #fafcfe;
  }
  .receipt-total .box {
    background: #ffffff;
    color: var(--ink);
    padding: 18px 20px;
    border-radius: 16px;
    min-width: 240px;
    border: 1px solid #dbe5ed;
  }
  .receipt-total .box .label {
    font-size: 11px;
    color: var(--muted);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-weight: 700;
  }
  .receipt-total .box .value {
    font-size: 24px;
    font-weight: 800;
    color: var(--accent-dark);
    margin-top: 8px;
  }
  .receipt-footer {
    padding: 18px 32px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    border-top: 1px solid #e6edf3;
    background: #ffffff;
  }
  .receipt-footer-note {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.8;
  }
  .receipt-footer img {
    width: 28px;
    height: 28px;
    object-fit: contain;
    opacity: 0.4;
  }
  @media (max-width: 768px) {
    .info-grid {
      grid-template-columns: 1fr;
    }
    .receipt-header {
      flex-direction: column;
      align-items: flex-start;
      padding: 24px 20px;
    }
    .receipt-meta {
      text-align: left;
      width: 100%;
      min-width: 0;
    }
    .receipt-details {
      grid-template-columns: 1fr;
      padding: 20px;
    }
    .receipt-watermark {
      font-size: 48px;
    }
    .receipt-total,
    .receipt-footer {
      padding: 18px 20px 22px;
    }
    .receipt-footer {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
@endpush

@section('content')
@php
  $receiptNumber = 'RC-' . $order->order_number;
  $receiptDate = $order->actual_delivery_at ?? $order->updated_at ?? $order->created_at;
  $companyName = 'Good Procurements';
  $companyEmail = config('mail.from.address', 'info@goodprocurements.com');
  $companyPhone = config('app.phone', '+234 800 000 0000');
@endphp
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h4 class="page-title">Order: {{ $order->order_number }}</h4>
        <p class="text-muted mb-0">Created {{ $order->created_at->format('M d, Y h:i A') }}</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
          <i class="fi fi-rr-arrow-left me-2"></i> Back to Orders
        </a>
        @if($order->quotation)
          <a href="{{ route('admin.quotations.show', $order->quotation) }}" class="btn btn-outline-primary">
            <i class="fi fi-rr-document me-2"></i> View Quotation
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body">
        <div class="stat-label">Status</div>
        <div class="d-flex align-items-center gap-2">
          @php
            $statusColor = match($order->status) {
              'created' => 'secondary',
              'confirmed' => 'info',
              'processing' => 'primary',
              'dispatched' => 'warning',
              'delivered' => 'success',
              'cancelled' => 'danger',
              default => 'secondary',
            };
          @endphp
          <span class="badge bg-{{ $statusColor }}">{{ ucfirst($order->status) }}</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body">
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body">
        <div class="stat-label">Tracking Reference</div>
        <div class="stat-value">{{ $order->tracking_ref ?? 'Not yet assigned' }}</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Customer & Delivery</h5>
      </div>
      <div class="card-body">
        <div class="info-grid">
          <div class="info-card">
            <div class="info-label">Customer</div>
            <div class="info-value">{{ $order->customer_name }}</div>
            <div class="info-sub">{{ $order->customer_email }}</div>
            @if($order->customer_phone)
              <div class="info-sub">{{ $order->customer_phone }}</div>
            @endif
            @if($order->customer_company)
              <div class="info-sub">{{ $order->customer_company }}</div>
            @endif
          </div>
          <div class="info-card">
            <div class="info-label">Delivery</div>
            <div class="info-value">{{ $order->delivery_contact ?? 'To be assigned' }}</div>
            <div class="info-sub">{{ $order->delivery_phone ?? 'No delivery phone set' }}</div>
            <div class="info-sub">{{ $order->delivery_address ?? 'No delivery address set' }}</div>
          </div>
          <div class="info-card">
            <div class="info-label">Expected Delivery</div>
            <div class="info-value">{{ $order->expected_delivery_at?->format('M d, Y') ?? 'Not scheduled' }}</div>
          </div>
          <div class="info-card">
            <div class="info-label">Actual Delivery</div>
            <div class="info-value">{{ $order->actual_delivery_at?->format('M d, Y') ?? 'Pending delivery' }}</div>
          </div>
          <div class="info-card">
            <div class="info-label">Carrier</div>
            <div class="info-value">{{ $order->carrier ?? 'Not assigned' }}</div>
          </div>
          <div class="info-card">
            <div class="info-label">Quotation Reference</div>
            <div class="info-value">{{ $order->quotation?->quote_number ?? 'No linked quotation' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h5 class="card-title mb-0">Order Items</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>
                    <div class="fw-semibold">{{ $item->product_name }}</div>
                    @if($item->specifications)
                      <small class="text-muted">{{ $item->specifications }}</small>
                    @endif
                  </td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ $order->currency }} {{ number_format($item->unit_price, 2) }}</td>
                  <td>{{ $order->currency }} {{ number_format($item->total_price, 2) }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">No items found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card border-warning">
      <div class="card-header bg-warning-subtle">
        <h5 class="card-title mb-0">Update Order</h5>
      </div>
      <div class="card-body">
        @if(auth()->user()->hasPermission('orders.update'))
          <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="order-form">
            @csrf
            @method('PATCH')
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                @foreach(['created','confirmed','processing','dispatched','delivered','cancelled'] as $status)
                  <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Carrier</label>
              <input type="text" name="carrier" class="form-control" value="{{ old('carrier', $order->carrier) }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Tracking Reference</label>
              <input type="text" name="tracking_ref" class="form-control" value="{{ old('tracking_ref', $order->tracking_ref) }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Delivery Address</label>
              <textarea name="delivery_address" class="form-control" rows="2">{{ old('delivery_address', $order->delivery_address) }}</textarea>
            </div>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Delivery Contact</label>
                <input type="text" name="delivery_contact" class="form-control" value="{{ old('delivery_contact', $order->delivery_contact) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Delivery Phone</label>
                <input type="text" name="delivery_phone" class="form-control" value="{{ old('delivery_phone', $order->delivery_phone) }}">
              </div>
            </div>
            <div class="row g-2 mt-1">
              <div class="col-md-6">
                <label class="form-label">Expected Delivery</label>
                <input type="date" name="expected_delivery_at" class="form-control" value="{{ old('expected_delivery_at', optional($order->expected_delivery_at)->format('Y-m-d')) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Actual Delivery</label>
                <input type="date" name="actual_delivery_at" class="form-control" value="{{ old('actual_delivery_at', optional($order->actual_delivery_at)->format('Y-m-d')) }}">
              </div>
            </div>
            <div class="mb-3 mt-3">
              <label class="form-label">Note (optional)</label>
              <textarea name="note" class="form-control" rows="3" placeholder="Add a note for this update..."></textarea>
            </div>
            <button type="submit" class="btn btn-warning w-100">
              <i class="fi fi-rr-check me-2"></i> Update Order
            </button>
          </form>
        @else
          <div class="text-muted">This order is read-only for your assigned permissions.</div>
        @endif
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Receipt Preview</h5>
        <span class="receipt-badge">Paid</span>
      </div>
      <div class="card-body">
        <div class="receipt-sheet">
          <div class="receipt-strip"></div>
          <div class="receipt-watermark">PAID</div>
          <div class="receipt-header">
            <div class="brand">
              <div class="brand-mark">
                <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}">
              </div>
              <div>
                <div class="receipt-title brand-name">{{ $companyName }}</div>
                <div class="receipt-subtitle">Official Payment Receipt</div>
                <div class="receipt-contact">
                  <span>{{ $companyEmail }}</span>
                  <span>{{ $companyPhone }}</span>
                </div>
              </div>
            </div>
            <div class="receipt-meta">
              <div class="receipt-doc-label">Receipt</div>
              <div class="receipt-doc-number">{{ $receiptNumber }}</div>
              <span class="receipt-badge">Paid</span>
              <div><strong>Order Ref.</strong> {{ $order->order_number }}</div>
              <div><strong>Receipt Date.</strong> {{ $receiptDate?->format('M d, Y') }}</div>
            </div>
          </div>

          <div class="receipt-details">
            <div class="receipt-card">
              <div class="label">Received From</div>
              <div class="value">{{ $order->customer_name }}</div>
              <div class="text-muted small mt-2">{{ $order->customer_email }}</div>
              @if($order->customer_phone)
                <div class="text-muted small">{{ $order->customer_phone }}</div>
              @endif
              @if($order->customer_company)
                <div class="text-muted small">{{ $order->customer_company }}</div>
              @endif
            </div>
            <div class="receipt-card">
              <div class="label">Order Summary</div>
              <div class="value">{{ ucfirst($order->status) }} order for {{ $order->quotation?->quote_number ?? $order->order_number }}</div>
              <div class="text-muted small mt-2">Carrier: {{ $order->carrier ?? 'Not assigned' }}</div>
              <div class="text-muted small">Tracking: {{ $order->tracking_ref ?? 'Pending' }}</div>
            </div>
          </div>

          <table class="receipt-table">
            <thead>
              <tr>
                <th>Item</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>{{ $item->product_name }}</td>
                  <td class="text-end">{{ $item->quantity }}</td>
                  <td class="text-end">{{ $order->currency }} {{ number_format($item->total_price, 2) }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center text-muted">No items found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="receipt-total">
            <div class="box">
              <div class="label">Amount Paid</div>
              <div class="value">{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</div>
            </div>
          </div>

          <div class="receipt-footer">
            <div class="receipt-footer-note">
              Official receipt issued by <strong>{{ $companyName }}</strong>.
              Keep this document for finance and delivery records.
            </div>
            <img src="{{ asset('site/assets/images/gps logo.png') }}" alt="{{ $companyName }}">
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h5 class="card-title mb-0">Order Timeline</h5>
      </div>
      <div class="card-body">
        @if($order->statusHistory->count() > 0)
          <ul class="list-group list-group-flush">
            @foreach($order->statusHistory->sortByDesc('created_at') as $history)
              <li class="list-group-item">
                <div class="d-flex justify-content-between">
                  <div>
                    <strong>{{ ucfirst($history->status) }}</strong>
                    @if($history->note)
                      <div class="text-muted small">{{ $history->note }}</div>
                    @endif
                    <div class="text-muted small">By {{ $history->changedBy->name ?? 'System' }}</div>
                  </div>
                  <div class="text-muted small">{{ $history->created_at->diffForHumans() }}</div>
                </div>
              </li>
            @endforeach
          </ul>
        @else
          <div class="text-muted">No status updates yet.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <h4 class="page-title">Orders Management</h4>
      <p class="text-muted mb-0">Track orders created from quotations and manage delivery progress</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
              All
              <span class="badge bg-secondary ms-2">{{ $statusCounts['all'] }}</span>
            </a>
          </li>
          @foreach(['created' => 'secondary', 'confirmed' => 'info', 'processing' => 'primary', 'dispatched' => 'warning', 'delivered' => 'success', 'cancelled' => 'danger'] as $status => $color)
            <li class="nav-item">
              <a class="nav-link {{ request('status') === $status ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => $status]) }}">
                {{ ucfirst($status) }}
                <span class="badge bg-{{ $color }} ms-2">{{ $statusCounts[$status] ?? 0 }}</span>
              </a>
            </li>
          @endforeach
        </ul>

        <div class="row mb-3">
          <div class="col-md-8">
            <form method="GET" action="{{ route('admin.orders.index') }}">
              @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
              @endif
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search order number, customer, email, company, tracking ref..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                  <i class="fi fi-rr-search"></i> Search
                </button>
                @if(request('search'))
                  <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}" class="btn btn-outline-secondary">Clear</a>
                @endif
              </div>
            </form>
          </div>
          <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.quotations.index') }}" class="btn btn-outline-primary">
              <i class="fi fi-rr-document me-1"></i> View Quotations
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tracking</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                <tr>
                  <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-primary">
                      {{ $order->order_number }}
                    </a>
                    @if($order->quotation)
                      <div class="text-muted small">{{ $order->quotation->quote_number }}</div>
                    @endif
                  </td>
                  <td>
                    <div>
                      <strong>{{ $order->customer_name }}</strong><br>
                      <small class="text-muted">{{ $order->customer_email }}</small>
                      @if($order->customer_company)
                        <br><small class="text-muted">{{ $order->customer_company }}</small>
                      @endif
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-info">{{ $order->items_count }} item(s)</span>
                  </td>
                  <td>
                    <strong>{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</strong>
                  </td>
                  <td>
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
                  </td>
                  <td>
                    @if($order->tracking_ref)
                      <span class="text-muted">{{ $order->tracking_ref }}</span>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <span data-bs-toggle="tooltip" title="{{ $order->created_at->format('M d, Y h:i A') }}">
                      {{ $order->created_at->diffForHumans() }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="View Order">
                      <i class="fi fi-rr-eye"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">No orders found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $orders->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>
@endpush

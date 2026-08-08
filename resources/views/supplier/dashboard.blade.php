@extends('supplier.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card text-center p-4">
      <div style="font-size:28px;font-weight:700;color:#426693;">{{ $stats['total'] }}</div>
      <div style="color:#6b7280;font-size:13px;margin-top:4px;">Total Products</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card text-center p-4">
      <div style="font-size:28px;font-weight:700;color:#f59e0b;">{{ $stats['pending'] }}</div>
      <div style="color:#6b7280;font-size:13px;margin-top:4px;">Pending Approval</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card text-center p-4">
      <div style="font-size:28px;font-weight:700;color:#2e7d32;">{{ $stats['approved'] }}</div>
      <div style="color:#6b7280;font-size:13px;margin-top:4px;">Approved & Live</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card text-center p-4">
      <div style="font-size:28px;font-weight:700;color:#c62828;">{{ $stats['rejected'] }}</div>
      <div style="color:#6b7280;font-size:13px;margin-top:4px;">Rejected</div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Recent Products</span>
        <a href="{{ route('supplier.products.create') }}" class="btn btn-sm btn-gps-primary">
          <i class="fas fa-plus me-1"></i> Submit New
        </a>
      </div>
      <div class="card-body p-0">
        @if($recentProducts->isEmpty())
          <div class="text-center py-5 text-muted">
            <i class="fas fa-boxes fa-2x mb-3 d-block"></i>
            No products yet. <a href="{{ route('supplier.products.create') }}">Submit your first product</a>.
          </div>
        @else
          <table class="table table-hover mb-0">
            <thead><tr>
              <th class="ps-4">Product</th>
              <th>Status</th>
              <th>Submitted</th>
              <th></th>
            </tr></thead>
            <tbody>
              @foreach($recentProducts as $product)
              <tr>
                <td class="ps-4">
                  <div class="fw-600" style="font-size:14px;">{{ $product->name }}</div>
                  @if($product->price)
                    <small class="text-muted">{{ $product->currency }} {{ number_format($product->price, 2) }}</small>
                  @endif
                </td>
                <td>
                  <span class="status-badge status-{{ $product->approval_status }}">
                    {{ ucfirst($product->approval_status) }}
                  </span>
                </td>
                <td><small class="text-muted">{{ $product->created_at->diffForHumans() }}</small></td>
                <td>
                  <a href="{{ route('supplier.products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Supplier Profile</div>
      <div class="card-body">
        <div class="mb-2">
          <div class="text-muted" style="font-size:11px;">ORGANIZATION</div>
          <div class="fw-600">{{ $profile->organization_name }}</div>
        </div>
        @if($profile->category)
        <div class="mb-2">
          <div class="text-muted" style="font-size:11px;">CATEGORY</div>
          <div>{{ $profile->category }}</div>
        </div>
        @endif
        @if($profile->business_phone)
        <div class="mb-2">
          <div class="text-muted" style="font-size:11px;">PHONE</div>
          <div>{{ $profile->business_phone }}</div>
        </div>
        @endif
        @if($profile->website)
        <div class="mb-2">
          <div class="text-muted" style="font-size:11px;">WEBSITE</div>
          <div><a href="{{ $profile->website }}" target="_blank" rel="noopener">{{ $profile->website }}</a></div>
        </div>
        @endif
        <div class="mt-3">
          <span class="status-badge status-{{ $profile->status === 'approved' ? 'approved' : 'pending' }}">
            {{ ucwords(str_replace('_', ' ', $profile->status)) }}
          </span>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">Quick Actions</div>
      <div class="card-body d-grid gap-2">
        <a href="{{ route('supplier.products.create') }}" class="btn btn-gps-primary btn-sm">
          <i class="fas fa-plus me-1"></i> Submit New Product
        </a>
        <a href="{{ route('supplier.products.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="fas fa-list me-1"></i> View All Products
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

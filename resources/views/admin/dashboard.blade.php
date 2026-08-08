@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <h4 class="page-title">Dashboard</h4>
      <p class="text-muted">Welcome to Good Procurement Service Ltd Admin Panel</p>
    </div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row">
  <!-- Total Products -->
  <div class="col-xl-3 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2">Total Products</h6>
            <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
          </div>
          <div class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded">
            <i class="fi fi-rr-layout-fluid fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Active Products -->
  <div class="col-xl-3 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2">Active Products</h6>
            <h3 class="mb-0">{{ $stats['active_products'] }}</h3>
          </div>
          <div class="avatar avatar-lg bg-success bg-opacity-10 text-success rounded">
            <i class="fi fi-rr-check-circle fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Quotations -->
  <div class="col-xl-3 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2">Pending Quotations</h6>
            <h3 class="mb-0">{{ $stats['pending_quotations'] }}</h3>
          </div>
          <div class="avatar avatar-lg bg-warning bg-opacity-10 text-warning rounded">
            <i class="fi fi-rr-time-fast fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Quotations -->
  <div class="col-xl-3 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2">Total Quotations</h6>
            <h3 class="mb-0">{{ $stats['total_quotations'] }}</h3>
          </div>
          <div class="avatar avatar-lg bg-info bg-opacity-10 text-info rounded">
            <i class="fi fi-rr-document fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="row">
  <!-- Quick Actions -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Quick Actions</h5>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fi fi-rr-plus me-2"></i> Add New Product
          </a>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
            <i class="fi fi-rr-box me-2"></i> Manage Products
          </a>
          <a href="{{ route('admin.quotations.index') }}" class="btn btn-outline-secondary">
            <i class="fi fi-rr-document me-2"></i> View Quotations
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Quotations -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Quotations</h5>
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-sm btn-link">View All</a>
      </div>
      <div class="card-body">
        @if($recentQuotations->count() > 0)
          <ul class="list-group list-group-flush">
            @foreach($recentQuotations as $quote)
              <li class="list-group-item px-0">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h6 class="mb-1">
                      <a href="{{ route('admin.quotations.show', $quote) }}">
                        {{ $quote->quote_number }}
                      </a>
                    </h6>
                    <small class="text-muted">{{ $quote->customer_name }}</small>
                  </div>
                  <div class="text-end">
                    <span class="badge bg-{{ $quote->status === 'new' ? 'secondary' : ($quote->status === 'pending' ? 'warning' : ($quote->status === 'accepted' ? 'success' : 'secondary')) }}">
                      {{ ucfirst($quote->status) }}
                    </span>
                    <small class="d-block text-muted mt-1">
                      {{ $quote->created_at->diffForHumans() }}
                    </small>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-muted text-center py-3">No quotations yet</p>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Products Overview -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Products</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
          <i class="fi fi-rr-box me-1"></i> All Products
        </a>
      </div>
      <div class="card-body">
        @if($recentProducts->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Service</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentProducts as $product)
                  <tr>
                    <td>
                      <strong>{{ $product->name }}</strong><br>
                      <small class="text-muted">{{ $product->sku }}</small>
                    </td>
                    <td>{{ $product->category?->name ?? '-' }}</td>
                    <td>{{ $product->service?->name ?? '-' }}</td>
                    <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                    <td>
                      <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>
                      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light">
                        <i class="fi fi-rr-edit"></i>
                      </a>
                      @if($product->productPage)
                        <a href="{{ route('admin.products.page.edit', $product) }}" class="btn btn-sm btn-primary">
                          <i class="fi fi-rr-layout-fluid"></i>
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted text-center py-3">No products yet. <a href="{{ route('admin.products.create') }}">Add your first product</a></p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

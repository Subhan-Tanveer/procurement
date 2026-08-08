@extends('admin.layouts.app')

@section('title', 'Products Management')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/libs/datatables/datatables.min.css') }}">
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Products Management</h4>
        <p class="text-muted mb-0">Manage all your products and build custom pages</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.product-pages.index') }}" class="btn btn-outline-primary">
          <i class="fi fi-rr-layout-fluid me-2"></i> Page Builder
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
          <i class="fi fi-rr-plus me-2"></i> Add New Product
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="productsTable" class="table table-hover">
            <thead>
              <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Service</th>
                <th>Price</th>
                <th>Status</th>
                <th>Page</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($product->featured_image)
                        <img src="{{ asset($product->featured_image) }}"
                             alt="{{ $product->name }}"
                             class="rounded me-2"
                             style="width: 40px; height: 40px; object-fit: cover;">
                      @endif
                      <div>
                        <strong>{{ $product->name }}</strong><br>
                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>{{ $product->category?->name ?? '-' }}</td>
                  <td>{{ $product->service?->name ?? '-' }}</td>
                  <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                  <td>
                    @if($product->is_active)
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-secondary">Inactive</span>
                    @endif
                    @if($product->is_featured)
                      <span class="badge bg-warning">Featured</span>
                    @endif
                  </td>
                  <td>
                    @if($product->productPage)
                      @if($product->productPage->is_published)
                        <span class="badge bg-success">
                          <i class="fi fi-rr-check-circle"></i> Published
                        </span>
                      @else
                        <span class="badge bg-warning">
                          <i class="fi fi-rr-time-fast"></i> Draft
                        </span>
                      @endif
                    @else
                      <span class="badge bg-light text-dark">No Page</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="{{ route('admin.products.edit', $product) }}"
                         class="btn btn-sm btn-light"
                         data-bs-toggle="tooltip"
                         title="Edit Product">
                        <i class="fi fi-rr-edit"></i>
                      </a>
                      <a href="{{ route('admin.products.page.edit', $product) }}"
                         class="btn btn-sm btn-primary"
                         data-bs-toggle="tooltip"
                         title="Page Builder">
                        <i class="fi fi-rr-layout-fluid"></i>
                      </a>
                      @if($product->productPage && $product->productPage->is_published)
                        <a href="{{ route('products.show', $product->productPage->slug) }}"
                           class="btn btn-sm btn-info"
                           target="_blank"
                           data-bs-toggle="tooltip"
                           title="View Page">
                          <i class="fi fi-rr-eye"></i>
                        </a>
                      @endif
                      <form action="{{ route('admin.products.destroy', $product) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip"
                                title="Delete">
                          <i class="fi fi-rr-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('admin/libs/datatables/datatables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>
@endpush

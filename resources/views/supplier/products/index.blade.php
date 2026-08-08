@extends('supplier.layouts.app')
@section('title', 'My Products')
@section('page-title', 'My Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="text-muted" style="font-size:14px;">
    {{ $products->total() }} product(s) found
  </div>
  <a href="{{ route('supplier.products.create') }}" class="btn btn-gps-primary btn-sm">
    <i class="fas fa-plus me-1"></i> Submit Product
  </a>
</div>

<div class="card">
  <div class="card-body p-0">
    @if($products->isEmpty())
      <div class="text-center py-5 text-muted">
        <i class="fas fa-boxes fa-2x mb-3 d-block"></i>
        You haven't submitted any products yet.
        <a href="{{ route('supplier.products.create') }}">Submit your first product</a>
      </div>
    @else
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th class="ps-4" style="width:60px;"></th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Submitted</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            <td class="ps-4">
              @if($product->featured_image)
                <img src="{{ asset($product->featured_image) }}" alt=""
                     style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
              @else
                <div style="width:44px;height:44px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                  <i class="fas fa-box text-muted"></i>
                </div>
              @endif
            </td>
            <td>
              <div class="fw-600" style="font-size:14px;">{{ $product->name }}</div>
              @if($product->short_description)
                <small class="text-muted text-truncate d-block" style="max-width:260px;">
                  {{ $product->short_description }}
                </small>
              @endif
            </td>
            <td>{{ $product->category?->name ?? '—' }}</td>
            <td>
              @if($product->price)
                {{ $product->currency }} {{ number_format($product->price, 2) }}
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td>
              <span class="status-badge status-{{ $product->approval_status }}">
                {{ ucfirst($product->approval_status) }}
              </span>
              @if($product->approval_status === 'rejected' && $product->approval_notes)
                <i class="fas fa-exclamation-circle text-danger ms-1"
                   title="{{ $product->approval_notes }}"
                   data-bs-toggle="tooltip"></i>
              @endif
            </td>
            <td><small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small></td>
            <td>
              <a href="{{ route('supplier.products.show', $product->id) }}"
                 class="btn btn-sm btn-outline-secondary me-1">View</a>
              @if($product->approval_status !== 'approved')
                <a href="{{ route('supplier.products.edit', $product->id) }}"
                   class="btn btn-sm btn-outline-primary">Edit</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @if($products->hasPages())
        <div class="p-3">{{ $products->links() }}</div>
      @endif
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });
</script>
@endpush

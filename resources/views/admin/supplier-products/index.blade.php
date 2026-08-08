@extends('admin.layouts.app')
@section('title', 'Supplier Products')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <h4 class="page-title">Supplier Products</h4>
  </div>
</div>

<div class="mb-3 d-flex gap-2 flex-wrap">
  @php $current = request('status', 'pending'); @endphp
  @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
    <a href="{{ route('admin.supplier-products.index', ['status' => $key]) }}"
       class="btn btn-sm {{ $current === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
      {{ $label }}
      <span class="badge {{ $current === $key ? 'bg-white text-primary' : 'bg-secondary' }} ms-1">{{ $counts[$key] ?? 0 }}</span>
    </a>
  @endforeach
</div>

<form class="d-flex gap-2 mb-4" method="GET">
  <input type="hidden" name="status" value="{{ $current }}">
  <input type="text" name="search" class="form-control form-control-sm" style="max-width:300px;"
         placeholder="Search product name..." value="{{ request('search') }}">
  <button type="submit" class="btn btn-sm btn-outline-primary">Search</button>
</form>

<div class="card">
  <div class="card-body p-0">
    @if($products->isEmpty())
      <div class="text-center py-5 text-muted">No {{ $current }} products found.</div>
    @else
      <table class="table table-hover mb-0">
        <thead><tr>
          <th class="ps-4" style="width:60px;"></th>
          <th>Product</th>
          <th>Supplier</th>
          <th>Category</th>
          <th>Price</th>
          <th>Status</th>
          <th>Submitted</th>
          <th></th>
        </tr></thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            <td class="ps-4">
              @if($product->featured_image)
                <img src="{{ asset($product->featured_image) }}" alt=""
                     style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
              @else
                <div style="width:44px;height:44px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                  <i class="fas fa-box text-muted"></i>
                </div>
              @endif
            </td>
            <td>
              <div class="fw-semibold">{{ $product->name }}</div>
              @if($product->short_description)
                <small class="text-muted text-truncate d-block" style="max-width:220px;">{{ $product->short_description }}</small>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.suppliers.show', $product->supplier) }}" class="text-decoration-none">
                {{ $product->supplier?->organization_name }}
              </a>
            </td>
            <td>{{ $product->category?->name ?? '—' }}</td>
            <td>
              @if($product->price)
                {{ $product->currency }} {{ number_format($product->price, 2) }}
              @else —
              @endif
            </td>
            <td>
              @php $sc = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']; @endphp
              <span class="badge bg-{{ $sc[$product->approval_status] ?? 'secondary' }}">{{ ucfirst($product->approval_status) }}</span>
            </td>
            <td><small>{{ $product->created_at->format('M d, Y') }}</small></td>
            <td>
              <a href="{{ route('admin.supplier-products.show', $product) }}" class="btn btn-sm btn-primary">Review</a>
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

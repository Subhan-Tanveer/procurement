@extends('admin.layouts.app')
@section('title', $product->name)

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
  <div>
    <a href="{{ route('admin.supplier-products.index') }}" class="btn btn-sm btn-outline-secondary me-2">
      <i class="fas fa-arrow-left me-1"></i> Back
    </a>
    <span class="page-title">Review Product</span>
  </div>
  @php $sc = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']; @endphp
  <span class="badge bg-{{ $sc[$product->approval_status] ?? 'secondary' }} fs-6">
    {{ ucfirst($product->approval_status) }}
  </span>
</div>

@if(session('success'))
  <div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<div class="row g-4 mt-1">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">{{ $product->name }}</div>
      <div class="card-body">
        @if($product->featured_image)
          <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}"
               class="rounded mb-3" style="max-height:280px;width:100%;object-fit:cover;">
        @endif

        @if($product->short_description)
          <p class="text-muted">{{ $product->short_description }}</p>
        @endif

        @if($product->description)
          <div class="mb-4" style="line-height:1.7;">{!! nl2br(e($product->description)) !!}</div>
        @endif

        @if($product->specifications->isNotEmpty())
          <h6 class="fw-semibold mb-2">Specifications</h6>
          <table class="table table-sm table-bordered">
            <tbody>
              @foreach($product->specifications as $spec)
              <tr>
                <td class="fw-semibold" style="width:35%;background:#f9fafb;">{{ $spec->label }}</td>
                <td>{{ $spec->value }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    @if($product->images->isNotEmpty())
    <div class="card mt-4">
      <div class="card-header">Gallery ({{ $product->images->count() }} images)</div>
      <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
          @foreach($product->images as $img)
            <a href="{{ asset($img->image_path) }}" target="_blank">
              <img src="{{ asset($img->image_path) }}" alt=""
                   style="height:100px;width:100px;object-fit:cover;border-radius:8px;">
            </a>
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </div>

  <div class="col-lg-4">
    {{-- Product meta --}}
    <div class="card">
      <div class="card-header">Details</div>
      <div class="card-body">
        <dl class="row mb-0" style="font-size:13px;">
          <dt class="col-5 text-muted">Supplier</dt>
          <dd class="col-7">
            <a href="{{ route('admin.suppliers.show', $product->supplier) }}">
              {{ $product->supplier?->organization_name }}
            </a>
          </dd>
          <dt class="col-5 text-muted">Category</dt>
          <dd class="col-7">{{ $product->category?->name ?? '—' }}</dd>
          <dt class="col-5 text-muted">Price</dt>
          <dd class="col-7">
            @if($product->price)
              {{ $product->currency }} {{ number_format($product->price, 2) }}
            @else —
            @endif
          </dd>
          <dt class="col-5 text-muted">Stock</dt>
          <dd class="col-7">{{ ucwords(str_replace('_', ' ', $product->stock_status ?? '')) }}</dd>
          <dt class="col-5 text-muted">Submitted</dt>
          <dd class="col-7">{{ $product->created_at->format('M d, Y') }}</dd>
          @if($product->approval_status === 'approved')
            <dt class="col-5 text-muted">Approved by</dt>
            <dd class="col-7">{{ $product->approvedByUser?->name ?? '—' }}</dd>
            <dt class="col-5 text-muted">Approved at</dt>
            <dd class="col-7">{{ $product->approved_at?->format('M d, Y') }}</dd>
          @endif
        </dl>
      </div>
    </div>

    @if($product->approval_status === 'pending')
    {{-- Approve --}}
    <div class="card mt-3">
      <div class="card-header text-success fw-semibold">Approve Product</div>
      <div class="card-body">
        <p style="font-size:13px;" class="text-muted">
          Approving will set <code>is_active = true</code> and make the product visible on the site.
        </p>
        <form method="POST" action="{{ route('admin.supplier-products.approve', $product) }}">
          @csrf @method('PATCH')
          <button type="submit" class="btn btn-success btn-sm w-100">
            <i class="fas fa-check me-1"></i> Approve & Publish
          </button>
        </form>
      </div>
    </div>

    {{-- Reject --}}
    <div class="card mt-3">
      <div class="card-header text-danger fw-semibold">Reject Product</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.supplier-products.reject', $product) }}">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label" style="font-size:13px;">Reason for rejection *</label>
            <textarea name="approval_notes" class="form-control form-control-sm" rows="3"
                      required placeholder="Explain what needs to be fixed..."></textarea>
            @error('approval_notes')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-danger btn-sm w-100"
                  onclick="return confirm('Reject this product?')">
            <i class="fas fa-times me-1"></i> Reject
          </button>
        </form>
      </div>
    </div>
    @endif

    @if($product->approval_status === 'rejected')
    <div class="card mt-3">
      <div class="card-header">Rejection Notes</div>
      <div class="card-body">
        <p style="font-size:13px;">{{ $product->approval_notes }}</p>
        <form method="POST" action="{{ route('admin.supplier-products.approve', $product) }}">
          @csrf @method('PATCH')
          <button type="submit" class="btn btn-success btn-sm w-100">
            <i class="fas fa-check me-1"></i> Override & Approve
          </button>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

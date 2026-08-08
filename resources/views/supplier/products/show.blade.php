@extends('supplier.layouts.app')
@section('title', $product->name)
@section('page-title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <a href="{{ route('supplier.products.index') }}" class="btn btn-sm btn-outline-secondary">
    <i class="fas fa-arrow-left me-1"></i> Back to Products
  </a>
  <div class="d-flex gap-2">
    @if($product->approval_status !== 'approved')
      <a href="{{ route('supplier.products.edit', $product->id) }}" class="btn btn-sm btn-gps-primary">
        <i class="fas fa-edit me-1"></i> Edit
      </a>
    @endif
  </div>
</div>

{{-- Approval status banner --}}
@if($product->approval_status === 'pending')
  <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="fas fa-hourglass-half"></i>
    <div><strong>Pending Review</strong> — This product is awaiting admin approval before it goes live.</div>
  </div>
@elseif($product->approval_status === 'rejected')
  <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
    <i class="fas fa-times-circle mt-1"></i>
    <div>
      <strong>Product Rejected</strong>
      @if($product->approval_notes)
        <br><span class="text-muted">{{ $product->approval_notes }}</span>
      @endif
      <br><a href="{{ route('supplier.products.edit', $product->id) }}" class="alert-link">Edit and resubmit</a>
    </div>
  </div>
@elseif($product->approval_status === 'approved')
  <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
    <i class="fas fa-check-circle"></i>
    <div><strong>Live</strong> — This product is approved and visible to buyers.
      @if($product->approved_at)
        <small class="text-muted ms-1">Approved {{ $product->approved_at->diffForHumans() }}</small>
      @endif
    </div>
  </div>
@endif

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <span>{{ $product->name }}</span>
        <span class="status-badge status-{{ $product->approval_status }}">{{ ucfirst($product->approval_status) }}</span>
      </div>
      <div class="card-body">
        @if($product->featured_image)
          <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}"
               class="rounded mb-3" style="max-height:280px;width:100%;object-fit:cover;">
        @endif

        @if($product->short_description)
          <p class="text-muted mb-3">{{ $product->short_description }}</p>
        @endif

        @if($product->description)
          <div class="mb-4" style="line-height:1.7;">{!! nl2br(e($product->description)) !!}</div>
        @endif

        @if($product->specifications->isNotEmpty())
          <h6 class="fw-600 mb-2">Specifications</h6>
          <table class="table table-sm table-bordered">
            <tbody>
              @foreach($product->specifications as $spec)
              <tr>
                <td class="fw-600" style="width:40%;background:#f9fafb;">{{ $spec->label }}</td>
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
      <div class="card-header">Gallery</div>
      <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
          @foreach($product->images as $img)
            <img src="{{ asset($img->image_path) }}" alt=""
                 style="height:100px;width:100px;object-fit:cover;border-radius:8px;cursor:pointer;"
                 onclick="this.requestFullscreen ? this.requestFullscreen() : null">
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Product Details</div>
      <div class="card-body">
        <dl class="row mb-0" style="font-size:13px;">
          <dt class="col-5 text-muted">Category</dt>
          <dd class="col-7">{{ $product->category?->name ?? '—' }}</dd>
          <dt class="col-5 text-muted">Price</dt>
          <dd class="col-7">
            @if($product->price)
              {{ $product->currency }} {{ number_format($product->price, 2) }}
            @else
              —
            @endif
          </dd>
          <dt class="col-5 text-muted">Stock</dt>
          <dd class="col-7">{{ ucwords(str_replace('_', ' ', $product->stock_status)) }}</dd>
          <dt class="col-5 text-muted">Submitted</dt>
          <dd class="col-7">{{ $product->created_at->format('M d, Y') }}</dd>
          <dt class="col-5 text-muted">Updated</dt>
          <dd class="col-7">{{ $product->updated_at->format('M d, Y') }}</dd>
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection

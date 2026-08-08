@extends('admin.layouts.app')
@section('title', $application->application_number)

@section('content')
@php
  $canManageSuppliers = auth()->user()->hasPermission('suppliers.manage');
  $canManageProducts = auth()->user()->hasPermission('products.manage');
  $statusColors = [
    'submitted' => 'warning',
    'under_review' => 'info',
    'approved' => 'success',
    'rejected' => 'danger',
    'changes_requested' => 'secondary',
  ];
  $productStatusColors = [
    'submitted' => 'warning',
    'under_review' => 'info',
    'approved' => 'success',
    'rejected' => 'danger',
    'converted' => 'primary',
  ];
@endphp
<div class="page-header d-flex justify-content-between align-items-center">
  <div>
    <a href="{{ route('admin.supplier-applications.index') }}" class="btn btn-sm btn-outline-secondary me-2">
      <i class="fas fa-arrow-left me-1"></i> All Applications
    </a>
    <span class="page-title">{{ $application->application_number }}</span>
  </div>
  <span class="badge bg-{{ $statusColors[$application->status] ?? 'secondary' }} fs-6">
    {{ ucwords(str_replace('_', ' ', $application->status)) }}
  </span>
</div>

@if(session('success'))
  <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif
@if(session('info'))
  <div class="alert alert-info mt-3">{{ session('info') }}</div>
@endif

<div class="row g-4 mt-1">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">Organization Submission</div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-4 text-muted">Organization</dt><dd class="col-8">{{ $application->organization_name }}</dd>
          <dt class="col-4 text-muted">Primary Contact</dt><dd class="col-8">{{ $application->contact_name }}</dd>
          <dt class="col-4 text-muted">Contact Email</dt><dd class="col-8">{{ $application->contact_email }}</dd>
          <dt class="col-4 text-muted">Contact Phone</dt><dd class="col-8">{{ $application->contact_phone ?? '—' }}</dd>
          <dt class="col-4 text-muted">Category</dt><dd class="col-8">{{ $application->category ?? '—' }}</dd>
          <dt class="col-4 text-muted">Business Phone</dt><dd class="col-8">{{ $application->business_phone ?? '—' }}</dd>
          <dt class="col-4 text-muted">Website</dt>
          <dd class="col-8">
            @if($application->website)
              <a href="{{ $application->website }}" target="_blank" rel="noopener">{{ $application->website }}</a>
            @else
              —
            @endif
          </dd>
          <dt class="col-4 text-muted">Submitted</dt><dd class="col-8">{{ $application->submitted_at?->format('M d, Y h:i A') ?? $application->created_at->format('M d, Y h:i A') }}</dd>
          <dt class="col-4 text-muted">Approved Profile</dt>
          <dd class="col-8">
            @if($application->approvedSupplierProfile)
              <a href="{{ route('admin.suppliers.show', $application->approvedSupplierProfile) }}">{{ $application->approvedSupplierProfile->organization_name }}</a>
            @else
              Not created yet
            @endif
          </dd>
        </dl>
        @if($application->business_address)
          <div class="mt-3"><strong>Business Address</strong><div class="text-muted mt-1">{{ $application->business_address }}</div></div>
        @endif
        @if($application->description)
          <div class="mt-3"><strong>Organization Description</strong><div class="text-muted mt-1">{{ $application->description }}</div></div>
        @endif
        @if($application->logo)
          <div class="mt-3">
            <strong>Submitted Logo</strong>
            <div class="mt-2"><img src="{{ asset($application->logo) }}" alt="{{ $application->organization_name }}" style="max-height:90px;"></div>
          </div>
        @endif
        @if($application->review_notes)
          <div class="alert alert-secondary p-2 mt-3 mb-0" style="font-size:13px;">
            <strong>Review Notes:</strong> {{ $application->review_notes }}
          </div>
        @endif
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header">Submitted Products ({{ $application->products->count() }})</div>
      <div class="card-body">
        @forelse($application->products as $product)
          <div class="border rounded-3 p-3 {{ !$loop->last ? 'mb-4' : '' }}">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
              <div>
                <div class="fw-semibold fs-5">{{ $product->name }}</div>
                <div class="text-muted small">Supplier-submitted price: {{ $product->price ? $product->currency . ' ' . number_format($product->price, 2) : 'Not provided' }}</div>
              </div>
              <span class="badge bg-{{ $productStatusColors[$product->status] ?? 'secondary' }}">{{ ucwords(str_replace('_', ' ', $product->status)) }}</span>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6"><strong>Category:</strong> {{ $product->category?->name ?? '—' }}</div>
              <div class="col-md-6"><strong>Service:</strong> {{ $product->service?->title ?? '—' }}</div>
              <div class="col-md-6"><strong>SKU:</strong> {{ $product->sku ?? '—' }}</div>
              <div class="col-md-6"><strong>Stock:</strong> {{ ucwords(str_replace('_', ' ', $product->stock_status)) }}</div>
            </div>

            @if($product->short_description)
              <div class="mb-3"><strong>Short Description</strong><div class="text-muted mt-1">{{ $product->short_description }}</div></div>
            @endif
            @if($product->description)
              <div class="mb-3"><strong>Detailed Description</strong><div class="text-muted mt-1" style="line-height:1.7;">{!! nl2br(e($product->description)) !!}</div></div>
            @endif

            @if($product->specifications->isNotEmpty())
              <div class="mb-3">
                <strong>Specifications</strong>
                <table class="table table-sm table-bordered mt-2 mb-0">
                  <tbody>
                    @foreach($product->specifications as $spec)
                      <tr>
                        <td style="width:35%;background:#f9fafb;" class="fw-semibold">{{ $spec->name }}</td>
                        <td>{{ $spec->value }}{{ $spec->unit ? ' (' . $spec->unit . ')' : '' }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif

            @if($product->featured_image || $product->images->isNotEmpty())
              <div class="mb-3">
                <strong>Images</strong>
                <div class="d-flex flex-wrap gap-2 mt-2">
                  @if($product->featured_image)
                    <a href="{{ asset($product->featured_image) }}" target="_blank">
                      <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </a>
                  @endif
                  @foreach($product->images as $image)
                    <a href="{{ asset($image->image_path) }}" target="_blank">
                      <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

            @if($product->review_notes)
              <div class="alert alert-secondary p-2 mb-3" style="font-size:13px;">
                <strong>Product Review Notes:</strong> {{ $product->review_notes }}
              </div>
            @endif

            <div class="d-flex gap-2 flex-wrap">
              @if($canManageSuppliers && $product->status !== 'approved' && $product->status !== 'converted')
                <form method="POST" action="{{ route('admin.supplier-applications.products.approve', [$application, $product]) }}">
                  @csrf @method('PATCH')
                  <input type="hidden" name="review_notes" value="">
                  <button type="submit" class="btn btn-sm btn-success">Approve Product</button>
                </form>
              @endif

              @if($canManageProducts && $product->status === 'approved' && !$product->converted_product_id)
                <form method="POST" action="{{ route('admin.supplier-applications.products.convert', [$application, $product]) }}">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-primary">Convert to Product Draft</button>
                </form>
              @endif

              @if($product->converted_product_id && $canManageProducts)
                <a href="{{ route('admin.products.edit', $product->converted_product_id) }}" class="btn btn-sm btn-outline-primary">Open Catalog Draft</a>
              @endif
            </div>

            @if($canManageSuppliers && $product->status !== 'converted')
              <form method="POST" action="{{ route('admin.supplier-applications.products.reject', [$application, $product]) }}" class="mt-3">
                @csrf @method('PATCH')
                <label class="form-label small">Reject / request correction for this product</label>
                <div class="d-flex gap-2 flex-wrap">
                  <textarea name="review_notes" class="form-control" rows="2" style="max-width:520px;" placeholder="Explain what the supplier needs to fix..."></textarea>
                  <button type="submit" class="btn btn-sm btn-danger align-self-start">Reject Product</button>
                </div>
              </form>
            @endif
          </div>
        @empty
          <div class="text-muted">No submitted products found.</div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    @if($canManageSuppliers && in_array($application->status, ['submitted', 'under_review', 'changes_requested', 'rejected'], true))
      <div class="card">
        <div class="card-header">Approve Application</div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.supplier-applications.approve', $application) }}">
            @csrf @method('PATCH')
            <div class="mb-3">
              <label class="form-label">Notes (optional)</label>
              <textarea name="review_notes" class="form-control" rows="3" placeholder="Internal approval note..."></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-sm w-100">Approve and Create Supplier Profile</button>
          </form>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">Request Changes</div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.supplier-applications.request-changes', $application) }}">
            @csrf @method('PATCH')
            <div class="mb-3">
              <label class="form-label">Required changes *</label>
              <textarea name="review_notes" class="form-control" rows="3" required placeholder="Tell the supplier what needs adjustment."></textarea>
            </div>
            <button type="submit" class="btn btn-warning btn-sm w-100">Request Changes</button>
          </form>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">Reject Application</div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.supplier-applications.reject', $application) }}">
            @csrf @method('PATCH')
            <div class="mb-3">
              <label class="form-label">Reason *</label>
              <textarea name="review_notes" class="form-control" rows="3" required placeholder="Explain why the application is being rejected."></textarea>
            </div>
            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Reject this supplier application?')">Reject Application</button>
          </form>
        </div>
      </div>
    @endif

    @if($application->status === 'approved')
      <div class="card">
        <div class="card-header">Approved Supplier Profile</div>
        <div class="card-body">
          @if($application->approvedSupplierProfile)
            <p class="text-muted small mb-3">The supplier profile is now available for internal supplier contact and catalog linkage.</p>
            <a href="{{ route('admin.suppliers.show', $application->approvedSupplierProfile) }}" class="btn btn-outline-primary btn-sm w-100">Open Approved Supplier Profile</a>
          @else
            <div class="text-muted">No approved supplier profile is linked yet.</div>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

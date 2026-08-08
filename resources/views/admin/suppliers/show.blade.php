@extends('admin.layouts.app')
@section('title', $supplier->organization_name)

@section('content')
@php
  $canManageSuppliers = auth()->user()->hasPermission('suppliers.manage');
  $canManageProducts = auth()->user()->hasPermission('products.manage');
@endphp
<div class="page-header d-flex justify-content-between align-items-center">
  <div>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-sm btn-outline-secondary me-2">
      <i class="fas fa-arrow-left me-1"></i> All Suppliers
    </a>
    <span class="page-title">{{ $supplier->organization_name }}</span>
  </div>
  @php $statusColors = ['pending_review' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'suspended' => 'secondary']; @endphp
  <span class="badge bg-{{ $statusColors[$supplier->status] ?? 'secondary' }} fs-6">
    {{ ucwords(str_replace('_', ' ', $supplier->status)) }}
  </span>
</div>

@if(session('success'))
  <div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<div class="row g-4 mt-1">
  <div class="col-lg-8">
    {{-- Profile card --}}
    <div class="card">
      <div class="card-header">Supplier Profile</div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-4 text-muted">Organization</dt><dd class="col-8">{{ $supplier->organization_name }}</dd>
          <dt class="col-4 text-muted">Primary Contact</dt><dd class="col-8">{{ $supplier->contact_name ?: $supplier->user?->name ?: '—' }}</dd>
          <dt class="col-4 text-muted">Email</dt><dd class="col-8">{{ $supplier->contact_email ?: $supplier->user?->email ?: '—' }}</dd>
          <dt class="col-4 text-muted">Contact Phone</dt><dd class="col-8">{{ $supplier->contact_phone ?? '—' }}</dd>
          <dt class="col-4 text-muted">Category</dt><dd class="col-8">{{ $supplier->category ?? '—' }}</dd>
          <dt class="col-4 text-muted">Business Phone</dt><dd class="col-8">{{ $supplier->business_phone ?? '—' }}</dd>
          <dt class="col-4 text-muted">Website</dt>
          <dd class="col-8">
            @if($supplier->website)
              <a href="{{ $supplier->website }}" target="_blank" rel="noopener">{{ $supplier->website }}</a>
            @else —
            @endif
          </dd>
          <dt class="col-4 text-muted">Registered</dt><dd class="col-8">{{ $supplier->created_at->format('M d, Y') }}</dd>
          @if($supplier->reviewed_at)
            <dt class="col-4 text-muted">Reviewed</dt><dd class="col-8">{{ $supplier->reviewed_at->format('M d, Y') }} by {{ $supplier->reviewedBy?->name }}</dd>
          @endif
        </dl>
        @if($supplier->description)
          <p class="text-muted" style="font-size:14px;">{{ $supplier->description }}</p>
        @endif
        @if($supplier->review_notes)
          <div class="alert alert-secondary p-2 mb-0" style="font-size:13px;">
            <strong>Admin Notes:</strong> {{ $supplier->review_notes }}
          </div>
        @endif
      </div>
    </div>

    {{-- Catalog products --}}
    <div class="card mt-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Catalog Products</span>
      </div>
      <div class="card-body p-0">
        @if($supplier->products->isEmpty())
          <div class="text-center py-4 text-muted">No catalog products linked to this supplier yet.</div>
        @else
          <table class="table table-sm mb-0">
            <thead><tr><th class="ps-4">Product</th><th>Catalog Status</th><th>Updated</th><th></th></tr></thead>
            <tbody>
              @foreach($supplier->products as $product)
              <tr>
                <td class="ps-4">{{ $product->name }}</td>
                <td>
                  @php $sc = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger']; @endphp
                  <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }} me-1">{{ $product->is_active ? 'Live' : 'Draft' }}</span>
                  <span class="badge bg-{{ $sc[$product->approval_status] ?? 'secondary' }}">{{ ucfirst($product->approval_status) }}</span>
                </td>
                <td><small>{{ $product->updated_at->format('M d, Y') }}</small></td>
                <td>
                  @if($canManageProducts)
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Open Product</a>
                  @else
                    <span class="text-muted small">Catalog access required</span>
                  @endif
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
    {{-- Actions --}}
    @if($canManageSuppliers && $supplier->status === 'pending_review')
    <div class="card">
      <div class="card-header">Approve Supplier</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.suppliers.approve', $supplier) }}">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label">Notes (optional)</label>
            <textarea name="review_notes" class="form-control" rows="2" placeholder="Welcome message..."></textarea>
          </div>
          <button type="submit" class="btn btn-success btn-sm w-100">
            <i class="fas fa-check me-1"></i> Approve Supplier
          </button>
        </form>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">Reject Supplier</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.suppliers.reject', $supplier) }}">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label">Reason *</label>
            <textarea name="review_notes" class="form-control" rows="2" required placeholder="Explain why..."></textarea>
          </div>
          <button type="submit" class="btn btn-danger btn-sm w-100"
                  onclick="return confirm('Reject this supplier?')">
            <i class="fas fa-times me-1"></i> Reject
          </button>
        </form>
      </div>
    </div>
    @endif

    @if($canManageSuppliers && $supplier->status === 'approved')
    <div class="card">
      <div class="card-header">Suspend Supplier</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.suppliers.suspend', $supplier) }}">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label">Reason</label>
            <textarea name="review_notes" class="form-control" rows="2"></textarea>
          </div>
          <button type="submit" class="btn btn-warning btn-sm w-100"
                  onclick="return confirm('Suspend this supplier?')">
            <i class="fas fa-ban me-1"></i> Suspend
          </button>
        </form>
      </div>
    </div>
    @endif

    @if($canManageSuppliers && in_array($supplier->status, ['rejected', 'suspended']))
    <div class="card">
      <div class="card-header">Re-Approve</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.suppliers.approve', $supplier) }}">
          @csrf @method('PATCH')
          <input type="hidden" name="review_notes" value="">
          <button type="submit" class="btn btn-success btn-sm w-100">
            <i class="fas fa-check me-1"></i> Approve Supplier
          </button>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Suppliers')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <h4 class="page-title">Suppliers</h4>
  </div>
</div>

{{-- Status tabs --}}
<div class="mb-3 d-flex gap-2 flex-wrap">
  @php
    $statuses = ['all' => 'All', 'pending_review' => 'Pending Review', 'approved' => 'Approved', 'rejected' => 'Rejected', 'suspended' => 'Suspended'];
    $current = request('status', 'all');
  @endphp
  @foreach($statuses as $key => $label)
    <a href="{{ route('admin.suppliers.index', $key !== 'all' ? ['status' => $key] : []) }}"
       class="btn btn-sm {{ $current === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
      {{ $label }}
      @if(isset($counts[$key]))
        <span class="badge {{ $current === $key ? 'bg-white text-primary' : 'bg-secondary' }} ms-1">{{ $counts[$key] }}</span>
      @endif
    </a>
  @endforeach
</div>

{{-- Search --}}
<form class="d-flex gap-2 mb-4" method="GET">
  @if($current !== 'all')<input type="hidden" name="status" value="{{ $current }}">@endif
  <input type="text" name="search" class="form-control form-control-sm" style="max-width:300px;"
         placeholder="Search organization, contact, phone, or email..." value="{{ request('search') }}">
  <button type="submit" class="btn btn-sm btn-outline-primary">Search</button>
</form>

<div class="card">
  <div class="card-body p-0">
    @if($suppliers->isEmpty())
      <div class="text-center py-5 text-muted">No suppliers found.</div>
    @else
      <table class="table table-hover mb-0">
        <thead><tr>
          <th class="ps-4">Organization</th>
          <th>Contact</th>
          <th>Category</th>
          <th>Status</th>
          <th>Registered</th>
          <th></th>
        </tr></thead>
        <tbody>
          @foreach($suppliers as $supplier)
          <tr>
            <td class="ps-4">
              <div class="fw-semibold">{{ $supplier->organization_name }}</div>
              <small class="text-muted">{{ $supplier->contact_name ?: $supplier->user?->name ?: 'No contact assigned' }}</small>
            </td>
            <td>
              <div style="font-size:13px;">{{ $supplier->contact_email ?: $supplier->user?->email ?: '—' }}</div>
              @if($supplier->contact_phone)
                <small class="text-muted d-block">{{ $supplier->contact_phone }}</small>
              @endif
              @if($supplier->business_phone)
                <small class="text-muted">Business: {{ $supplier->business_phone }}</small>
              @endif
            </td>
            <td>{{ $supplier->category ?? '—' }}</td>
            <td>
              @php
                $statusColors = ['pending_review' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'suspended' => 'secondary'];
              @endphp
              <span class="badge bg-{{ $statusColors[$supplier->status] ?? 'secondary' }}">
                {{ ucwords(str_replace('_', ' ', $supplier->status)) }}
              </span>
            </td>
            <td><small>{{ $supplier->created_at->format('M d, Y') }}</small></td>
            <td>
              <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-secondary">View</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if($suppliers->hasPages())
        <div class="p-3">{{ $suppliers->links() }}</div>
      @endif
    @endif
  </div>
</div>
@endsection

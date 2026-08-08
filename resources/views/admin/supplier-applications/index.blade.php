@extends('admin.layouts.app')
@section('title', 'Supplier Applications')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <h4 class="page-title">Supplier Applications</h4>
    <p class="text-muted mb-0">Review incoming supplier submissions before creating approved supplier profiles and catalog drafts.</p>
  </div>
</div>

<div class="mb-3 d-flex gap-2 flex-wrap">
  @php
    $statuses = [
      'all' => 'All',
      'submitted' => 'Submitted',
      'under_review' => 'Under Review',
      'approved' => 'Approved',
      'rejected' => 'Rejected',
      'changes_requested' => 'Changes Requested',
    ];
    $current = request('status', 'all');
  @endphp
  @foreach($statuses as $key => $label)
    <a href="{{ route('admin.supplier-applications.index', $key !== 'all' ? ['status' => $key] : []) }}"
       class="btn btn-sm {{ $current === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
      {{ $label }}
      @if(isset($counts[$key]))
        <span class="badge {{ $current === $key ? 'bg-white text-primary' : 'bg-secondary' }} ms-1">{{ $counts[$key] }}</span>
      @endif
    </a>
  @endforeach
</div>

<form class="d-flex gap-2 mb-4" method="GET">
  @if($current !== 'all')
    <input type="hidden" name="status" value="{{ $current }}">
  @endif
  <input type="text" name="search" class="form-control form-control-sm" style="max-width:320px;" placeholder="Search organization, contact, email, or reference..." value="{{ request('search') }}">
  <button type="submit" class="btn btn-sm btn-outline-primary">Search</button>
</form>

<div class="card">
  <div class="card-body p-0">
    @if($applications->isEmpty())
      <div class="text-center py-5 text-muted">No supplier applications found.</div>
    @else
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th class="ps-4">Reference</th>
            <th>Organization</th>
            <th>Contact</th>
            <th>Products</th>
            <th>Status</th>
            <th>Submitted</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $application)
            @php
              $statusColors = [
                'submitted' => 'warning',
                'under_review' => 'info',
                'approved' => 'success',
                'rejected' => 'danger',
                'changes_requested' => 'secondary',
              ];
            @endphp
            <tr>
              <td class="ps-4">
                <div class="fw-semibold">{{ $application->application_number }}</div>
              </td>
              <td>
                <div class="fw-semibold">{{ $application->organization_name }}</div>
                @if($application->category)
                  <small class="text-muted">{{ $application->category }}</small>
                @endif
              </td>
              <td>
                <div style="font-size:13px;">{{ $application->contact_name }}</div>
                <small class="text-muted d-block">{{ $application->contact_email }}</small>
                @if($application->contact_phone)
                  <small class="text-muted">{{ $application->contact_phone }}</small>
                @endif
              </td>
              <td>{{ $application->products_count }}</td>
              <td>
                <span class="badge bg-{{ $statusColors[$application->status] ?? 'secondary' }}">
                  {{ ucwords(str_replace('_', ' ', $application->status)) }}
                </span>
              </td>
              <td><small>{{ $application->submitted_at?->format('M d, Y') ?? $application->created_at->format('M d, Y') }}</small></td>
              <td>
                <a href="{{ route('admin.supplier-applications.show', $application) }}" class="btn btn-sm btn-outline-secondary">Review</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @if($applications->hasPages())
        <div class="p-3">{{ $applications->links() }}</div>
      @endif
    @endif
  </div>
</div>
@endsection

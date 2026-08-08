@extends('admin.layouts.app')

@section('title', 'Quotations Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/libs/datatables/datatables.min.css') }}">
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <h4 class="page-title">Quotations Management</h4>
      <p class="text-muted mb-0">View and manage all quote requests from customers</p>
    </div>
  </div>
</div>

<!-- Status Tabs -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}"
               href="{{ route('admin.quotations.index') }}">
              All
              <span class="badge bg-secondary ms-2">{{ $statusCounts['all'] }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request('status') == 'new' ? 'active' : '' }}"
               href="{{ route('admin.quotations.index', ['status' => 'new']) }}">
              New
              <span class="badge bg-secondary ms-2">{{ $statusCounts['new'] }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
               href="{{ route('admin.quotations.index', ['status' => 'pending']) }}">
              Pending
              <span class="badge bg-warning ms-2">{{ $statusCounts['pending'] }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request('status') == 'quoted' ? 'active' : '' }}"
               href="{{ route('admin.quotations.index', ['status' => 'quoted']) }}">
              Quoted
              <span class="badge bg-primary ms-2">{{ $statusCounts['quoted'] }}</span>
            </a>
          </li>
        </ul>

        <!-- Search -->
        <div class="row mb-3">
          <div class="col-md-6">
            <form method="GET" action="{{ route('admin.quotations.index') }}">
              @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
              @endif
              <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search by quote number, customer name, email, or company..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                  <i class="fi fi-rr-search"></i> Search
                </button>
                @if(request('search'))
                  <a href="{{ route('admin.quotations.index', ['status' => request('status')]) }}"
                     class="btn btn-outline-secondary">
                    Clear
                  </a>
                @endif
              </div>
            </form>
          </div>
        </div>

        <!-- Quotations Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Quote #</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($quotations as $quotation)
                <tr>
                  <td>
                    <a href="{{ route('admin.quotations.show', $quotation) }}"
                       class="fw-bold text-primary">
                      {{ $quotation->quote_number }}
                    </a>
                  </td>
                  <td>
                    <div>
                      <strong>{{ $quotation->customer_name }}</strong><br>
                      <small class="text-muted">{{ $quotation->customer_email }}</small>
                      @if($quotation->customer_company)
                        <br><small class="text-muted">{{ $quotation->customer_company }}</small>
                      @endif
                    </div>
                  </td>
                  <td>
                    @if($quotation->items->count() > 0)
                      <span class="badge bg-info">{{ $quotation->items->count() }} item(s)</span>
                      <br>
                      <small class="text-muted">
                        {{ $quotation->items->first()->product_name ?? 'N/A' }}
                        @if($quotation->items->count() > 1)
                          +{{ $quotation->items->count() - 1 }} more
                        @endif
                      </small>
                    @else
                      <span class="text-muted">No items</span>
                    @endif
                  </td>
                  <td>
                    @if($quotation->total_amount > 0)
                      <strong>{{ $quotation->currency }} {{ number_format($quotation->total_amount, 2) }}</strong>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-{{
                      $quotation->status === 'new' ? 'secondary' :
                      ($quotation->status === 'pending' ? 'warning' :
                      ($quotation->status === 'quoted' ? 'primary' :
                      ($quotation->status === 'accepted' ? 'success' :
                      ($quotation->status === 'rejected' ? 'danger' : 'secondary'))))
                    }}">
                      {{ ucfirst($quotation->status) }}
                    </span>
                  </td>
                  <td>
                    <span data-bs-toggle="tooltip" title="{{ $quotation->created_at->format('M d, Y h:i A') }}">
                      {{ $quotation->created_at->diffForHumans() }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ route('admin.quotations.show', $quotation) }}"
                         class="btn btn-sm btn-primary"
                         data-bs-toggle="tooltip"
                         title="View Details">
                        <i class="fi fi-rr-eye"></i>
                      </a>
                      @if(auth()->user()->hasPermission('quotations.update'))
                        <form action="{{ route('admin.quotations.destroy', $quotation) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                                  class="btn btn-sm btn-danger"
                                  data-bs-toggle="tooltip"
                                  title="Delete">
                            <i class="fi fi-rr-trash"></i>
                          </button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    No quotations found.
                    @if(request('search'))
                      <br>Try adjusting your search terms.
                    @endif
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
          {{ $quotations->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
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

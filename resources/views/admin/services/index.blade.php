@extends('admin.layouts.app')

@section('title', 'Services')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <h4 class="page-title">Services</h4>
      <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="fi fi-rr-plus me-2"></i> Add Service
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th style="width: 40px">#</th>
                <th>Service</th>
                <th>Products</th>
                <th>Details</th>
                <th>Status</th>
                <th style="width: 160px">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($services as $service)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      @if($service->image)
                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                      @else
                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                          <i class="fi fi-rr-briefcase text-muted"></i>
                        </div>
                      @endif
                      <div>
                        <strong>{{ $service->name }}</strong>
                        @if($service->short_description)
                          <br><small class="text-muted">{{ Str::limit($service->short_description, 60) }}</small>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-info">{{ $service->products_count }}</span></td>
                  <td><span class="badge bg-secondary">{{ $service->details_count }}</span></td>
                  <td>
                    <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">
                      {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-light">
                      <i class="fi fi-rr-edit"></i>
                    </a>
                    @if($service->products_count === 0)
                      <form action="{{ route('admin.services.destroy', $service) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Delete this service?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fi fi-rr-trash"></i>
                        </button>
                      </form>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    No services yet. Click "Add Service" to create one.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

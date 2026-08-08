@extends('admin.layouts.app')

@section('title', 'Assigned Roles')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Assigned Roles</h4>
        <p class="text-muted mb-0">Functional roles that carry the permissions used for access control.</p>
      </div>
      @if(auth()->user()->hasPermission('assigned_roles.create'))
        <a href="{{ route('admin.assigned-roles.create') }}" class="btn btn-primary">
          <i class="fi fi-rr-plus me-2"></i> Add Assigned Role
        </a>
      @endif
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Role</th>
            <th>Description</th>
            <th>Permissions</th>
            <th>Users</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($assignedRoles as $assignedRole)
            <tr>
              <td>
                <div class="fw-semibold">{{ $assignedRole->label }}</div>
                <div class="text-muted small">{{ $assignedRole->name }}</div>
              </td>
              <td>{{ $assignedRole->description ?: '—' }}</td>
              <td>{{ $assignedRole->permissions_count }}</td>
              <td>{{ $assignedRole->users_count }}</td>
              <td>
                <span class="badge bg-{{ $assignedRole->is_active ? 'success' : 'secondary' }}">
                  {{ $assignedRole->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="text-end">
                @if(auth()->user()->hasPermission('assigned_roles.update') || auth()->user()->hasPermission('assigned_roles.assign_permissions'))
                  <a href="{{ route('admin.assigned-roles.edit', $assignedRole) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fi fi-rr-edit"></i>
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No assigned roles found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $assignedRoles->links() }}
    </div>
  </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">User Management</h4>
        <p class="text-muted mb-0">Manage internal accounts, base roles, and assigned operational roles.</p>
      </div>
      @if(auth()->user()->hasPermission('users.create'))
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
          <i class="fi fi-rr-plus me-2"></i> Add User
        </a>
      @endif
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 mb-4">
      <div class="col-md-5">
        <input type="text" name="search" class="form-control" placeholder="Search users by name, email, title, or department" value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <select name="role" class="form-select">
          <option value="">All base roles</option>
          @foreach(['super_admin' => 'Super Admin', 'admin' => 'Admin', 'user' => 'User'] as $value => $label)
            <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="fi fi-rr-search me-2"></i> Filter
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Name</th>
            <th>Base Role</th>
            <th>Assigned Roles</th>
            <th>Department</th>
            <th>Status</th>
            <th>Last Login</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td>
                <div class="fw-semibold">{{ $user->name }}</div>
                <div class="text-muted small">{{ $user->email }}</div>
                @if($user->job_title)
                  <div class="text-muted small">{{ $user->job_title }}</div>
                @endif
              </td>
              <td>
                <span class="badge bg-{{ $user->role === 'super_admin' ? 'danger' : ($user->role === 'admin' ? 'primary' : 'secondary') }}">
                  {{ str($user->role)->replace('_', ' ')->title() }}
                </span>
              </td>
              <td>
                @forelse($user->assignedRoles as $assignedRole)
                  <span class="badge bg-light text-dark border me-1 mb-1">{{ $assignedRole->label }}</span>
                @empty
                  <span class="text-muted">No assigned roles</span>
                @endforelse
              </td>
              <td>{{ $user->department ?? '—' }}</td>
              <td>
                <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                  {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>{{ $user->last_login_at?->format('M d, Y h:i A') ?? 'Never' }}</td>
              <td class="text-end">
                @if(auth()->user()->hasPermission('users.update') || auth()->user()->hasPermission('users.assign_roles'))
                  <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fi fi-rr-edit"></i>
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">No users found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection

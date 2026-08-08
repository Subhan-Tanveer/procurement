@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('breadcrumb')
  <li class="breadcrumb-item active" aria-current="page">My Profile</li>
@endsection

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <h4 class="page-title">My Profile</h4>
    <p class="text-muted mb-0">Manage your account details, security, and session access.</p>
  </div>
</div>

<div class="row g-4 mt-1">
  <div class="col-xl-8">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Account Details</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Full Name</label>
              <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control @error('name') is-invalid @enderror"
                required
              >
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror"
                required
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="phone_number" class="form-label">Phone Number</label>
              <input
                type="text"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number', $user->phone_number) }}"
                class="form-control @error('phone_number') is-invalid @enderror"
              >
              @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Position</label>
              <div class="form-control bg-light-subtle">{{ $user->job_title ?: '—' }}</div>
              <div class="form-text">Position is managed internally and is not editable here.</div>
            </div>

            <div class="col-md-6">
              <label for="department" class="form-label">Department</label>
              <input
                type="text"
                id="department"
                name="department"
                value="{{ old('department', $user->department) }}"
                class="form-control @error('department') is-invalid @enderror"
              >
              @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header">
        <h5 class="mb-0">Change Password</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.password.update') }}">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-12">
              <label for="current_password" class="form-label">Current Password</label>
              <input
                type="password"
                id="current_password"
                name="current_password"
                class="form-control @error('current_password') is-invalid @enderror"
                required
              >
              @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="password" class="form-label">New Password</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="password_confirmation" class="form-label">Confirm New Password</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
              >
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-outline-primary">Update Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Account Summary</h5>
      </div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-5 text-muted">Base Role</dt>
          <dd class="col-7">{{ str($user->role)->replace('_', ' ')->title() }}</dd>

          <dt class="col-5 text-muted">Status</dt>
          <dd class="col-7">
            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
              {{ $user->is_active ? 'Active' : 'Inactive' }}
            </span>
          </dd>

          <dt class="col-5 text-muted">Last Login</dt>
          <dd class="col-7">{{ $user->last_login_at?->format('M d, Y h:i A') ?? '—' }}</dd>
        </dl>

        <hr>

        <div class="mb-2 text-muted small">Assigned Roles</div>
        @if($user->assignedRoles->isNotEmpty())
          <div class="d-flex flex-wrap gap-2">
            @foreach($user->assignedRoles as $assignedRole)
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                {{ $assignedRole->label }}
              </span>
            @endforeach
          </div>
        @else
          <div class="text-muted small">No assigned operational roles.</div>
        @endif
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header">
        <h5 class="mb-0">Session</h5>
      </div>
      <div class="card-body">
        <p class="text-muted mb-3">Use this to end your current authenticated session.</p>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-danger w-100">
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

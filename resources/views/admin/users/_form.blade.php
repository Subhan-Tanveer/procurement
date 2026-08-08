<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Full Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Email Address</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Phone Number</label>
    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Base Role</label>
    <select name="role" class="form-select" required>
      @foreach(['super_admin' => 'Super Admin', 'admin' => 'Admin', 'user' => 'User'] as $value => $label)
        <option value="{{ $value }}" @selected(old('role', $user->role ?? 'user') === $value)>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Position</label>
    <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $user->job_title ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Department</label>
    <input type="text" name="department" class="form-control" value="{{ old('department', $user->department ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">{{ isset($user) ? 'New Password' : 'Password' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
  </div>
  <div class="col-md-6">
    <label class="form-label">{{ isset($user) ? 'Confirm New Password' : 'Confirm Password' }}</label>
    <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
  </div>
  <div class="col-12">
    <label class="form-label">Assigned Roles</label>
    <select name="assigned_roles[]" class="form-select" multiple size="6">
      @php
        $selectedAssignedRoles = old('assigned_roles', isset($user) ? $user->assignedRoles->pluck('id')->all() : []);
      @endphp
      @foreach($assignedRoles as $assignedRole)
        <option value="{{ $assignedRole->id }}" @selected(in_array($assignedRole->id, $selectedAssignedRoles))>
          {{ $assignedRole->label }}
        </option>
      @endforeach
    </select>
    <div class="form-text">Assigned roles carry the operational permissions for this user.</div>
  </div>
  <div class="col-12">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true))>
      <label class="form-check-label" for="is_active">Active account</label>
    </div>
  </div>
</div>

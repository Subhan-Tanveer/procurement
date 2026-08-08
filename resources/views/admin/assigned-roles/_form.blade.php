<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Role Key</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $assignedRole->name ?? '') }}" required>
    <div class="form-text">Use lowercase keys like `procurement_manager`.</div>
  </div>
  <div class="col-md-6">
    <label class="form-label">Role Label</label>
    <input type="text" name="label" class="form-control" value="{{ old('label', $assignedRole->label ?? '') }}" required>
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $assignedRole->description ?? '') }}</textarea>
  </div>
  <div class="col-12">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="assigned_role_active" name="is_active" value="1" @checked(old('is_active', $assignedRole->is_active ?? true))>
      <label class="form-check-label" for="assigned_role_active">Active assigned role</label>
    </div>
  </div>
  <div class="col-12">
    <label class="form-label">Permissions</label>
    @php
      $selectedPermissions = old('permissions', isset($assignedRole) ? $assignedRole->permissions->pluck('id')->all() : []);
    @endphp
    <div class="row g-3">
      @foreach($permissions as $group => $groupPermissions)
        <div class="col-lg-6">
          <div class="border rounded p-3 h-100">
            <div class="fw-semibold mb-3 text-capitalize">{{ str($group)->replace('_', ' ') }}</div>
            @foreach($groupPermissions as $permission)
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" @checked(in_array($permission->id, $selectedPermissions))>
                <label class="form-check-label" for="permission_{{ $permission->id }}">
                  {{ $permission->label }}
                </label>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

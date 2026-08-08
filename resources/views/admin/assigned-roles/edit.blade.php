@extends('admin.layouts.app')

@section('title', 'Edit Assigned Role')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Edit Assigned Role</h4>
        <p class="text-muted mb-0">Update {{ $assignedRole->label }} and adjust its permission scope.</p>
      </div>
      <a href="{{ route('admin.assigned-roles.index') }}" class="btn btn-outline-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back to Assigned Roles
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.assigned-roles.update', $assignedRole) }}" method="POST">
      @csrf
      @method('PUT')
      @include('admin.assigned-roles._form')
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.assigned-roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

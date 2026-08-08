@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Edit User</h4>
        <p class="text-muted mb-0">Update base role, assigned roles, and account status for {{ $user->name }}.</p>
      </div>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back to Users
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')
      @include('admin.users._form')
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

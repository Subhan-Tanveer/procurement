@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex justify-content-between align-items-center">
      <div>
        <h4 class="page-title">Create User</h4>
        <p class="text-muted mb-0">Create an account and attach the assigned roles that drive operational access.</p>
      </div>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fi fi-rr-arrow-left me-2"></i> Back to Users
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
      @include('admin.users._form')
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

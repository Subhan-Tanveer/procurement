<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Supplier Portal') - Good Procurement Service Ltd</title>
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;family=Nunito:wght@700;800&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-select/css/bootstrap-select.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
  @stack('styles')
  <style>
    :root {
      --gps-blue: #426693;
      --gps-green: #78B547;
      --gps-dark: #243746;
    }
    body { background: #f5f7fa; font-family: 'Roboto', sans-serif; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Nunito', sans-serif; }
    .sp-sidebar {
      width: 240px; min-height: 100vh; background: #fff;
      border-right: 1px solid #e9ecef; position: fixed; top: 0; left: 0;
      display: flex; flex-direction: column; z-index: 100;
    }
    .sp-brand { padding: 20px 24px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; gap: 10px; }
    .sp-brand img { height: 36px; width: auto; }
    .sp-brand .sp-brand-text { display: flex; flex-direction: column; line-height: 1; font-family: 'Nunito', sans-serif; font-weight: 800; }
    .sp-brand .sp-brand-text span:first-child { color: var(--gps-blue); font-size: 16px; }
    .sp-brand small { display: block; color: #78B547; font-size: 11px; font-weight: 600; letter-spacing: .5px; margin-top: 2px; }
    .sp-nav { padding: 16px 0; flex: 1; }
    .sp-nav a {
      display: flex; align-items: center; gap: 10px; padding: 10px 24px;
      color: #4a5568; text-decoration: none; font-size: 14px; border-left: 3px solid transparent;
      transition: all .15s;
    }
    .sp-nav a:hover, .sp-nav a.active {
      background: #f0f7ff; color: var(--gps-blue); border-left-color: var(--gps-blue);
    }
    .sp-nav a i { width: 18px; text-align: center; }
    .sp-nav .nav-section { padding: 8px 24px 4px; font-size: 10px; color: #a0aec0; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; }
    .sp-footer { padding: 16px 24px; border-top: 1px solid #e9ecef; }
    .sp-footer .user-name { font-size: 13px; font-weight: 600; color: var(--gps-dark); }
    .sp-footer .user-role { font-size: 11px; color: #78B547; font-weight: 600; }

    .sp-main { margin-left: 240px; min-height: 100vh; }
    .sp-topbar {
      background: #fff; border-bottom: 1px solid #e9ecef;
      padding: 0 32px; height: 60px; display: flex; align-items: center;
      justify-content: space-between; position: sticky; top: 0; z-index: 50;
    }
    .sp-topbar h4 { margin: 0; font-size: 16px; font-weight: 600; color: var(--gps-dark); }
    .sp-content { padding: 28px 32px; }

    .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .status-pending  { background: #fff8e1; color: #f59e0b; }
    .status-approved { background: #e8f5e9; color: #2e7d32; }
    .status-rejected { background: #fce4ec; color: #c62828; }
    .status-draft    { background: #f3f4f6; color: #6b7280; }

    .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .card-header { background: transparent; border-bottom: 1px solid #f0f0f0; padding: 16px 20px; font-weight: 600; }
    .btn-gps-primary { background: var(--gps-blue); color: #fff; border: none; }
    .btn-gps-primary:hover { background: #35547a; color: #fff; }
    .btn-gps-green { background: var(--gps-green); color: #fff; border: none; }
    .btn-gps-green:hover { background: #62963a; color: #fff; }

    @media (max-width: 768px) {
      .sp-sidebar { transform: translateX(-100%); }
      .sp-main { margin-left: 0; }
    }
  </style>
</head>
<body>

<div class="sp-sidebar">
  <div class="sp-brand">
    <img src="{{ asset('site/assets/images/gps-shield-icon.png') }}" alt="GPS">
    <div class="sp-brand-text">
      <span>GOOD PROCUREMENT</span>
      <small>SUPPLIER PORTAL</small>
    </div>
  </div>

  <nav class="sp-nav">
    <a href="{{ route('supplier.dashboard') }}" class="{{ request()->routeIs('supplier.dashboard') ? 'active' : '' }}">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="nav-section">Products</div>
    <a href="{{ route('supplier.products.index') }}" class="{{ request()->routeIs('supplier.products.*') ? 'active' : '' }}">
      <i class="fas fa-boxes"></i> My Products
    </a>
    <a href="{{ route('supplier.products.create') }}">
      <i class="fas fa-plus-circle"></i> Submit Product
    </a>

    <div class="nav-section">Media</div>
    <a href="#" onclick="openMediaLibrary()">
      <i class="fas fa-images"></i> Media Library
    </a>
  </nav>

  <div class="sp-footer">
    <div class="d-flex align-items-center gap-2 mb-2">
      <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
           style="width:32px;height:32px;font-size:13px;font-weight:700;">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      </div>
      <div>
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">Supplier</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
        <i class="fas fa-sign-out-alt me-1"></i> Logout
      </button>
    </form>
  </div>
</div>

<div class="sp-main">
  <div class="sp-topbar">
    <h4>@yield('page-title', 'Supplier Portal')</h4>
    <div class="d-flex align-items-center gap-3">
      @if(auth()->user()->supplierProfile)
        <span class="status-badge status-{{ auth()->user()->supplierProfile->status === 'approved' ? 'approved' : 'pending' }}">
          {{ ucfirst(str_replace('_', ' ', auth()->user()->supplierProfile->status)) }}
        </span>
        <span class="text-muted" style="font-size:13px;">
          {{ auth()->user()->supplierProfile->organization_name }}
        </span>
      @endif
    </div>
  </div>

  <div class="sp-content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')
  </div>
</div>

<script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>

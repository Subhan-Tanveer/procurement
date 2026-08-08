<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-color-theme="blue" data-app-sidebar="full">
<head>
  <meta charset="utf-8">
  <meta name="theme-color" content="#78B547">
  <meta name="robots" content="noindex, nofollow">
  <meta name="author" content="Good Procurement Service Ltd">
  <meta name="format-detection" content="telephone=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard') - Good Procurement Service Ltd</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script>
    document.documentElement.setAttribute('data-bs-theme', 'light');
    document.documentElement.setAttribute('data-color-theme', 'blue');
    document.documentElement.setAttribute('data-app-sidebar', 'full');
    document.cookie = 'theme=light; path=/; max-age=31536000';
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('site/assets/images/gps fav.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&amp;display=swap" rel="stylesheet">

  <!-- Required Stylesheets -->
  <link rel="stylesheet" href="{{ asset('admin/libs/flaticon/css/all/all.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/lucide/lucide.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/simplebar/simplebar.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/node-waves/waves.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-select/css/bootstrap-select.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/flatpickr/flatpickr.min.css') }}">
  <!-- DataTables CSS from CDN -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  @stack('styles')

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">

  <!-- Custom GPS Colors -->
  <style>
    :root {
      --bs-primary: #78B547 !important;
      --bs-primary-rgb: 120, 181, 71 !important;
      --bs-secondary: #426693 !important;
      --bs-secondary-rgb: 66, 102, 147 !important;
      --custom-body-bg: #f7fafc !important;
      --app-sidebar-bg: #ffffff !important;
      --app-header-bg: #ffffff !important;
    }
    html,
    body {
      background: #f7fafc !important;
      color: #243746 !important;
    }
    .page-layout,
    .app-wrapper {
      background: #f7fafc !important;
    }
    .app-header,
    .app-menubar-tabs,
    .app-menubar-tabs .app-tab-content,
    .app-menubar-tabs .app-side-brands,
    .app-menubar-tabs .app-navbar-brand {
      background: #ffffff !important;
    }
    .app-header,
    .app-menubar-tabs,
    .app-menubar-tabs .app-tab-content {
      box-shadow: none !important;
    }
    .app-header {
      border-bottom: 1px solid #e4ebf1 !important;
    }
    .app-menubar-tabs {
      border-right: 1px solid #e4ebf1 !important;
    }
    .app-menubar-tabs .side-menubar .menu-item .menu-link,
    .app-menubar-tabs .app-side-brands .navbar-brand-text,
    .app-header .breadcrumb-item,
    .app-header .breadcrumb-item a {
      color: #43576a !important;
    }
    .app-menubar-tabs .side-menubar .menu-item .menu-link.active,
    .app-menubar-tabs .side-menubar .menu-item .menu-link:hover,
    .app-navbar-tabs .nav-item .menu-link.active,
    .app-navbar-tabs .nav-item .menu-link:hover,
    .app-navbar-tabs .nav-item .menu-link:focus {
      background: #eef6e7 !important;
      color: #5f9a33 !important;
    }
    .app-menubar-tabs .side-menubar .menu-divider,
    .nav-item-hr {
      background: #e8eef3 !important;
    }
    .dropdown-menu {
      background: #ffffff !important;
      border-color: #e4ebf1 !important;
    }
    .btn-primary {
      background-color: #78B547 !important;
      border-color: #78B547 !important;
    }
    .btn-primary:hover {
      background-color: #6ba03e !important;
      border-color: #6ba03e !important;
    }
    .bg-primary {
      background-color: #78B547 !important;
    }
    .text-primary {
      color: #78B547 !important;
    }
    /* Fix card bottom spacing */
    .card {
      --bs-card-height: auto;
      height: auto;
      margin-bottom: 1rem;
    }
    .card-group {
      height: auto;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <div class="page-layout">

    @include('admin.partials.header')

    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="app-wrapper">
      <div class="container-fluid">
        @include('partials.flash', ['wrapClass' => 'gps-alert-wrap mb-3'])

        @yield('content')
      </div>
    </main>

  </div>

  @include('admin.partials.scripts')
</body>
</html>

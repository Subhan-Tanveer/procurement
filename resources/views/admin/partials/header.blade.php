<!-- begin::Admin Header -->
<header class="app-header">
  <div class="app-header-inner">
    <button class="app-toggler" type="button" aria-label="app toggler">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.66699 12.6668L3.66699 8.00016L7.66699 3.3335" stroke="#1C274C" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
        <path opacity="0.5" d="M12.667 12.6668L8.66699 8.00016L12.667 3.3335" stroke="#1C274C" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>
    <div class="app-header-start d-none d-md-flex">
      <div class="badge-standard d-none d-lg-inline-block">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @yield('breadcrumb')
          </ol>
        </nav>
      </div>
    </div>
    <div class="app-header-end">
      <!-- Quick Actions -->
      <div class="px-lg-4 px-2 ps-0 d-flex align-items-center gap-2">
        @if(auth()->user()->hasPermission('products.manage'))
          <a href="{{ route('admin.products.create') }}"
             class="btn btn-sm btn-outline-primary d-none d-lg-inline-flex"
             data-bs-toggle="tooltip"
             title="Add New Product">
            <i class="fi fi-rr-plus me-1"></i> New Product
          </a>
        @endif
        <a href="{{ route('home') }}"
           class="btn btn-sm btn-primary"
           target="_blank"
           data-bs-toggle="tooltip"
           title="View live website">
          <i class="fi fi-rr-globe"></i>
          <span class="d-none d-md-inline ms-1">View Site</span>
        </a>
      </div>
      <div class="vr my-3 d-none d-md-block"></div>

      <!-- User Dropdown -->
      <div class="dropdown text-end ms-sm-3 ms-2 ms-lg-4">
        <a href="#" class="d-flex align-items-center py-2" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <div class="text-end me-2 d-none d-lg-inline-block">
            <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
            <small class="text-body d-block lh-sm">
              <i class="fi fi-rr-angle-down text-3xs me-1"></i> {{ str(auth()->user()->role)->replace('_', ' ')->title() }}
            </small>
          </div>
          <div class="avatar avatar-sm rounded-circle bg-primary text-white fw-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end w-225px mt-2 shadow-sm">
          <li>
            <div class="dropdown-header">
              <div class="fw-bold">{{ auth()->user()->name }}</div>
              <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="fi fi-rr-user me-2"></i> My Profile</a></li>
          <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="fi fi-rr-settings me-2"></i> Account Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="fi fi-rr-sign-out me-2"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>
<!-- end::Admin Header -->

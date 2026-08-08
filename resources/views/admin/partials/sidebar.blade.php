@php
  // Determine active tab based on current route
  $activeTab = 'dashboard';
  if (request()->routeIs('admin.products.*') || request()->routeIs('admin.product-pages.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.services.*') || request()->routeIs('admin.marketing-templates.*')) {
    $activeTab = 'products';
  } elseif (request()->routeIs('admin.quotations.*') || request()->routeIs('admin.orders.*')) {
    $activeTab = 'quotations';
  } elseif (request()->routeIs('admin.suppliers.*') || request()->routeIs('admin.supplier-applications.*') || request()->routeIs('admin.supplier-products.*')) {
    $activeTab = 'suppliers';
  } elseif (request()->routeIs('admin.settings.*') || request()->routeIs('admin.users.*') || request()->routeIs('admin.assigned-roles.*')) {
    $activeTab = 'settings';
  }
  $adminUser = auth()->user();
  $canViewDashboard = $adminUser->hasPermission('dashboard.view');
  $canViewProductsTab = $adminUser->hasPermission('products.manage')
    || $adminUser->hasPermission('product_pages.manage')
    || $adminUser->hasPermission('marketing_templates.manage')
    || $adminUser->hasPermission('categories.manage')
    || $adminUser->hasPermission('services.manage');
  $canViewQuotationsTab = $adminUser->hasPermission('quotations.view')
    || $adminUser->hasPermission('orders.view');
  $canViewSuppliersTab = $adminUser->hasPermission('suppliers.view')
    || $adminUser->hasPermission('suppliers.manage')
    || $adminUser->hasPermission('supplier_products.approve');
  $canViewSettingsTab = $adminUser->hasPermission('users.view')
    || $adminUser->hasPermission('assigned_roles.view');
  $openSupplierApplications = $canViewSuppliersTab
    ? \App\Models\SupplierApplication::whereIn('status', ['submitted', 'under_review', 'changes_requested'])->count()
    : 0;
  $submittedSupplierApplications = $canViewSuppliersTab
    ? \App\Models\SupplierApplication::where('status', 'submitted')->count()
    : 0;
  $approvedSuppliers = $canViewSuppliersTab
    ? \App\Models\SupplierProfile::where('status', 'approved')->count()
    : 0;
@endphp

<!-- begin::Admin Sidebar -->
<aside class="app-menubar-tabs" id="appMenubar">
  <div class="app-navbar-brand">
    <a class="navbar-brand-logo" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('site/assets/images/gps fav.png') }}" alt="GPS Admin" style="max-height: 40px;">
    </a>
  </div>
  <div class="app-navbar-tabs" data-simplebar>
    <ul class="nav" id="appMenubarTabs" role="tablist" aria-orientation="vertical">
      <!-- Dashboard Tab Icon -->
      @if($canViewDashboard)
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
          <a class="menu-link {{ $activeTab === 'dashboard' ? 'active' : '' }}" href="#dashboardTab" role="tab" aria-controls="dashboardTab" aria-selected="{{ $activeTab === 'dashboard' ? 'true' : 'false' }}" data-bs-toggle="tab">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" stroke="var(--bs-heading-color)" stroke-width="2" />
              <path d="M12 15V18" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
            </svg>
          </a>
        </li>
      @endif

      <!-- Products Tab Icon -->
      @if($canViewProductsTab)
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Products">
          <a class="menu-link {{ $activeTab === 'products' ? 'active' : '' }}" href="#productsTab" role="tab" aria-controls="productsTab" aria-selected="{{ $activeTab === 'products' ? 'true' : 'false' }}" data-bs-toggle="tab">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3.06164 15.1933L3.42688 13.1219C3.85856 10.6736 4.0744 9.44952 4.92914 8.72476C5.78389 8 7.01171 8 9.46734 8H14.5327C16.9883 8 18.2161 8 19.0709 8.72476C19.9256 9.44952 20.1414 10.6736 20.5731 13.1219L20.9384 15.1933C21.5357 18.5811 21.8344 20.275 20.9147 21.3875C19.995 22.5 18.2959 22.5 14.8979 22.5H9.1021C5.70406 22.5 4.00504 22.5 3.08533 21.3875C2.16562 20.275 2.4643 18.5811 3.06164 15.1933Z" stroke="var(--bs-heading-color)" stroke-width="2" />
              <path opacity="0.5" d="M7.5 8L7.66782 5.98618C7.85558 3.73306 9.73907 2 12 2C14.2609 2 16.1444 3.73306 16.3322 5.98618L16.5 8" stroke="var(--bs-heading-color)" stroke-width="2" />
              <path opacity="0.5" d="M15 11C14.87 12.4131 13.5657 13.5 12 13.5C10.4343 13.5 9.13002 12.4131 9 11" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
            </svg>
          </a>
        </li>
      @endif

      <!-- Quotations Tab Icon -->
      @if($canViewQuotationsTab)
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Quotations">
          <a class="menu-link {{ $activeTab === 'quotations' ? 'active' : '' }}" href="#quotationsTab" role="tab" aria-controls="quotationsTab" aria-selected="{{ $activeTab === 'quotations' ? 'true' : 'false' }}" data-bs-toggle="tab">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path opacity="0.5" d="M16 4.00195C18.175 4.01406 19.3529 4.11051 20.1213 4.87889C21 5.75757 21 7.17179 21 10.0002V16.0002C21 18.8286 21 20.2429 20.1213 21.1215C19.2426 22.0002 17.8284 22.0002 15 22.0002H9C6.17157 22.0002 4.75736 22.0002 3.87868 21.1215C3 20.2429 3 18.8286 3 16.0002V10.0002C3 7.17179 3 5.75757 3.87868 4.87889C4.64706 4.11051 5.82497 4.01406 8 4.00195" stroke="var(--bs-heading-color)" stroke-width="2" />
              <path d="M7 14.5H15" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
              <path opacity="0.5" d="M7 18H12.5" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
              <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" stroke="var(--bs-heading-color)" stroke-width="2" />
            </svg>
          </a>
        </li>
      @endif

      <!-- Suppliers Tab Icon -->
      @if($canViewSuppliersTab)
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Suppliers">
          <a class="menu-link {{ $activeTab === 'suppliers' ? 'active' : '' }}" href="#suppliersTab" role="tab" aria-controls="suppliersTab" aria-selected="{{ $activeTab === 'suppliers' ? 'true' : 'false' }}" data-bs-toggle="tab">
            <span class="position-relative">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 6a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3V6z" stroke="var(--bs-heading-color)" stroke-width="2"/>
                <path opacity="0.5" d="M3 15a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3v-2z" stroke="var(--bs-heading-color)" stroke-width="2"/>
              </svg>
              @if($openSupplierApplications > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:9px;">
                  {{ $openSupplierApplications }}
                </span>
              @endif
            </span>
          </a>
        </li>
      @endif

      <li class="nav-item-hr"></li>

      <!-- Settings Tab Icon -->
      @if($canViewSettingsTab)
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings">
          <a class="menu-link {{ $activeTab === 'settings' ? 'active' : '' }}" href="#settingsTab" role="tab" aria-controls="settingsTab" aria-selected="{{ $activeTab === 'settings' ? 'true' : 'false' }}" data-bs-toggle="tab">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path opacity="0.5" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" stroke="var(--bs-heading-color)" stroke-width="2" />
            </svg>
          </a>
        </li>
      @endif
    </ul>
  </div>
  <div class="app-tab-content">
    <div class="app-side-brands">
      <a class="navbar-brand-text" href="{{ route('admin.dashboard') }}">GPS Admin</a>
    </div>
    <div class="app-content-inner">
      <div class="tab-content" id="appMenubarTabsContent">
        <!-- Dashboard Tab Panel -->
        @if($canViewDashboard)
        <div class="tab-pane fade {{ $activeTab === 'dashboard' ? 'show active' : '' }}" id="dashboardTab" role="tabpanel" tabindex="0">
          <nav class="app-navbar" data-simplebar>
            <ul class="side-menubar">
              <li class="menu-heading">
                <span class="menu-label">Dashboard</span>
              </li>
              <li class="menu-item">
                <a class="menu-link" href="{{ route('admin.dashboard') }}" role="button">
                  <i class="fi fi-rr-house-blank"></i>
                  <span class="menu-label">Overview</span>
                </a>
              </li>
              @if($adminUser->hasPermission('dashboard.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.dashboard.sales') }}" role="button">
                    <i class="fi fi-rr-percent-100"></i>
                    <span class="menu-label">Sales Dashboard</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.dashboard.finance') }}" role="button">
                    <i class="fi fi-rr-growth-chart-invest"></i>
                    <span class="menu-label">Finance Dashboard</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif

        <!-- Products Tab Panel -->
        @if($canViewProductsTab)
        <div class="tab-pane fade {{ $activeTab === 'products' ? 'show active' : '' }}" id="productsTab" role="tabpanel" tabindex="0">
          <nav class="app-navbar" data-simplebar>
            <ul class="side-menubar">
              <li class="menu-heading">
                <span class="menu-label">Products</span>
              </li>
              @if($adminUser->hasPermission('products.manage'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.products.index') }}" role="button">
                    <i class="fi fi-rr-list"></i>
                    <span class="menu-label">All Products</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.products.create') }}" role="button">
                    <i class="fi fi-rr-plus"></i>
                    <span class="menu-label">Add New Product</span>
                  </a>
                </li>
              @endif
              <li>
                <div class="menu-divider"></div>
              </li>
              <li class="menu-heading">
                <span class="menu-label">Page Builder</span>
              </li>
              @if($adminUser->hasPermission('product_pages.manage'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.product-pages.index') }}" role="button">
                    <i class="fi fi-rr-layout-fluid"></i>
                    <span class="menu-label">Build Product Pages</span>
                    <span class="badge badge-sm bg-primary-subtle text-primary">New</span>
                  </a>
                </li>
              @endif
              <li>
                <div class="menu-divider"></div>
              </li>
              <li class="menu-heading">
                <span class="menu-label">Marketing</span>
              </li>
              @if($adminUser->hasPermission('marketing_templates.manage'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.marketing-templates.index') }}" role="button">
                    <i class="fi fi-rr-megaphone"></i>
                    <span class="menu-label">Templates</span>
                  </a>
                </li>
              @endif
              <li>
                <div class="menu-divider"></div>
              </li>
              <li class="menu-heading">
                <span class="menu-label">Organization</span>
              </li>
              @if($adminUser->hasPermission('categories.manage'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.categories.index') }}" role="button">
                    <i class="fi fi-rr-folder"></i>
                    <span class="menu-label">Categories</span>
                  </a>
                </li>
              @endif
              @if($adminUser->hasPermission('services.manage'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.services.index') }}" role="button">
                    <i class="fi fi-rr-briefcase"></i>
                    <span class="menu-label">Services</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif

        <!-- Quotations Tab Panel -->
        @if($canViewQuotationsTab)
        <div class="tab-pane fade {{ $activeTab === 'quotations' ? 'show active' : '' }}" id="quotationsTab" role="tabpanel" tabindex="0">
          <nav class="app-navbar" data-simplebar>
            <ul class="side-menubar">
              <li class="menu-heading">
                <span class="menu-label">Quotations</span>
              </li>
              @if($adminUser->hasPermission('quotations.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.quotations.index') }}" role="button">
                    <i class="fi fi-rr-list"></i>
                    <span class="menu-label">All Quotations</span>
                  </a>
                </li>
              @endif
              @if($adminUser->hasPermission('orders.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.orders.index') }}" role="button">
                    <i class="fi fi-rr-box"></i>
                    <span class="menu-label">Orders</span>
                  </a>
                </li>
              @endif
              <li>
                <div class="menu-divider"></div>
              </li>
              <li class="menu-heading">
                <span class="menu-label">By Status</span>
              </li>
              @if($adminUser->hasPermission('quotations.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.quotations.index', ['status' => 'pending']) }}" role="button">
                    <i class="fi fi-rr-time-fast"></i>
                    <span class="menu-label">Pending</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.quotations.index', ['status' => 'quoted']) }}" role="button">
                    <i class="fi fi-rr-document"></i>
                    <span class="menu-label">Quoted</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif

        <!-- Suppliers Tab Panel -->
        @if($canViewSuppliersTab)
        <div class="tab-pane fade {{ $activeTab === 'suppliers' ? 'show active' : '' }}" id="suppliersTab" role="tabpanel" tabindex="0">
          <nav class="app-navbar" data-simplebar>
            <ul class="side-menubar">
              <li class="menu-heading"><span class="menu-label">Supplier Intake</span></li>
              @if($adminUser->hasPermission('suppliers.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.supplier-applications.index') }}" role="button">
                    <i class="fi fi-rr-file-check"></i>
                    <span class="menu-label">Applications</span>
                    @if($openSupplierApplications > 0)
                      <span class="badge bg-danger ms-auto">{{ $openSupplierApplications }}</span>
                    @endif
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.supplier-applications.index', ['status' => 'submitted']) }}" role="button">
                    <i class="fi fi-rr-time-fast"></i>
                    <span class="menu-label">New Submissions</span>
                    @if($submittedSupplierApplications > 0)
                      <span class="badge bg-warning text-dark ms-auto">{{ $submittedSupplierApplications }}</span>
                    @endif
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.supplier-applications.index', ['status' => 'under_review']) }}" role="button">
                    <i class="fi fi-rr-search"></i>
                    <span class="menu-label">Under Review</span>
                  </a>
                </li>
              @endif
              @if($adminUser->hasPermission('suppliers.view'))
                <li>
                  <div class="menu-divider"></div>
                </li>
                <li class="menu-heading"><span class="menu-label">Approved Suppliers</span></li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.suppliers.index') }}" role="button">
                    <i class="fi fi-rr-shop"></i>
                    <span class="menu-label">Supplier Directory</span>
                    @if($approvedSuppliers > 0)
                      <span class="badge bg-success ms-auto">{{ $approvedSuppliers }}</span>
                    @endif
                  </a>
                </li>
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.suppliers.index', ['status' => 'approved']) }}" role="button">
                    <i class="fi fi-rr-check"></i>
                    <span class="menu-label">Approved Profiles</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif

        <!-- Settings Tab Panel -->
        @if($canViewSettingsTab)
        <div class="tab-pane fade {{ $activeTab === 'settings' ? 'show active' : '' }}" id="settingsTab" role="tabpanel" tabindex="0">
          <nav class="app-navbar" data-simplebar>
            <ul class="side-menubar">
              <li class="menu-heading">
                <span class="menu-label">Settings</span>
              </li>
              @if($adminUser->hasPermission('users.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.users.index') }}" role="button">
                    <i class="fi fi-rr-users"></i>
                    <span class="menu-label">Users</span>
                  </a>
                </li>
              @endif
              @if($adminUser->hasPermission('assigned_roles.view'))
                <li class="menu-item">
                  <a class="menu-link" href="{{ route('admin.assigned-roles.index') }}" role="button">
                    <i class="fi fi-rr-shield-check"></i>
                    <span class="menu-label">Assigned Roles</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif
      </div>
    </div>
  </div>
</aside>
<!-- end::Admin Sidebar -->

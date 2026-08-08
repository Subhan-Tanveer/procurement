@extends('admin.layouts.app')

@section('title', 'Sales Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Sales</li>
@endsection

@section('content')
@php
  $currency = $stats['currency'];
  $currencyPrefix = $currency === 'NGN' ? '₦' : $currency . ' ';
  $formatMoney = function ($amount) use ($currencyPrefix, $currency) {
    $formatted = number_format((float) $amount, 2);

    return $currency === 'NGN'
      ? $currencyPrefix . $formatted
      : $currencyPrefix . $formatted;
  };
  $orderStatusColors = [
    'created' => 'secondary',
    'confirmed' => 'info',
    'processing' => 'primary',
    'dispatched' => 'warning',
    'delivered' => 'success',
    'cancelled' => 'danger',
  ];
@endphp
@push('styles')
<style>
  .dashboard-page { padding-bottom: 1.5rem; }
  .dashboard-page .row {
    --bs-gutter-x: 1.4rem;
    --bs-gutter-y: 1.4rem;
  }
  .dashboard-metric-block { min-width: 0; flex: 1 1 auto; }
  .dashboard-amount {
    display: block;
    max-width: 100%;
    font-size: clamp(.82rem, .55rem + .7vw, 1.35rem);
    line-height: 1.15;
    letter-spacing: -0.02em;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
  .dashboard-amount-sm {
    display: block;
    max-width: 100%;
    font-size: clamp(.78rem, .52rem + .55vw, 1.05rem);
    line-height: 1.15;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
  .dashboard-stat-card,
  .dashboard-summary-card,
  .dashboard-table-card {
    height: 100%;
    border-radius: 1rem;
  }
  .dashboard-stat-card .card-header {
    padding: 1.2rem 1.25rem 0;
  }
  .dashboard-stat-card .card-body {
    padding: .95rem 1.25rem 1.25rem;
    gap: .9rem;
  }
  .dashboard-summary-card .card-header,
  .dashboard-table-card .card-header {
    padding: 1.25rem 1.25rem .5rem;
  }
  .dashboard-summary-card .card-body,
  .dashboard-summary-card .card-footer,
  .dashboard-table-card .card-body {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
  }
  .dashboard-summary-card .card-body {
    padding-top: 1rem;
    padding-bottom: 1.25rem;
  }
  .dashboard-summary-card .card-footer {
    padding-top: 1rem;
    padding-bottom: 1.25rem;
  }
  .dashboard-stat-card .card-body,
  .dashboard-stat-card .card-footer,
  .dashboard-summary-card .card-body,
  .dashboard-summary-card .card-footer,
  .dashboard-table-card .card-body {
    overflow: hidden;
  }
  .dashboard-chart-compact {
    min-height: 0;
    margin-top: 1rem;
  }
  .dashboard-chart-roomy {
    margin-top: 1.25rem;
  }
  .dashboard-kpi-strip {
    gap: 2.5rem;
    margin-bottom: .25rem;
  }
  .dashboard-kpi-item {
    min-width: 180px;
  }
  .dashboard-target-chart-wrap {
    padding-top: .25rem;
  }
  .dashboard-target-caption {
    margin-top: .6rem;
    text-align: center;
  }
  .dashboard-list-card {
    padding: 1.2rem;
    border: 1px solid var(--bs-border-color);
    border-radius: .9rem;
    height: 100%;
  }
  .dashboard-category-card {
    min-height: 112px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .dashboard-category-grid {
    row-gap: 1rem;
  }
  .dashboard-category-total {
    margin-bottom: 1rem;
  }
  .dashboard-category-scroll {
    max-height: 32rem;
    overflow-y: auto;
    padding-right: .35rem;
  }
  .dashboard-table-card .card-body {
    padding-top: .85rem;
    padding-bottom: 1rem;
  }
  .dashboard-table-card table th,
  .dashboard-table-card table td {
    padding-top: .85rem;
    padding-bottom: .85rem;
    vertical-align: middle;
  }
</style>
@endpush
<div class="container-fluid dashboard-page">
  <div class="row">

    <div class="col-lg-3 col-sm-6">
      <div class="card dashboard-stat-card">
        <div class="card-header pb-0 border-0">
          <div class="avatar bg-primary-subtle text-primary rounded-circle">
            <i class="fi fi-rr-wallet"></i>
          </div>
        </div>
        <div class="card-body d-flex align-items-center">
          <div class="clearfix me-auto dashboard-metric-block">
            <p class="mb-1">Collected Revenue</p>
            <h2 class="mb-0 dashboard-amount">{{ $formatMoney($stats['total_earning']) }}</h2>
          </div>
          <span class="badge {{ $stats['total_earning_change'] >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
            {{ $stats['total_earning_change'] >= 0 ? '+' : '' }}{{ number_format($stats['total_earning_change'], 1) }}%
          </span>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-sm-6">
      <div class="card dashboard-stat-card">
        <div class="card-header pb-0 border-0">
          <div class="avatar bg-success-subtle text-success rounded-circle">
            <i class="fi fi-rr-shopping-cart"></i>
          </div>
        </div>
        <div class="card-body d-flex align-items-center">
          <div class="clearfix me-auto dashboard-metric-block">
            <p class="mb-1">Total Orders</p>
            <h2 class="mb-0 dashboard-amount">{{ number_format($stats['total_orders']) }}</h2>
          </div>
          <span class="badge {{ $stats['total_orders_change'] >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
            {{ $stats['total_orders_change'] >= 0 ? '+' : '' }}{{ number_format($stats['total_orders_change'], 1) }}%
          </span>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-sm-6">
      <div class="card dashboard-stat-card">
        <div class="card-header pb-0 border-0">
          <div class="avatar bg-warning-subtle text-warning rounded-circle">
            <i class="fi fi-rr-chart-histogram"></i>
          </div>
        </div>
        <div class="card-body d-flex align-items-center">
          <div class="clearfix me-auto dashboard-metric-block">
            <p class="mb-1">Revenue Growth</p>
            <h2 class="mb-0 dashboard-amount">{{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 1) }}%</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-sm-6">
      <div class="card dashboard-stat-card">
        <div class="card-header pb-0 border-0">
          <div class="avatar bg-danger-subtle text-danger rounded-circle">
            <i class="fi fi-rr-bullseye-arrow"></i>
          </div>
        </div>
        <div class="card-body d-flex align-items-center">
          <div class="clearfix me-auto dashboard-metric-block">
            <p class="mb-1">Quote to Order Rate</p>
            <h2 class="mb-0 dashboard-amount">{{ number_format($stats['conversion_rate'], 1) }}%</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="card dashboard-summary-card">
        <div class="card-header d-flex align-items-center justify-content-between border-0 pb-0">
          <h6 class="card-title mb-0">Order Pipeline</h6>
        </div>
        <div class="card-body pt-3 pb-4">
          <h2 class="mb-0 dashboard-amount">{{ number_format($stats['total_orders']) }}</h2>
          <div id="VisitorsChart" class="dashboard-chart-compact dashboard-chart-roomy"></div>
        </div>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="card dashboard-summary-card">
        <div class="card-header d-flex align-items-center justify-content-between border-0 pb-0">
          <h6 class="card-title mb-0">Weekly Collections</h6>
        </div>
        <div class="card-body pt-3 pb-4">
          <h2 class="mb-0">{{ $stats['month_collected_change'] >= 0 ? '+' : '' }}{{ number_format($stats['month_collected_change'], 1) }}%</h2>
          <div id="SalesGrowthChart" class="dashboard-chart-compact dashboard-chart-roomy"></div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card dashboard-summary-card">
        <div class="card-header pb-0 border-0 d-flex flex-wrap gap-2 align-items-center justify-content-between">
          <h6 class="card-title mb-0">Sales Report</h6>
          <ul class="nav nav-pills nav-pills-custom nav-fill p-1 bg-light rounded-5" id="chartRevenueTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link rounded-5" id="todayRevenueTab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" tabindex="-1">
                Today
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link rounded-5" id="weekRevenueTab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" tabindex="-1">
                Week
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link active rounded-5" id="monthRevenueTab" data-bs-toggle="tab" type="button" role="tab" aria-selected="true">
                Month
              </button>
            </li>
          </ul>
        </div>
        <div class="card-body pb-4">
          <div class="d-flex flex-wrap dashboard-kpi-strip">
            <div class="mb-2 dashboard-kpi-item">
              <h2 class="mb-0 dashboard-amount">{{ $formatMoney($stats['avg_income']) }}</h2>
              Average Collected Invoice
              <span class="badge badge-sm {{ $stats['avg_income_change'] >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} ms-1">
                {{ $stats['avg_income_change'] >= 0 ? '+' : '' }}{{ number_format($stats['avg_income_change'], 1) }}%
              </span>
            </div>
            <div class="mb-2 dashboard-kpi-item">
              <h2 class="mb-0 dashboard-amount">{{ $formatMoney($stats['avg_order_value']) }}</h2>
              Average Order Value
            </div>
          </div>
          <div id="SalesChart" class="dashboard-chart-compact dashboard-chart-roomy"></div>
        </div>
      </div>
    </div>

    <div class="col-xxl-4 col-lg-5 col-md-6">
      <div class="card overflow-hidden dashboard-summary-card">
        <div class="card-header pb-0 border-0">
          <h6 class="card-title mb-0">Monthly Target</h6>
        </div>
        <div class="card-body border-light border-bottom">
          <div class="dashboard-target-chart-wrap">
            <div id="MonthlyTargetChart" class="dashboard-chart-compact dashboard-chart-roomy"></div>
            <div class="dashboard-target-caption dashboard-amount-sm">{{ $formatMoney($stats['monthly_target_amount']) }} target</div>
          </div>
        </div>
        <div class="card-footer border-0">
          <h6 class="card-title mb-3">Invoice Status</h6>
          <div class="progress-stacked bg-transparent mb-4">
            <div class="progress bg-transparent" role="progressbar" aria-valuenow="{{ $stats['monthly_paid_percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $stats['monthly_paid_percent'] }}%">
              <div class="progress-bar bg-primary"></div>
            </div>
            <div class="progress bg-transparent" role="progressbar" aria-valuenow="{{ $stats['monthly_unpaid_percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $stats['monthly_unpaid_percent'] }}%">
              <div class="progress-bar bg-primary bg-opacity-75"></div>
            </div>
            <div class="progress bg-transparent" role="progressbar" aria-valuenow="{{ $stats['monthly_rejected_percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $stats['monthly_rejected_percent'] }}%">
              <div class="progress-bar bg-primary bg-opacity-50"></div>
            </div>
          </div>
          <div class="d-grid gap-1">
            <div class="d-flex gap-1 align-items-center py-1 mx-1">
              <i class="fa fa-square text-primary me-1"></i>
              Paid
              <strong class="text-dark fw-semibold ms-auto">{{ number_format($stats['monthly_paid_percent'], 1) }}%</strong>
            </div>
            <div class="d-flex gap-1 align-items-center py-1 mx-1">
              <i class="fa fa-square text-primary text-opacity-75 me-1"></i>
              Accepted / Unpaid
              <strong class="text-dark fw-semibold ms-auto">{{ number_format($stats['monthly_unpaid_percent'], 1) }}%</strong>
            </div>
            <div class="d-flex gap-1 align-items-center py-1 mx-1">
              <i class="fa fa-square text-primary text-opacity-50 me-1"></i>
              Rejected
              <strong class="text-dark fw-semibold ms-auto">{{ number_format($stats['monthly_rejected_percent'], 1) }}%</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xxl-8 col-lg-7 col-md-6">
      <div class="card dashboard-summary-card">
        <div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
          <h6 class="card-title mb-0">Sales by Category</h6>
        </div>
        <div class="card-body pt-2">
          <div class="d-flex gap-2 align-items-center dashboard-category-total">
            <h2 class="mb-0 dashboard-amount">{{ $formatMoney(collect($salesByCategory)->sum('value')) }}</h2>
            <span>accepted and paid pipeline</span>
          </div>
          <div class="dashboard-category-scroll">
            <div class="row g-3 dashboard-category-grid">
              @forelse($salesByCategory as $category)
                <div class="col-xxl-12 col-lg-6 col-md-12 col-sm-6">
                  <div class="dashboard-list-card dashboard-category-card">
                    <div class="d-flex align-items-center mb-2">
                      <div class="avatar rounded-circle avatar-xxs me-2 bg-primary-subtle text-primary fw-semibold d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($category['name'], 0, 1)) }}
                      </div>
                      <h5 class="mb-0">{{ $category['name'] }}</h5>
                    </div>
                    <h5 class="mb-0 dashboard-amount-sm">{{ $formatMoney($category['value']) }} <span class="text-2xs text-body ms-1">{{ number_format($category['count']) }} UNITS</span></h5>
                  </div>
                </div>
              @empty
                <div class="col-12">
                  <div class="dashboard-list-card text-muted">No category sales data yet.</div>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card overflow-hidden dashboard-table-card">
        <div class="card-header d-flex flex-wrap gap-3 align-items-center justify-content-between border-0 pb-0">
          <h6 class="card-title mb-0">Recent Sales</h6>
          <div class="d-flex">
            <div id="dt_RecentSales_Search"></div>
          </div>
        </div>
        <div class="card-body">
          <table id="dt_RecentSales" class="table table-sm display table-row-rounded data-row-checkbox">
            <thead class="table-light">
              <tr>
                <th class="pe-0">
                  <div class="form-check">
                    <input class="form-check-input" data-row-checkbox type="checkbox">
                  </div>
                </th>
                <th class="minw-100px">Order ID</th>
                <th class="minw-200px">Customer Name</th>
                <th class="minw-200px">Products</th>
                <th class="minw-100px">Amount</th>
                <th class="minw-100px">Payment</th>
                <th class="minw-100px">Status</th>
                <th class="minw-100px">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentSales as $order)
                <tr>
                  <td class="pe-0">
                    <div class="form-check p-0 w-auto d-inline-block mb-0 mb-n1">
                      <input class="form-check-input m-0" data-checkbox type="checkbox">
                    </div>
                  </td>
                  <td>{{ $order->order_number }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-xxs rounded-circle me-2 bg-primary-subtle text-primary fw-semibold d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                      </div>
                      {{ $order->customer_name }}
                    </div>
                  </td>
                  <td>{{ $order->items->pluck('product_name')->filter()->take(2)->implode(', ') ?: '—' }}</td>
                  <td>{{ ($order->currency === 'NGN' ? '₦' : $order->currency . ' ') . number_format($order->total_amount, 2) }}</td>
                  <td>{{ $order->quotation?->paid_at ? 'Paid' : 'Unpaid' }}</td>
                  <td>
                    <span class="badge badge-lg bg-{{ $orderStatusColors[$order->status] ?? 'secondary' }}-subtle text-{{ $orderStatusColors[$order->status] ?? 'secondary' }}">
                      {{ str($order->status)->replace('_', ' ')->title() }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">Open</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">No sales records found yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card overflow-hidden dashboard-table-card">
        <div class="card-header d-flex flex-wrap gap-2 align-items-center justify-content-between border-0 pb-0">
          <h6 class="card-title mb-0">Top Selling Items</h6>
          <div id="dt_TopSellingItems_Search"></div>
        </div>
        <div class="card-body">
          <table id="dt_TopSellingItems" class="table table-sm table-row-rounded display">
            <thead class="table-light">
              <tr>
                <th class="minw-100px">Product</th>
                <th class="minw-100px">Units Sold</th>
                <th class="minw-100px">Average Price</th>
                <th class="minw-100px">Total Sale</th>
                <th class="minw-100px">Stock</th>
                <th class="minw-100px">Status</th>
                <th class="minw-100px">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($topSellingItems as $item)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-xxs rounded-circle me-2 bg-primary-subtle text-primary fw-semibold d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($item['product_name'], 0, 1)) }}
                      </div>
                      {{ $item['product_name'] }}
                    </div>
                  </td>
                  <td>{{ number_format($item['quantity']) }}</td>
                  <td>{{ $formatMoney($item['unit_price']) }}</td>
                  <td>{{ $formatMoney($item['total_sales']) }}</td>
                  <td>{{ str($item['stock_status'])->replace('_', ' ')->title() }}</td>
                  <td>
                    <span class="badge badge-lg {{ $item['is_active'] ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                      {{ $item['is_active'] ? 'Active' : 'Draft' }}
                    </span>
                  </td>
                  <td>
                    @if($item['product'])
                      <a href="{{ route('admin.products.edit', $item['product']) }}" class="btn btn-sm btn-outline-secondary">Open</a>
                    @else
                      <span class="text-muted small">No product link</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">No product sales data available.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
@php
  $salesDashboardPayload = [
    'currency' => $currency,
    'salesChart' => $salesChart,
    'pipelineChart' => $pipelineChart,
    'salesGrowthChart' => $salesGrowthChart,
    'monthlyTargetPercent' => $stats['monthly_target_percent'],
  ];
@endphp
<script>
  window.salesDashboardData = @json($salesDashboardPayload);
</script>
<script src="{{ asset('admin/js/dashboard/sales.js') }}"></script>
@endpush

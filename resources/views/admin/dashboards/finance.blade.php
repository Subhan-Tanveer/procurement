@extends('admin.layouts.app')

@section('title', 'Finance Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Finance</li>
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
  $statusColors = [
    'Completed' => 'success',
    'Pending' => 'warning',
    'Rejected' => 'danger',
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
  .dashboard-table-card,
  .dashboard-hero-card {
    height: 100%;
    border-radius: 1rem;
  }
  .dashboard-stat-card .card-body {
    padding: 1.2rem 1.25rem;
    gap: .95rem;
  }
  .dashboard-summary-card .card-header,
  .dashboard-table-card .card-header,
  .dashboard-hero-card .card-header {
    padding: 1.25rem 1.25rem .5rem;
  }
  .dashboard-summary-card .card-body,
  .dashboard-summary-card .card-footer,
  .dashboard-table-card .card-body,
  .dashboard-hero-card .card-body,
  .dashboard-hero-card .card-footer {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
  }
  .dashboard-summary-card .card-body,
  .dashboard-hero-card .card-body {
    padding-top: 1rem;
    padding-bottom: 1.25rem;
  }
  .dashboard-summary-card .card-footer,
  .dashboard-hero-card .card-footer {
    padding-top: 1rem;
    padding-bottom: 1.25rem;
  }
  .dashboard-stat-card .card-body,
  .dashboard-stat-card .card-footer,
  .dashboard-summary-card .card-body,
  .dashboard-summary-card .card-footer,
  .dashboard-table-card .card-body,
  .dashboard-hero-card .card-body,
  .dashboard-hero-card .card-footer {
    overflow: hidden;
  }
  .dashboard-chart-compact {
    min-height: 0;
    margin-top: 1rem;
  }
  .dashboard-donut-wrap {
    max-width: 132px;
    margin: 0 auto;
  }
  .dashboard-breakdown-list {
    margin-top: 1rem;
  }
  .dashboard-breakdown-item {
    padding: .55rem 0;
  }
  .dashboard-hero-stats {
    gap: .75rem;
    flex-wrap: wrap;
  }
  .dashboard-hero-chart-wrap {
    margin: 1rem 0 1.15rem;
  }
  .dashboard-hero-summary {
    max-width: 20rem;
    margin: 0 auto;
  }
  .dashboard-hero-foot {
    align-items: stretch;
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

    <div class="col-xxl-9 col-xl-8">
      <div class="row">
        <div class="col-xxl-3 col-sm-6">
          <div class="card dashboard-stat-card">
            <div class="card-body d-flex gap-3 align-items-center">
            <div class="avatar bg-success-subtle rounded-circle text-success">
                <i class="fi fi-rr-coins"></i>
              </div>
              <div class="clearfix dashboard-metric-block">
                <span class="fw-semibold text-muted">Total Revenue</span>
                <h2 class="fw-bold mb-0 mt-1 dashboard-amount">{{ $formatMoney($stats['total_revenue']) }}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
          <div class="card dashboard-stat-card">
            <div class="card-body d-flex gap-3 align-items-center">
            <div class="avatar bg-danger-subtle rounded-circle text-danger">
                <i class="fi fi-rr-credit-card"></i>
              </div>
              <div class="clearfix dashboard-metric-block">
                <span class="fw-semibold text-muted">Outstanding Invoices</span>
                <h2 class="fw-bold mb-0 mt-1 dashboard-amount">{{ $formatMoney($stats['outstanding_invoices']) }}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
          <div class="card dashboard-stat-card">
            <div class="card-body d-flex gap-3 align-items-center">
            <div class="avatar bg-info-subtle rounded-circle text-info">
                <i class="fi fi-rr-chart-histogram"></i>
              </div>
              <div class="clearfix dashboard-metric-block">
                <span class="fw-semibold text-muted">Collected This Month</span>
                <h2 class="fw-bold mb-0 mt-1 dashboard-amount">{{ $formatMoney($stats['cash_collected_this_month']) }}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
          <div class="card dashboard-stat-card">
            <div class="card-body d-flex gap-3 align-items-center">
            <div class="avatar bg-warning-subtle rounded-circle text-warning">
                <i class="fi fi-rr-calendar"></i>
              </div>
              <div class="clearfix dashboard-metric-block">
                <span class="fw-semibold text-muted">Pending Invoices</span>
                <h2 class="fw-bold mb-0 mt-1 dashboard-amount">{{ number_format($stats['pending_invoices']) }}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card dashboard-summary-card">
            <div class="card-header border-0 d-flex pb-0 justify-content-between align-items-center">
              <h6 class="card-title mb-0">Collected vs Issued Invoices</h6>
              <span class="badge {{ $stats['collection_change'] >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                {{ $stats['collection_change'] >= 0 ? '+' : '' }}{{ number_format($stats['collection_change'], 1) }}% vs last month
              </span>
            </div>
            <div class="card-body pt-3 pb-3">
              <div id="summeryChart" class="dashboard-chart-compact"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card dashboard-summary-card">
            <div class="card-header border-0">
              <h6 class="card-title mb-0">Invoice Breakdown</h6>
            </div>
            <div class="card-body pt-3">
              <div class="dashboard-donut-wrap ratio ratio-1x1">
                <canvas id="expenseChart"></canvas>
              </div>
              <div class="d-grid w-100 dashboard-breakdown-list">
                @foreach($invoiceBreakdown as $index => $entry)
                  <div class="d-flex gap-2 align-items-center dashboard-breakdown-item">
                    <i class="fa fa-square text-primary {{ $index === 0 ? 'text-opacity-10' : ($index === 1 ? 'text-opacity-25' : ($index === 2 ? 'text-opacity-50' : 'text-opacity-75')) }} me-1"></i>
                    {{ $entry['label'] }}
                    <strong class="text-dark fw-semibold ms-auto">{{ $formatMoney($entry['amount']) }}</strong>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xxl-3 col-xl-4">
      <div class="card overflow-hidden bg-primary ovarlay-primary-gradient border-0 dashboard-hero-card" style="background-image: url({{ asset('admin/assets/images/wind.gif') }}); background-position: center; background-size: cover;">
        <div class="card-header pb-0 border-0 d-flex align-items-center justify-content-between z-1 position-relative">
          <h6 class="card-title mb-0 text-white">Monthly Collections</h6>
        </div>
        <div class="card-body">
          <div class="d-flex align-items-start dashboard-hero-stats">
            <h2 class="mb-0 text-white">{{ number_format($stats['monthly_target_percent'], 1) }}%</h2>
            <span class="text-white">{{ $stats['collection_change'] >= 0 ? '+' : '' }}{{ number_format($stats['collection_change'], 1) }}% vs last month</span>
          </div>
          <div class="dashboard-hero-chart-wrap position-relative">
            <div id="monthlyStatusChart" class="dashboard-chart-compact"></div>
            <div class="text-white text-center mt-2">{{ number_format($stats['month_paid_invoice_count']) }} paid invoices</div>
          </div>
          <div class="text-center px-3 dashboard-hero-summary">
            <p class="text-white mb-0">Collected <strong class="text-warning">{{ $formatMoney($stats['today_collected_amount']) }}</strong> today from paid quotations.</p>
          </div>
        </div>
        <div class="card-footer border-0 pt-3">
          <div class="bg-body py-3 px-3 rounded-3 d-flex dashboard-hero-foot">
            <div class="text-center w-50 py-2">
              <h4 class="mb-0 dashboard-amount-sm">{{ $formatMoney($stats['monthly_target_amount']) }}</h4>
              <span class="text-primary text-2xs fw-semibold d-block">Issued</span>
            </div>
            <div class="vr opacity-50"></div>
            <div class="text-center w-50 py-2">
              <h4 class="mb-0 dashboard-amount-sm">{{ $formatMoney($stats['monthly_achieved_amount']) }}</h4>
              <span class="text-primary text-2xs fw-semibold d-block">Collected</span>
            </div>
            <div class="vr opacity-50"></div>
            <div class="text-center w-50 py-2">
              <h4 class="mb-0 dashboard-amount-sm">{{ $formatMoney($stats['today_collected_amount']) }}</h4>
              <span class="text-primary text-2xs fw-semibold d-block">Today</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="card dashboard-table-card">
        <div class="card-header d-flex flex-wrap gap-3 align-items-center justify-content-between border-0 pb-0">
          <h6 class="card-title mb-0">Recent Financial Activity</h6>
          <div id="dt_RecentTransactions_Search"></div>
        </div>
        <div class="card-body">
          <table id="dt_RecentTransactions" class="table table-sm display table-row-rounded">
            <thead class="table-light">
              <tr>
                <th class="minw-150px">Name</th>
                <th class="minw-150px">Date</th>
                <th class="minw-200px">Description</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentTransactions as $transaction)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-xxs rounded-circle me-2 bg-primary-subtle text-primary fw-semibold d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($transaction['name'], 0, 1)) }}
                      </div>
                      {{ $transaction['name'] }}
                    </div>
                  </td>
                  <td>{{ $transaction['date']?->format('d M Y') ?? '—' }}</td>
                  <td>{{ $transaction['description'] }}</td>
                  <td>{{ $transaction['category'] }}</td>
                  <td class="{{ $transaction['amount_direction'] === 'positive' ? 'text-success' : ($transaction['amount_direction'] === 'negative' ? 'text-danger' : 'text-dark') }} fw-bold">
                    {{ $transaction['amount_direction'] === 'positive' ? '+' : ($transaction['amount_direction'] === 'negative' ? '-' : '') }}{{ $formatMoney($transaction['amount']) }}
                  </td>
                  <td>
                    @php $badgeColor = $statusColors[$transaction['status']] ?? 'secondary'; @endphp
                    <span class="badge badge-lg bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }}">{{ $transaction['status'] }}</span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No financial activity recorded yet.</td>
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
  $financeDashboardPayload = [
    'currency' => $currency,
    'summaryChart' => $financeChart,
    'invoiceBreakdown' => $invoiceBreakdown,
    'monthlyTargetPercent' => $stats['monthly_target_percent'],
    'monthlyAchievedAmount' => $stats['monthly_achieved_amount'],
  ];
@endphp
<script>
  window.financeDashboardData = @json($financeDashboardPayload);
</script>
<script src="{{ asset('admin/js/dashboard/finance.js') }}"></script>
@endpush

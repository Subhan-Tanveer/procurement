<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\ProductPage;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_pages' => ProductPage::count(),
            'published_pages' => ProductPage::where('is_published', true)->count(),
            'total_quotations' => Quotation::count(),
            'pending_quotations' => Quotation::where('status', 'pending')->count(),
            'quoted_quotations' => Quotation::where('status', 'quoted')->count(),
        ];

        $recentQuotations = Quotation::with(['items'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentProducts = Product::with(['category', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentQuotations', 'recentProducts'));
    }

    /**
     * Display sales dashboard.
     */
    public function sales()
    {
        $currency = $this->dashboardCurrency();
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $totalPaidRevenue = (float) Quotation::whereNotNull('paid_at')->sum('total_amount');
        $paidThisMonth = (float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$monthStart, $monthEnd])->sum('total_amount');
        $paidLastMonth = (float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])->sum('total_amount');

        $totalOrders = Order::count();
        $ordersThisMonth = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

        $acceptedQuotes = Quotation::where('status', 'accepted')->count();
        $totalQuotes = Quotation::count();
        $convertedOrders = Order::whereNotNull('quotation_id')->count();

        $acceptedValueThisMonth = (float) Quotation::where('status', 'accepted')
            ->whereBetween('responded_at', [$monthStart, $monthEnd])
            ->sum('total_amount');

        $avgPaidInvoiceThisMonth = (float) Quotation::whereNotNull('paid_at')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->avg('total_amount');

        $avgOrderValueThisMonth = (float) Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->avg('total_amount');

        $currentMonthQuotes = Quotation::whereBetween('created_at', [$monthStart, $monthEnd])->get(['status', 'paid_at']);
        $monthlyPaidCount = $currentMonthQuotes->whereNotNull('paid_at')->count();
        $monthlyUnpaidCount = $currentMonthQuotes->where('status', 'accepted')->whereNull('paid_at')->count();
        $monthlyRejectedCount = $currentMonthQuotes->where('status', 'rejected')->count();
        $monthlyQuoteCount = max($currentMonthQuotes->count(), 1);

        $recentSales = Order::with(['quotation', 'items'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $topSellingItems = OrderItem::with('product')
            ->get()
            ->groupBy(fn (OrderItem $item) => $item->product_id ?: $item->product_name)
            ->map(function (Collection $items) {
                $first = $items->first();
                $product = $first->product;

                return [
                    'product' => $product,
                    'product_name' => $first->product_name,
                    'quantity' => $items->sum('quantity'),
                    'unit_price' => (float) $items->avg('unit_price'),
                    'total_sales' => (float) $items->sum('total_price'),
                    'stock_status' => $product?->stock_status ?? 'unknown',
                    'is_active' => (bool) ($product?->is_active ?? false),
                ];
            })
            ->sortByDesc('total_sales')
            ->take(10)
            ->values();

        $salesByCategory = QuotationItem::with(['quotation', 'product.category'])
            ->get()
            ->filter(function (QuotationItem $item) {
                return $item->quotation
                    && ($item->quotation->status === 'accepted' || $item->quotation->paid_at !== null);
            })
            ->groupBy(fn (QuotationItem $item) => $item->product?->category?->name ?? 'Uncategorized')
            ->map(function (Collection $items, string $name) {
                return [
                    'name' => $name,
                    'value' => (float) $items->sum('total_price'),
                    'count' => $items->sum('quantity'),
                ];
            })
            ->sortByDesc('value')
            ->take(4)
            ->values();

        $salesChart = $this->buildSalesChartData($now);
        $pipelineChart = $this->buildOrderPipelineChart($now);
        $salesGrowthChart = $this->buildSalesGrowthChart($now);

        $stats = [
            'currency' => $currency,
            'total_earning' => $totalPaidRevenue,
            'total_earning_change' => $this->percentageChange($paidThisMonth, $paidLastMonth),
            'total_orders' => $totalOrders,
            'total_orders_change' => $this->percentageChange($ordersThisMonth, $ordersLastMonth),
            'revenue_growth' => $this->percentageChange($paidThisMonth, $paidLastMonth),
            'conversion_rate' => $totalQuotes > 0 ? round(($convertedOrders / $totalQuotes) * 100, 1) : 0,
            'avg_income' => $avgPaidInvoiceThisMonth,
            'avg_income_change' => $this->percentageChange($avgPaidInvoiceThisMonth, (float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])->avg('total_amount')),
            'avg_order_value' => $avgOrderValueThisMonth,
            'avg_order_value_change' => $this->percentageChange($avgOrderValueThisMonth, (float) Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->avg('total_amount')),
            'accepted_quotes' => $acceptedQuotes,
            'monthly_target_amount' => $acceptedValueThisMonth,
            'monthly_achieved_amount' => $paidThisMonth,
            'monthly_target_percent' => $acceptedValueThisMonth > 0 ? round(min(100, ($paidThisMonth / $acceptedValueThisMonth) * 100), 1) : 0,
            'monthly_paid_percent' => round(($monthlyPaidCount / $monthlyQuoteCount) * 100, 1),
            'monthly_unpaid_percent' => round(($monthlyUnpaidCount / $monthlyQuoteCount) * 100, 1),
            'monthly_rejected_percent' => round(($monthlyRejectedCount / $monthlyQuoteCount) * 100, 1),
            'month_collected_amount' => $paidThisMonth,
            'month_collected_change' => $this->percentageChange($paidThisMonth, $paidLastMonth),
        ];

        return view('admin.dashboards.sales', compact(
            'stats',
            'recentSales',
            'topSellingItems',
            'salesByCategory',
            'salesChart',
            'pipelineChart',
            'salesGrowthChart'
        ));
    }

    /**
     * Display finance dashboard.
     */
    public function finance()
    {
        $currency = $this->dashboardCurrency();
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $totalRevenue = (float) Quotation::whereNotNull('paid_at')->sum('total_amount');
        $paidThisMonth = (float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$monthStart, $monthEnd])->sum('total_amount');
        $paidLastMonth = (float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])->sum('total_amount');
        $outstandingInvoices = (float) Quotation::where('status', 'accepted')->whereNull('paid_at')->sum('total_amount');
        $pendingInvoices = Quotation::where('status', 'accepted')->whereNull('paid_at')->count();
        $pendingReviewAmount = (float) Quotation::whereIn('status', ['new', 'pending'])->sum('total_amount');
        $rejectedAmount = (float) Quotation::where('status', 'rejected')->sum('total_amount');
        $acceptedThisMonth = (float) Quotation::where('status', 'accepted')->whereBetween('responded_at', [$monthStart, $monthEnd])->sum('total_amount');

        $financeChart = $this->buildFinanceSummaryChart($now);
        $invoiceBreakdown = [
            ['label' => 'Collected', 'amount' => $totalRevenue],
            ['label' => 'Outstanding', 'amount' => $outstandingInvoices],
            ['label' => 'Pending Review', 'amount' => $pendingReviewAmount],
            ['label' => 'Rejected', 'amount' => $rejectedAmount],
        ];

        $recentTransactions = $this->buildRecentFinancialTransactions();

        $stats = [
            'currency' => $currency,
            'total_revenue' => $totalRevenue,
            'outstanding_invoices' => $outstandingInvoices,
            'cash_collected_this_month' => $paidThisMonth,
            'pending_invoices' => $pendingInvoices,
            'collection_change' => $this->percentageChange($paidThisMonth, $paidLastMonth),
            'monthly_target_amount' => $acceptedThisMonth,
            'monthly_achieved_amount' => $paidThisMonth,
            'monthly_target_percent' => $acceptedThisMonth > 0 ? round(min(100, ($paidThisMonth / $acceptedThisMonth) * 100), 1) : 0,
            'today_collected_amount' => (float) Quotation::whereNotNull('paid_at')->whereDate('paid_at', $now->toDateString())->sum('total_amount'),
            'month_paid_invoice_count' => Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$monthStart, $monthEnd])->count(),
        ];

        return view('admin.dashboards.finance', compact(
            'stats',
            'financeChart',
            'invoiceBreakdown',
            'recentTransactions'
        ));
    }

    private function dashboardCurrency(): string
    {
        return Quotation::whereNotNull('currency')->value('currency')
            ?? Order::whereNotNull('currency')->value('currency')
            ?? 'NGN';
    }

    private function percentageChange(float|int $current, float|int $previous): float
    {
        $current = (float) $current;
        $previous = (float) $previous;

        if ($previous == 0.0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function buildSalesChartData(Carbon $now): array
    {
        $paidQuotations = Quotation::whereNotNull('paid_at')->get(['paid_at', 'total_amount']);
        $acceptedQuotations = Quotation::where('status', 'accepted')->get(['responded_at', 'total_amount']);

        return [
            'today' => $this->buildTodaySeries($paidQuotations, $acceptedQuotations, $now),
            'week' => $this->buildWeekSeries($paidQuotations, $acceptedQuotations, $now),
            'month' => $this->buildMonthSeries($paidQuotations, $acceptedQuotations, $now),
        ];
    }

    private function buildTodaySeries(Collection $paidQuotations, Collection $acceptedQuotations, Carbon $now): array
    {
        $categories = [];
        $collected = [];
        $invoiced = [];

        for ($hour = 0; $hour < 24; $hour += 2) {
            $start = $now->copy()->startOfDay()->addHours($hour);
            $end = $start->copy()->addHours(2);
            $categories[] = $start->format('g A');
            $collected[] = round((float) $paidQuotations->filter(fn ($quote) => $quote->paid_at && $quote->paid_at >= $start && $quote->paid_at < $end)->sum('total_amount'), 2);
            $invoiced[] = round((float) $acceptedQuotations->filter(fn ($quote) => $quote->responded_at && $quote->responded_at >= $start && $quote->responded_at < $end)->sum('total_amount'), 2);
        }

        return compact('categories', 'collected', 'invoiced');
    }

    private function buildWeekSeries(Collection $paidQuotations, Collection $acceptedQuotations, Carbon $now): array
    {
        $startOfWeek = $now->copy()->startOfWeek();
        $categories = [];
        $collected = [];
        $invoiced = [];

        for ($day = 0; $day < 7; $day++) {
            $start = $startOfWeek->copy()->addDays($day)->startOfDay();
            $end = $start->copy()->endOfDay();
            $categories[] = $start->format('D');
            $collected[] = round((float) $paidQuotations->filter(fn ($quote) => $quote->paid_at && $quote->paid_at->between($start, $end))->sum('total_amount'), 2);
            $invoiced[] = round((float) $acceptedQuotations->filter(fn ($quote) => $quote->responded_at && $quote->responded_at->between($start, $end))->sum('total_amount'), 2);
        }

        return compact('categories', 'collected', 'invoiced');
    }

    private function buildMonthSeries(Collection $paidQuotations, Collection $acceptedQuotations, Carbon $now): array
    {
        $categories = [];
        $collected = [];
        $invoiced = [];

        for ($offset = 11; $offset >= 0; $offset--) {
            $month = $now->copy()->subMonths($offset)->startOfMonth();
            $end = $month->copy()->endOfMonth();
            $categories[] = $month->format('M');
            $collected[] = round((float) $paidQuotations->filter(fn ($quote) => $quote->paid_at && $quote->paid_at->between($month, $end))->sum('total_amount'), 2);
            $invoiced[] = round((float) $acceptedQuotations->filter(fn ($quote) => $quote->responded_at && $quote->responded_at->between($month, $end))->sum('total_amount'), 2);
        }

        return compact('categories', 'collected', 'invoiced');
    }

    private function buildOrderPipelineChart(Carbon $now): array
    {
        $statuses = ['created', 'confirmed', 'processing', 'dispatched', 'delivered', 'cancelled'];
        $labels = collect($statuses)->map(fn (string $status) => str($status)->replace('_', ' ')->title()->toString())->all();
        $currentStart = $now->copy()->startOfMonth();
        $currentEnd = $now->copy()->endOfMonth();
        $lastStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $current = [];
        $previous = [];

        foreach ($statuses as $status) {
            $current[] = Order::where('status', $status)->whereBetween('created_at', [$currentStart, $currentEnd])->count();
            $previous[] = Order::where('status', $status)->whereBetween('created_at', [$lastStart, $lastEnd])->count();
        }

        return [
            'categories' => $labels,
            'current' => $current,
            'previous' => $previous,
        ];
    }

    private function buildSalesGrowthChart(Carbon $now): array
    {
        $categories = [];
        $values = [];

        for ($offset = 6; $offset >= 0; $offset--) {
            $day = $now->copy()->subDays($offset);
            $categories[] = $day->format('D');
            $values[] = round((float) Quotation::whereNotNull('paid_at')->whereDate('paid_at', $day->toDateString())->sum('total_amount'), 2);
        }

        return compact('categories', 'values');
    }

    private function buildFinanceSummaryChart(Carbon $now): array
    {
        $categories = [];
        $collected = [];
        $issued = [];

        for ($offset = 7; $offset >= 0; $offset--) {
            $month = $now->copy()->subMonths($offset)->startOfMonth();
            $end = $month->copy()->endOfMonth();
            $categories[] = $month->format('M');
            $collected[] = round((float) Quotation::whereNotNull('paid_at')->whereBetween('paid_at', [$month, $end])->sum('total_amount'), 2);
            $issued[] = round((float) Quotation::where('status', 'accepted')->whereBetween('responded_at', [$month, $end])->sum('total_amount'), 2);
        }

        return compact('categories', 'collected', 'issued');
    }

    private function buildRecentFinancialTransactions(): Collection
    {
        return Quotation::orderByRaw('COALESCE(paid_at, responded_at, updated_at) DESC')
            ->limit(12)
            ->get()
            ->map(function (Quotation $quotation) {
                if ($quotation->paid_at) {
                    return [
                        'name' => $quotation->customer_name,
                        'date' => $quotation->paid_at,
                        'description' => 'Payment received for INV-' . $quotation->quote_number,
                        'category' => 'Revenue',
                        'amount' => (float) $quotation->total_amount,
                        'amount_direction' => 'positive',
                        'status' => 'Completed',
                    ];
                }

                if ($quotation->status === 'accepted') {
                    return [
                        'name' => $quotation->customer_name,
                        'date' => $quotation->responded_at ?? $quotation->updated_at,
                        'description' => 'Invoice issued for INV-' . $quotation->quote_number,
                        'category' => 'Receivable',
                        'amount' => (float) $quotation->total_amount,
                        'amount_direction' => 'neutral',
                        'status' => 'Pending',
                    ];
                }

                return [
                    'name' => $quotation->customer_name,
                    'date' => $quotation->updated_at,
                    'description' => 'Quotation ' . str($quotation->status)->replace('_', ' ')->title() . ' - ' . $quotation->quote_number,
                    'category' => 'Workflow',
                    'amount' => (float) $quotation->total_amount,
                    'amount_direction' => $quotation->status === 'rejected' ? 'negative' : 'neutral',
                    'status' => str($quotation->status)->replace('_', ' ')->title()->toString(),
                ];
            });
    }
}

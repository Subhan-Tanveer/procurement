const salesData = window.salesDashboardData || {};
const salesCurrency = salesData.currency || 'NGN';
const salesCurrencyPrefix = salesCurrency === 'NGN' ? '₦' : `${salesCurrency} `;

function salesMoney(value) {
    return `${salesCurrencyPrefix}${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

if ($('#dt_RecentSales').length) {
    $('#dt_RecentSales').DataTable({
        searching: true,
        pageLength: 5,
        select: false,
        lengthChange: false,
        info: true,
        paging: true,
        language: {
            search: "",
            searchPlaceholder: 'Search',
            paginate: {
                previous: "<i class='fi fi-rr-angle-left'></i>",
                next: "<i class='fi fi-rr-angle-right'></i>",
                first: "<i class='fi fi-rr-angle-double-left'></i>",
                last: "<i class='fi fi-rr-angle-double-right'></i>"
            },
        },
        initComplete: function () {
            const dtSearch = $('#dt_RecentSales_wrapper .dt-search').detach();
            $('#dt_RecentSales_Search').append(dtSearch);
            $('#dt_RecentSales_Search .dt-search').prepend('<i class="fi fi-rr-search"></i>');
            $('#dt_RecentSales_Search .dt-search label').remove();
            $('#dt_RecentSales_wrapper > .row.mt-2.justify-content-between').first().remove();
        },
        columnDefs: [{
            targets: [0],
            orderable: false,
        }]
    });
}

if ($('#dt_TopSellingItems').length) {
    $('#dt_TopSellingItems').DataTable({
        searching: true,
        pageLength: 5,
        select: false,
        lengthChange: false,
        info: true,
        paging: true,
        language: {
            search: "",
            searchPlaceholder: 'Search',
            paginate: {
                previous: "<i class='fi fi-rr-angle-left'></i>",
                next: "<i class='fi fi-rr-angle-right'></i>",
                first: "<i class='fi fi-rr-angle-double-left'></i>",
                last: "<i class='fi fi-rr-angle-double-right'></i>"
            },
        },
        initComplete: function () {
            const dtSearch = $('#dt_TopSellingItems_wrapper .dt-search').detach();
            $('#dt_TopSellingItems_Search').append(dtSearch);
            $('#dt_TopSellingItems_Search .dt-search').prepend('<i class="fi fi-rr-search"></i>');
            $('#dt_TopSellingItems_Search .dt-search label').remove();
            $('#dt_TopSellingItems_wrapper > .row.mt-2.justify-content-between').first().remove();
        }
    });
}

const salesPeriods = salesData.salesChart || {};
const initialPeriod = salesPeriods.month || { categories: [], collected: [], invoiced: [] };

const SalesChartConfig = {
    series: [
        { name: 'Collected', data: initialPeriod.collected || [] },
        { name: 'Invoiced', data: initialPeriod.invoiced || [] }
    ],
    chart: {
        height: 270,
        type: 'area',
        zoom: { enabled: false },
        toolbar: { show: false },
    },
    colors: ["var(--bs-primary)", "var(--bs-danger)"],
    fill: {
        type: ['gradient', 'gradient'],
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.1,
            gradientToColors: ['var(--bs-primary)'],
            inverseColors: false,
            opacityFrom: 0.08,
            opacityTo: 0.01,
            stops: [20, 100]
        }
    },
    dataLabels: { enabled: false },
    stroke: {
        width: [2, 2],
        curve: 'smooth',
        dashArray: [0, 0]
    },
    markers: {
        size: 0,
        colors: ['#FFFFFF'],
        strokeColors: 'var(--bs-info)',
        strokeWidth: 2,
        hover: { size: 6 }
    },
    yaxis: {
        min: 0,
        labels: {
            formatter: function (value) {
                return salesMoney(value);
            },
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontWeight: '500',
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    xaxis: {
        categories: initialPeriod.categories || [],
        axisBorder: { color: 'var(--bs-border-color)' },
        axisTicks: { show: false },
        labels: {
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontWeight: '500',
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return salesMoney(val);
            }
        }
    },
    grid: {
        borderColor: 'var(--bs-border-color)',
        strokeDashArray: 5,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } }
    },
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        markers: { size: 5, shape: 'circle', radius: 10, width: 10, height: 10 },
        labels: {
            colors: 'var(--bs-heading-color)',
            fontFamily: 'var(--bs-body-font-family)',
            fontSize: '13px',
        }
    }
};

const SalesChart = document.querySelector('#SalesChart');
if (SalesChart) {
    const chartTabsInit = new ApexCharts(SalesChart, SalesChartConfig);
    chartTabsInit.render();

    const updateSalesPeriod = (periodKey) => {
        const period = salesPeriods[periodKey] || initialPeriod;
        chartTabsInit.updateOptions({
            xaxis: { categories: period.categories || [] },
            series: [
                { name: 'Collected', data: period.collected || [] },
                { name: 'Invoiced', data: period.invoiced || [] }
            ]
        });
    };

    document.querySelector('#todayRevenueTab')?.addEventListener('click', () => updateSalesPeriod('today'));
    document.querySelector('#weekRevenueTab')?.addEventListener('click', () => updateSalesPeriod('week'));
    document.querySelector('#monthRevenueTab')?.addEventListener('click', () => updateSalesPeriod('month'));
}

const pipelineData = salesData.pipelineChart || { categories: [], current: [], previous: [] };
const VisitorsChartConfig = {
    series: [
        { name: 'Current Month', data: pipelineData.current || [] },
        { name: 'Last Month', data: pipelineData.previous || [] }
    ],
    chart: {
        height: 245,
        type: 'bar',
        toolbar: { show: false },
        animations: { enabled: true, easing: 'easeinout', speed: 800 }
    },
    colors: ['var(--bs-primary)', 'var(--bs-light)'],
    fill: {
        type: ['gradient'],
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.1,
            gradientToColors: ['var(--bs-info)'],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 0.6,
            stops: [20, 100]
        }
    },
    dataLabels: { enabled: false },
    stroke: { width: 0 },
    plotOptions: { bar: { horizontal: false, columnWidth: '75%', borderRadius: 4, distributed: false } },
    grid: {
        borderColor: 'var(--bs-border-color)',
        strokeDashArray: 5,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } }
    },
    tooltip: {
        theme: 'light',
        y: { formatter: function (val) { return `${val} orders`; } }
    },
    xaxis: {
        categories: pipelineData.categories || [],
        axisBorder: { color: 'var(--bs-border-color)' },
        axisTicks: { show: false },
        labels: {
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontWeight: 500,
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    yaxis: { show: false },
};
const VisitorsChart = document.querySelector('#VisitorsChart');
if (VisitorsChart) {
    const chartInit = new ApexCharts(VisitorsChart, VisitorsChartConfig);
    chartInit.render();
}

const growthData = salesData.salesGrowthChart || { categories: [], values: [] };
const SalesGrowthChartConfig = {
    series: [{ name: 'Collections', data: growthData.values || [] }],
    chart: {
        height: 235,
        type: 'area',
        toolbar: { show: false },
        animations: { enabled: true, easing: 'easeinout', speed: 800 }
    },
    colors: ['var(--bs-primary)'],
    fill: {
        type: ['gradient'],
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.1,
            gradientToColors: ['var(--bs-info)'],
            inverseColors: false,
            opacityFrom: 0.2,
            opacityTo: 0.06,
            stops: [20, 100]
        }
    },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2, colors: ['var(--bs-info)'] },
    grid: {
        borderColor: 'var(--bs-border-color)',
        strokeDashArray: 5,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } }
    },
    tooltip: { y: { formatter: function (val) { return salesMoney(val); } } },
    xaxis: {
        categories: growthData.categories || [],
        axisBorder: { color: 'var(--bs-border-color)' },
        axisTicks: { show: false },
        labels: {
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontWeight: 500,
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    yaxis: {
        min: 0,
        labels: {
            formatter: function (value) { return salesMoney(value); },
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontWeight: 500,
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
};
const SalesGrowthChart = document.querySelector('#SalesGrowthChart');
if (SalesGrowthChart) {
    const chartInit = new ApexCharts(SalesGrowthChart, SalesGrowthChartConfig);
    chartInit.render();
}

const MonthlyTargetChartConfig = {
    series: [Number(salesData.monthlyTargetPercent || 0)],
    chart: {
        type: 'radialBar',
        offsetY: 0,
        height: 250,
        sparkline: { enabled: true }
    },
    plotOptions: {
        radialBar: {
            startAngle: -95,
            endAngle: 95,
            track: {
                background: 'rgba(var(--bs-primary-rgb), 0.6)',
                strokeWidth: '10%',
                margin: 16
            },
            dataLabels: {
                name: { show: false },
                value: {
                    show: true,
                    offsetY: -18,
                    fontSize: '20px',
                    fontFamily: 'var(--bs-body-font-family)',
                    fontWeight: 600,
                    color: 'var(--bs-dark)',
                    formatter: function (val) {
                        return `${Number(val).toFixed(1)}%`;
                    }
                },
            }
        }
    },
    grid: { padding: { top: 0, bottom: 0, left: 0, right: 0 } },
    fill: { colors: ['var(--bs-primary)'] }
};
const MonthlyTargetChart = document.querySelector('#MonthlyTargetChart');
if (MonthlyTargetChart) {
    const chartInit = new ApexCharts(MonthlyTargetChart, MonthlyTargetChartConfig);
    chartInit.render();
}

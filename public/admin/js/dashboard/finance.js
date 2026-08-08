const financeData = window.financeDashboardData || {};
const financeCurrency = financeData.currency || 'NGN';
const financeCurrencyPrefix = financeCurrency === 'NGN' ? '₦' : `${financeCurrency} `;

function financeMoney(value) {
    return `${financeCurrencyPrefix}${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

const summaryData = financeData.summaryChart || { categories: [], collected: [], issued: [] };
const summeryChartConfig = {
    series: [
        { name: 'Collected', data: summaryData.collected || [] },
        { name: 'Issued', data: summaryData.issued || [] }
    ],
    chart: {
        height: 215,
        type: 'line',
        zoom: { enabled: false },
        toolbar: { show: false },
    },
    colors: ['var(--bs-secondary)', 'var(--bs-primary)'],
    dataLabels: { enabled: false },
    stroke: { width: [2, 2], curve: 'smooth', dashArray: [8, 0] },
    markers: { size: 0, hover: { sizeOffset: 6 } },
    yaxis: {
        min: 0,
        labels: {
            formatter: function (value) { return financeMoney(value); },
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    xaxis: {
        categories: summaryData.categories || [],
        axisBorder: { color: 'var(--bs-border-color)' },
        axisTicks: { show: false },
        labels: {
            style: {
                colors: 'var(--bs-body-color)',
                fontSize: '13px',
                fontFamily: 'var(--bs-body-font-family)'
            }
        }
    },
    tooltip: { y: { formatter: function (val) { return financeMoney(val); } } },
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
        markers: { strokeWidth: 0 },
        labels: {
            colors: 'var(--bs-body-color)',
            fontSize: '12px',
            fontWeight: '600',
            fontFamily: 'var(--bs-body-font-family)',
        },
    }
};
const summeryChart = document.querySelector('#summeryChart');
if (summeryChart) {
    const chartInit = new ApexCharts(summeryChart, summeryChartConfig);
    chartInit.render();
}

function expenseChartConfig() {
    const breakdown = financeData.invoiceBreakdown || [];
    const labels = breakdown.map(item => item.label);
    const values = breakdown.map(item => Number(item.amount || 0));

    const centerTextPlugin = {
        afterDraw(chart) {
            const { ctx, chartArea: { left, right, top, bottom } } = chart;
            const centerX = (left + right) / 2;
            const centerY = (top + bottom) / 2;
            const total = chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);

            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 13px sans-serif';
            ctx.fillStyle = '#000';
            ctx.fillText(financeMoney(total), centerX, centerY - 4);
            ctx.font = '11px sans-serif';
            ctx.fillStyle = '#999';
            ctx.fillText('Invoices', centerX, centerY + 12);
            ctx.restore();
        }
    };

    const canvas = document.getElementById('expenseChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: values,
                backgroundColor: ['#5955D1', '#ACAAE8', '#d1d0f7', '#DEDDF6'],
                borderRadius: 3,
                spacing: 0,
                hoverOffset: 5,
                borderWidth: 3,
                borderColor: '#fff',
                hoverBorderColor: '#fff'
            }]
        },
        options: {
            cutout: '65%',
            devicePixelRatio: 2,
            layout: { padding: 0 },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => `${context.label}: ${financeMoney(context.raw)}`
                    }
                }
            }
        },
        plugins: [centerTextPlugin]
    });
}
document.addEventListener('DOMContentLoaded', expenseChartConfig);

if ($('#dt_RecentTransactions').length) {
    $('#dt_RecentTransactions').DataTable({
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
            const dtSearch = $('#dt_RecentTransactions_wrapper .dt-search').detach();
            $('#dt_RecentTransactions_Search').append(dtSearch);
            $('#dt_RecentTransactions_Search .dt-search').prepend('<i class="fi fi-rr-search"></i>');
            $('#dt_RecentTransactions_Search .dt-search label').remove();
            $('#dt_RecentTransactions_wrapper > .row.mt-2.justify-content-between').first().remove();
        }
    });
}

const monthlyStatusChartConfig = {
    series: [Number(financeData.monthlyTargetPercent || 0)],
    chart: {
        type: 'radialBar',
        offsetY: 0,
        height: 220,
        sparkline: { enabled: true }
    },
    plotOptions: {
        radialBar: {
            startAngle: -95,
            endAngle: 95,
            track: {
                background: 'rgba(var(--bs-white-rgb), 0.3)',
                strokeWidth: '100%',
                margin: 16
            },
            dataLabels: {
                name: { show: false },
                value: {
                    show: true,
                    offsetY: -20,
                    fontSize: '20px',
                    fontFamily: 'var(--bs-body-font-family)',
                    fontWeight: 600,
                    color: 'var(--bs-white)',
                    formatter: function (val) {
                        return `${Number(val).toFixed(1)}%`;
                    }
                },
            }
        }
    },
    grid: { padding: { top: 0, bottom: 0, left: 0, right: 0 } },
    fill: { colors: ['var(--bs-white)'] }
};
const monthlyStatusChart = document.querySelector('#monthlyStatusChart');
if (monthlyStatusChart) {
    const chartInit = new ApexCharts(monthlyStatusChart, monthlyStatusChartConfig);
    chartInit.render();
}

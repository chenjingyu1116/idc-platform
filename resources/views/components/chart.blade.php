@props(['id' => 'chart', 'type' => 'line', 'labels' => [], 'datasets' => [], 'height' => 300])

<div class="chart-wrap" style="height:{{ $height }}px;position:relative">
    <canvas id="{{ $id }}"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    var ctx = document.getElementById(@json($id));
    if (!ctx) return;

    // 自动给折线图加渐变
    var datasets = @json($datasets);
    datasets = datasets.map(function(ds) {
        if (@json($type) === 'line' && !ds.fill) {
            ds.fill = true;
            ds.tension = 0.45;
            ds.borderWidth = 3;
            ds.pointRadius = 0;
            ds.pointHoverRadius = 6;
            ds.pointHoverBackgroundColor = '#fff';
            ds.pointHoverBorderWidth = 3;
        }
        return ds;
    });

    new Chart(ctx, {
        type: @json($type),
        data: {
            labels: @json($labels),
            datasets: datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1500,
                easing: 'easeOutQuart',
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#4A4A6A',
                        font: { family: 'Quicksand', size: 13 },
                        usePointStyle: true,
                        padding: 16,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(74, 74, 106, .95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                },
            },
            scales: @json($type) === 'pie' || @json($type) === 'doughnut' ? {} : {
                x: {
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                    grid: { color: 'rgba(255, 158, 196, .08)', drawBorder: false },
                },
                y: {
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                    grid: { color: 'rgba(255, 158, 196, .08)', drawBorder: false },
                },
            },
        },
    });
})();
</script>

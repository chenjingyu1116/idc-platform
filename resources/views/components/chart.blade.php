@props(['id' => 'chart', 'type' => 'line', 'labels' => [], 'datasets' => [], 'height' => 300])

<div style="height:{{ $height }}px;position:relative">
    <canvas id="{{ $id }}"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const ctx = document.getElementById(@json($id));
    if (!ctx) return;
    new Chart(ctx, {
        type: @json($type),
        data: {
            labels: @json($labels),
            datasets: @json($datasets),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#4A4A6A', font: { family: 'Quicksand' } } },
            },
            scales: @json($type) === 'pie' || @json($type) === 'doughnut' ? {} : {
                x: { ticks: { color: '#9CA3AF' }, grid: { color: 'rgba(255,158,196,.15)' } },
                y: { ticks: { color: '#9CA3AF' }, grid: { color: 'rgba(255,158,196,.15)' } },
            },
        },
    });
})();
</script>

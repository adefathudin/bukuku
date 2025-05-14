<div class="flex-grow flex">
    <section class="w-full">
        <div class="bg-white shadow rounded-sm p-4">
            <h2 class="text-lg font-semibold mb-4">Daily Transaction</h2>
            <canvas id="byPeriode" width="400" height="200"></canvas>
        </div>
    </section>
    <section class="h-6/12 pl-2">
        <div class="bg-white shadow rounded-sm p-4">
            <h2 class="text-lg font-semibold mb-4">Transaction by Category on This Week</h2>
            <canvas id="byCategory" width="400" height="200"></canvas>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const el = document.getElementById('byPeriode');
        if (!el) {
            console.error('Sales chart element not found');
            return false;
        }
        try {
            const response = await fetch(`{{ route('reports.chart', ['type' => 'transactions', 'filter' => 'periode', 'range' => 'daily']) }}`);
            const result = await response.json();
            console.log(result);
            const salesChart = new Chart(el, {
                type: 'line',
                data: {
                    labels: result.labels,
                    datasets: [{
                        label: 'Transactions',
                        data: result.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        catch (error) {
            console.error('Error fetching chart data:', error);
        }

        const byCategoryEl = document.getElementById('byCategory');
        if (!byCategoryEl) {
            console.error('By Category chart element not found');
            return false;
        }
        try {
            const response = await fetch(`{{ route('reports.chart', ['type' => 'transactions', 'filter' => 'category', 'range' => 'daily']) }}`);
            const result = await response.json();
            const byCategoryChart = new Chart(byCategoryEl, {
                type: 'pie',
                data: {
                    labels: result.labels,
                    datasets: [{
                        data: result.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        }
        catch (error) {
            console.error('Error fetching chart data:', error);
        }
    });
</script>
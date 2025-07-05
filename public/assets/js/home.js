function initHome() {
    return {
        chart: null,
        data: [],
        async getChart() {
            try {

                if (this.chart) {
                    this.chart.destroy()
                }

                const response = await fetch(`/api/transaksi/chart/all/daily`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                this.chart = new Chart(document.getElementById('report'), {
                    type: 'bar',
                    data: {
                        labels: result.labels,
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: result.pemasukan,
                                borderColor: 'rgb(26, 224, 85)',
                                backgroundColor: 'rgb(26, 224, 85)',
                                borderWidth: 2,
                                tension: 0.4,
                            },
                            {
                                label: 'Pengeluaran',
                                data: result.pengeluaran,
                                borderColor: 'rgb(209, 9, 9)',
                                backgroundColor: 'rgb(209, 9, 9)',
                                borderWidth: 2,
                                tension: 0.4
                            }
                        ]
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
            } catch (error) {
                console.error('Error fetching chart data for daily transactions:', error);
            }
        },
    }
}

function initReports() {
    return {
        periode: 'daily',
        chart: null,
        byCategoryEl: null,
        data: [],
        search: '',

        async onLoad() {
            let a = await this.datatableReports().loadData(this.periode);
            this.data = a;
            this.fetchData();
        },

        async setPeriode(periode) {
            this.periode = periode;
            if (this.byCategoryEl) {
                this.byCategoryEl.destroy();
                this.byCategoryEl = null;
            }
            let a = await this.datatableReports().loadData(this.periode);
            this.data = a;
            this.fetchData();
        },

        async searchTransaction(receipt_number) {
            let a = await this.datatableReports().loadData('', receipt_number);
            this.data = a;
        },

        async changePage(page) {
            if (page >= 1 && page <= this.data.last_page) {
                this.currentPage = page;
                let a = await this.datatableReports().loadData('', '', page);
                console.log(a)
                this.data = a;
            }
        },

        async fetchData() {

            this.byPeriodeEl = this.$refs.byPeriode;
            if (!this.byPeriodeEl) {
                console.error('Sales chart element not found');
                return;
            }
            try {

                if (this.chart) {
                    this.chart.destroy()
                }

                const response = await fetch(`/api/reports/chart/transactions/periode/${this.periode}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                this.chart = new Chart(this.byPeriodeEl, {
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
                        responsive: false,
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

        datatableReports() {
            return {
                filters: { name: '', category: '', price: '' },
                currentPage: 1,
                totalPages: 1,
                sortField: 'id',
                sortDirection: 'asc',
                stockOutCount: 0,
                isStockOut: false,

                async loadData(periode = '', receipt_number = '', page = 1) {
                    const params = new URLSearchParams({
                        periode: periode,
                        receipt_number: receipt_number,
                        page: page,
                    });
                    const response = await fetch(`/api/reports/datatable?${params.toString()}`, {
                        method: 'GET',
                        credentials: 'include',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    return await response.json();
                }
            }
        },
    }
}
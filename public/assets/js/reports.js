
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

        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.loadData();
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

            // Fetch data for the Transaction by Category chart
            // const byCategoryEl = this.$refs.byCategory;
            // if (!byCategoryEl) {
            //     console.error('By Category chart element not found');
            //     return;
            // }
            // try {
            //     const response = await fetch(`/api/reports/chart/transactions/category/daily`);
            //     const result = await response.json();
            //     new Chart(byCategoryEl, {
            //         type: 'pie',
            //         data: {
            //             labels: result.labels,
            //             datasets: [{
            //                 data: result.data,
            //                 backgroundColor: [
            //                     'rgba(255, 99, 132, 0.2)',
            //                     'rgba(54, 162, 235, 0.2)',
            //                     'rgba(255, 206, 86, 0.2)',
            //                     'rgba(75, 192, 192, 0.2)',
            //                     'rgba(153, 102, 255, 0.2)',
            //                     'rgba(255, 159, 64, 0.2)'
            //                 ],
            //                 borderColor: [
            //                     'rgba(255, 99, 132, 1)',
            //                     'rgba(54, 162, 235, 1)',
            //                     'rgba(255, 206, 86, 1)',
            //                     'rgba(75, 192, 192, 1)',
            //                     'rgba(153, 102, 255, 1)',
            //                     'rgba(255, 159, 64, 1)'
            //                 ],
            //                 borderWidth: 1
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             plugins: {
            //                 legend: {
            //                     display: true,
            //                     position: 'top'
            //                 }
            //             }
            //         }
            //     });
            // } catch (error) {
            //     console.error('Error fetching chart data for category transactions:', error);
            // }
        },

        datatableReports() {
            return {
                filters: { name: '', category: '', price: '', sub_category: '' },
                currentPage: 1,
                totalPages: 1,
                sortField: 'id',
                sortDirection: 'asc',
                stockOutCount: 0,
                subCategories: [],
                isStockOut: false,

                async loadData(periode = '', receipt_number = '') {
                    const params = new URLSearchParams({
                        periode: periode,
                        receipt_number: receipt_number,
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
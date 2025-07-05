
function initReports() {
    return {
        periode: 'daily',
        tipe: 'all',
        chart: null,
        data: [],
        search: '',
        async onLoad() {
            let a = await this.datatableReports().loadData(this.tipe, this.periode);
            this.data = a;
            this.fetchData();
        },

        async setTipe(tipe) {
            this.tipe = tipe;
            let a = await this.datatableReports().loadData(this.tipe, this.periode);
            this.data = a;
            this.fetchData();
        },

        async setPeriode(periode) {
            this.periode = periode;
            let a = await this.datatableReports().loadData(this.tipe, this.periode);
            this.data = a;
            this.fetchData();
        },

        async cariTransaksi(search) {
            let a = await this.datatableReports().loadData(this.tipe, this.periode, search);
            this.data = a;
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

                const response = await fetch(`/api/transaksi/chart/${this.tipe}/${this.periode}`, {
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

                async loadData(tipe = '', periode = '', search = '', page = 1) {
                    const params = new URLSearchParams({
                        tipe: tipe,
                        periode: periode,
                        search: search,
                        page: page,
                    });
                    const response = await fetch(`/api/transaksi/datatable?${params.toString()}`, {
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

        modal() {
            return {
                form: {
                    id: '',
                    tanggal: new Date().toISOString().slice(0, 10),
                    tipe: '',
                    kategori_id: '',
                    jumlah: '',
                    deskripsi: ''
                },
                isOpen: false,
                tipeModals: 'tambah',
                semuaKategori: [],
                listKategori: [],
                open() {
                    this.isOpen = true;
                    this.tipeModals = 'tambah';
                    this.getKategori();
                },
                reset() {
                    this.id = '';
                    this.form.tanggal = new Date().toISOString().slice(0, 10);
                    this.form.tipe = '';
                    this.form.kategori_id = '';
                    this.form.jumlah = '';
                    this.form.deskripsi = '';
                    this.listKategori = [];
                },
                close() {
                    this.isOpen = false;
                    this.reset();
                },
                setTipe(tipe) {

                    if (tipe == '') {
                        this.form.tipe = 1;
                    }
                    if (tipe == 2) {
                        this.listKategori = this.semuaKategori.pengeluaran;
                    } else {
                        this.listKategori = this.semuaKategori.pemasukan;
                    }
                },
                save() {

                    const formData = new FormData();
                    for (const key in this.form) {
                        formData.append(key, this.form[key]);
                    }

                    fetch('/api/transaksi', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            Alpine.store('initReports').onLoad();
                            this.reset();
                            this.close();
                        })
                        .catch(error => {
                            console.error('Error saving transaksi:', error);
                        });
                },
                edit(index, id) {
                    this.isOpen = true;
                    this.tipeModals = 'edit';
                    let a = Alpine.store('initReports').data.transaksi[index];
                    a = a.find(data => data.id === id);
                    this.form = { ...a };

                    if (this.semuaKategori.length === 0) {
                        this.getKategori();
                    }

                    if (a.tipe == 2) {
                        this.listKategori = this.semuaKategori.pengeluaran;
                    } else {
                        this.listKategori = this.semuaKategori.pemasukan;
                    }
                },
                destroy() {
                    if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                        fetch(`/api/transaksi/${this.form.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrf_token
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                Alpine.store('initReports').onLoad();
                                this.reset();
                                this.close();
                            })
                            .catch(error => {
                                console.error('Error deleting transaksi:', error);
                            });
                    }
                },
                getKategori() {
                    fetch('/api/kategori', {
                        method: 'GET',
                        credentials: 'include',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            this.semuaKategori = data;
                        })
                        .catch(error => {
                            console.error('Error fetching kategori:', error);
                        });
                }
            }
        }
    }
}
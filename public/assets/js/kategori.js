function initKategori() {
    return {
        tambah(tipe) {
            const kategori = prompt('Masukkan nama kategori:');
            if (kategori) {
                const formData = new FormData();
                formData.append('nama_kategori', kategori);
                formData.append('tipe', tipe);

                fetch('/api/kategori', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        this.reload();
                    })
                    .catch(error => {
                        alert('Error menambah kategori:', error);
                    });
            }
        },
        edit(id, nama_kategori, tipe) {
            const kategori = prompt('Masukkan nama kategori baru:', nama_kategori);
            if (kategori) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('nama_kategori', kategori);
                formData.append('tipe', tipe);

                fetch('/api/kategori', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        this.reload();
                    })
                    .catch(error => {
                        alert('Error menambah kategori:', error);
                    });
            }
        },
        destroy(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                fetch(`/api/kategori/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        this.reload();
                    })
                    .catch(error => {
                        alert('Error deleting kategori:', error);
                    });
            }
        },
        reload() {
            window.location.reload();
        }
    }
}
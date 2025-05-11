<div id="modalEditProduct" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg">
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Produk
                </h3>
                <button onclick="closeModal('modalEditProduct')" type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="editProductForm" enctype="multipart/form-data" class="max-w-lg mx-2 p-6 bg-white space-y-2">
                @csrf

                <input type="hidden" name="id" />
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="price"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <!-- Gambar Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <input type="file" name="image" id="gambarInput" accept="image/*" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0 file:text-sm file:font-semibold
                       file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>
                <!-- Preview -->
                <div id="editPreviewContainer" class="hidden mt-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img id="editPreviewImage" src="#" alt="Preview"
                        class="w-32 h-32 object-cover rounded-lg shadow border">
                </div>

                <!-- Submit -->
                <div class="flex justify-between space-x-2">
                    <button type="button" onclick="saveEditProduct()"
                        class="flex-1 bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Simpan</button>
                    <button type="button" id="deleteButton"
                        class="flex-1 bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Delete</button>
                </div>
            </form>
            <div id="responseMsg" class="mt-4 text-sm text-green-600 hidden">Form submitted!</div>
        </div>
    </div>
</div>
<script>

    function editProduct(productId) {
        document.getElementById('modalEditProduct').classList.remove('hidden');
        fetch(`{{ route('product.show') }}`, {
            method: 'POST',
            body: JSON.stringify({ id: productId }),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editProductForm');
                const editPreviewImage = form.querySelector('#editPreviewImage');

                form.querySelector('input[name="id"]').value = data.id;
                form.querySelector('input[name="name"]').value = data.name;
                form.querySelector('input[name="price"]').value = data.price;
                form.querySelector('input[name="stock"]').value = data.stock;
                editPreviewImage.src = `/assets/images/products/${data.image}`;
                form.querySelector('#editPreviewContainer').classList.remove('hidden');
                // form.querySelector('#saveButton').setAttribute('onclick', `saveEditProduct(${productId})`);
                form.querySelector('#deleteButton').setAttribute('onclick', `deleteProduct(${productId})`);
            })
            .catch(error => console.error('Error fetching product data:', error));
    }

    function saveEditProduct() {
        const form = document.getElementById('editProductForm');
        const formData = new FormData(form);

        fetch(`{{ route('product.update') }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil diperbarui.',
                    });
                    reloadDataTable('productTable');
                    closeModal('modalEditProduct');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui produk.',
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function deleteProduct(productId) {
        showSweetAlert('dialog', 'Apakah Anda yakin?', 'Produk ini akan dihapus secara permanen!', 'warning', 'Ya, hapus!', 'Batal')
            .then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('product.delete') }}`, {
                        method: 'DELETE',
                        body: JSON.stringify({ id: productId }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Produk telah dihapus.',
                                    'success'
                                );
                                reloadDataTable('productTable');
                                closeModal('modalEditProduct');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus produk.',
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
    };

    document.getElementById('gambarInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const editPreviewImage = document.getElementById('editPreviewImage');
                editPreviewImage.src = e.target.result;
                document.getElementById('editPreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('editPreviewContainer').classList.add('hidden');
        }
    });
</script>
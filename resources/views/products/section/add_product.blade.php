<div id="modalAddProduct" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Produk
                </h3>
                <button onclick="closeModal('modalAddProduct')" type="button"
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
            <form id="addProductForm" enctype="multipart/form-data"
                class="max-w-lg mx-2 p-6 bg-white rounded-xl shadow-md space-y-2">
                @csrf
                <!-- Nama -->
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
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <input type="file" name="image" id="gambarInput" accept="image/*" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0 file:text-sm file:font-semibold
                       file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>
                <!-- Preview -->
                <div id="previewContainer" class="hidden mt-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img id="previewImage" src="#" alt="Preview"
                        class="w-32 h-32 object-cover rounded-lg shadow border">
                </div>

                <button type="button" onclick="saveProduct()"
                    class="w-full bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('gambarInput');
    const previewImage = document.getElementById('previewImage');
    const previewContainer = document.getElementById('previewContainer');

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            previewImage.src = '#';
        }
    });

    async function saveProduct() {
        const form = document.getElementById('addProductForm');
        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('product.store') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Server error: ' + response.statusText);
            }

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Produk berhasil ditambahkan!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });

            reloadDataTable('productTable');
            closeModal('modalAddProduct');

            form.reset();
            previewImage.src = '#';

        } catch (error) {
            console.error('Error:', error);
            alert('Submission failed: ' + error.message);
        }
    };
</script>
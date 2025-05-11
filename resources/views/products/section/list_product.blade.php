<link rel="stylesheet" href="{{ asset('/assets/css/dataTables.tailwindcss.css') }}">
<script src="{{ asset('/assets/js/jquery.js') }}"></script>
<script src="{{ asset('/assets/js/dataTables.js') }}"></script>
<script src="{{ asset('/assets/js/dataTables.tailwindcss.js') }}"></script>

<table id="productTable" class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2 w-5">#</th>
            <th class="border border-gray-300 px-4 py-2 w-5">ID</th>
            <th class="border border-gray-300 px-4 py-2 w-50">Nama Produk</th>
            <th class="border border-gray-300 px-4 py-2 w-15">Harga</th>
            <th class="border border-gray-300 px-4 py-2 w-13">Stok</th>
            <th class="border border-gray-300 px-4 py-2 w-12">Image</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50],
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('product.list.datatable') }}",
            "columns": [
                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "render": function (data, type, row) {
                        return `
                        <button onclick="editProduct(${row.id})" type="button" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 text-center inline-flex items-center me-2 mb-2">
                            <i class="fas fa-edit mr-1"></i>edit
                        </button>
                        `;
                    }
                },
                { "data": "id" },
                { "data": "name" },
                {
                    "data": "price",
                    "render": function (data, type, row) {
                        return numberWithCommas(data);
                    }
                },
                { "data": "stock" },
                {
                    "data": "image", "render": function (data, type, row) {
                        return `
                            <img src="/assets/images/products/${data}" alt="${row.name}" class="w-5 h-5 object-cover mx-auto" 
                                onmouseover="this.style.width='100px'; this.style.height='100px';" 
                                onmouseout="this.style.width='20px'; this.style.height='20px';">
                        `;
                    }
                }
            ]
        });
    });

</script>
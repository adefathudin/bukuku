@include('_layouts.header')

<div x-data="datatable()" x-init="loadData()" class="p-4">
    <div class="mb-4 space-x-2">
        <button @click="setCategory('All')" class="px-3 py-1 bg-gray-200 rounded">All</button>
        <button @click="setCategory('Electronics')" class="px-3 py-1 bg-gray-200 rounded">Electronics</button>
        <button @click="setCategory('Books')" class="px-3 py-1 bg-gray-200 rounded">Books</button>
        <button @click="setCategory('Food')" class="px-3 py-1 bg-gray-200 rounded">Food</button>
    </div>
    <table class="min-w-full text-sm text-left border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th @click="sortBy('name')" class="cursor-pointer px-2 py-1 border">Name</th>
                <th @click="sortBy('category')" class="cursor-pointer px-2 py-1 border">Category</th>
                <th @click="sortBy('price')" class="cursor-pointer px-2 py-1 border">Price</th>
            </tr>
            <tr>
                <th><input x-model="filters.name" @input.debounce.500ms="loadData" class="w-full border px-1"></th>
                <th><input x-model="filters.category" @input.debounce.500ms="loadData" class="w-full border px-1"></th>
                <th><input x-model="filters.price" @input.debounce.500ms="loadData" class="w-full border px-1"></th>
            </tr>
        </thead>
        <tbody>
            <template x-for="row in rows" :key="row.id">
                <tr>
                    <td class="border px-2 py-1" x-text="row.name"></td>
                    <td class="border px-2 py-1" x-text="row.category"></td>
                    <td class="border px-2 py-1" x-text="row.price"></td>
                </tr>
            </template>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex items-center gap-2 mt-4">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Prev</button>

        <template x-for="page in totalPages">
            <button @click="changePage(page)" x-text="page" :class="{'bg-blue-500 text-white': currentPage === page}"
                class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300"></button>
        </template>

        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next</button>
    </div>
</div>

<script>
    function datatable() {
        return {
            filters: { name: '', category: '', price: '' },
            rows: [],
            currentPage: 1,
            totalPages: 1,
            sortField: 'name',
            sortDirection: 'asc',

            loadData() {
                const params = new URLSearchParams({
                    name: this.filters.name,
                    category: this.filters.category,
                    price: this.filters.price,
                    page: this.currentPage,
                    sort: this.sortField,
                    direction: this.sortDirection
                });

                fetch(`/api/reports/test?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        this.rows = data.data;
                        this.currentPage = data.current_page;
                        this.totalPages = data.last_page;
                    });
            },

            setCategory(value) {
                this.filters.category = value === 'All' ? '' : value;
                this.currentPage = 1;
                this.loadData();
            },

            sortBy(field) {
                if (this.sortField === field) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortField = field;
                    this.sortDirection = 'asc';
                }
                this.loadData();
            },

            changePage(page) {
                if (page >= 1 && page <= this.totalPages) {
                    this.currentPage = page;
                    this.loadData();
                }
            }
        }
    }
</script>


@include('_layouts.footer')
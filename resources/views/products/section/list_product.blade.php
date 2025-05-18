<div x-data="$store.datatableListProduct" x-init="$store.datatableListProduct.loadData()">
    <div class="flex justify-between mb-4">
        <div class="flex items-center gap-2">
            <span class="w-full">Filter by:</span>
            <select
                class="bg-gray-50 cursor-pointer border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                x-on:change="setCategory($event.target.options[$event.target.selectedIndex].text, $event.target.value)">
                <option value="" selected>- All Category -</option>
                <template x-for="category in categories" :key="category.id">
                    <option x-bind:value="category.id" x-text="category.name"></option>
                </template>
            </select>

        </div>
        <h2 class="text-2xl font-bold dark:text-white">Products</h2>
        <div class="flex justify-end gap-2">
            <button type="button" @click="$store.modalsProduct.open('add')"
                class="text-gray-900 bg-white cursor-pointer hover:bg-gray-100 border border-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-sm text-sm px-2 text-center inline-flex items-center">Add
                new
            </button>
            <a href="/products/categories"
                class="text-gray-900 bg-white cursor-pointer hover:bg-gray-100 border border-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-sm text-sm px-2 text-center inline-flex items-center">Manage
                Categories
            </a>
            <button type="button" @click="setFilterStockOut()" :class="isStockOut ? 'text-red-500 bg-cyan-100' : ''"
                class="text-gray-900 bg-white cursor-pointer hover:bg-gray-100 border border-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-sm text-sm px-2 text-center inline-flex items-center"
                x-text="`Stock Out ${stockOutCount} items`">
            </button>
            <button type="button" @click="setFilterNonCategory()"
                :class="isNonCategory ? 'text-red-500 bg-cyan-100' : ''"
                class="text-gray-900 bg-white cursor-pointer hover:bg-gray-100 border border-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-sm text-sm px-2 text-center inline-flex items-center"
                x-text="`Product non Category ${nonCategory} items`">
            </button>
        </div>
    </div>
    <div class="py-2 bg-white overflow-auto">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr class="text-gray-700">
                        <th class="px-4 py-2 cursor-pointer" @click="sortBy('id')">ID</th>
                        <th class=" px-4 py-2 cursor-pointer" @click="sortBy('name')">Product Name</th>
                        <th class="px-4 py-2 cursor-pointer text-right" @click="sortBy('price')">Price</th>
                        <th class="px-4 py-2 cursor-pointer" @click="sortBy('stock')">Stock</th>
                        <th class="px-4 py-2 cursor-pointer" @click="sortBy('category_name')">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="row in rows" :key="row.id">
                        <tr class="hover:bg-gray-200 hover:cursor-pointer odd:bg-white even:bg-gray-100"
                            @click="$store.modalsProduct.open('edit', row.id)">
                            <td class="px-4 py-2" x-text="row.id"></td>
                            <td class="px-4 py-2" x-text="row.name"></td>
                            <td class="px-4 py-2 text-right" x-text="numberWithCommas(row.price)"></td>
                            <td class="px-4 py-2" x-text="row.stock"></td>
                            <td class="px-4 py-2" x-text="row.category_name"></td>
                        </tr>
                    </template>
                    <tr x-show="rows.length === 0">
                        <td colspan="7" class="text-center text-gray-400 py-4">No data available.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between mt-4 text-sm">
            <div>
                Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span>
            </div>
            <span x-text="`Sort by ${sortField} ${sortDirection}`"></span>
            <div class="space-x-2">
                <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                    class="cursor-pointer px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50  disabled:cursor-not-allowed">
                    Prev
                </button>
                <template x-for="page in totalPages">
                    <button @click="changePage(page)" x-text="page"
                        :class="{'opacity-50 cursor-not-allowed': currentPage === page}"
                        class="cursor-pointer px-3 py-1 rounded bg-gray-200 hover:bg-gray-300"></button>
                </template>
                <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
                    class="cursor-pointer px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('datatableListProduct', initProducts().datatableListProduct());
    });
</script>

@include('products.section.edit_product')
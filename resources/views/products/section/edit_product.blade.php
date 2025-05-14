<div x-data="$store.productModal" x-show="$store.productModal.isOpen" @keydown.escape.window="close" x-ref="editModal"
    class="fixed inset-0 z-50 flex items-center overflow-auto justify-center bg-black bg-opacity-50" x-cloak>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Produk</h3>
                <button @click="close"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitForm" class="max-w-lg mx-2 p-6 bg-white space-y-2">
                <input type="hidden" name="id" :value="product.id">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" x-model="product.name"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" x-model="product.price"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" x-model="product.stock"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" x-model="product.category_id"
                        x-on:change="setCategoryId($event.target.value)"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                        <template x-for="category in categories" :key="category.id">
                            <option x-bind:value="category.id" x-text="category.name"
                                :selected="category.id === category_id"></option>
                        </template>
                    </select>
                </div>

                <div x-show="sub_categories.length > 0">
                    <label class="block text-sm font-medium text-gray-700">Sub Category</label>
                    <select name="sub_category_id" x-model="product.sub_category_id"
                        class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500"
                        x-on:change="setSubCategoryId($event.target.value)">
                        <template x-for="sub in sub_categories" :key="sub.id">
                            <option x-bind:value="sub.id" x-text="sub.name" :selected="sub.id === sub_category_id">
                            </option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" x-ref="imageInput" @change="previewImage($event)" accept="image/*" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>

                <div x-show="previewUrl" class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img :src="previewUrl" class="w-32 h-32 object-cover rounded-lg shadow border">
                </div>

                <div class="flex justify-between space-x-2">
                    <button type="submit"
                        class="flex-1 bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Save</button>
                    <button type="button" @click="deleteProduct"
                        class="flex-1 bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Delete</button>
                </div>
            </form>

            <div x-show="responseMessage" class="mt-4 text-sm text-green-600">Form submitted!</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('productModal', initProducts().editProductModal());
    });
    let csrf_token = `{{ csrf_token() }}`;
</script>
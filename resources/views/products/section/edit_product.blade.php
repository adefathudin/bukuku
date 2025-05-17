<div x-data="$store.modalsProduct" x-show="$store.modalsProduct.isOpen" @keydown.escape.window="close" x-ref="editModal"
    class="fixed inset-0 z-50 flex items-center overflow-auto justify-center bg-black/50" x-cloak>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg">
            <form @submit.prevent="submitForm" class="max-w-lg mx-2 p-6 bg-white space-y-2">
                <input type="hidden" name="id" :value="product.id">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" x-model="product.name"
                        class="mt-1 w-full rounded-md border border-cyan-500 focus:ring-cyan-50">
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

                <div class="flex justify-between space-x-2 mt-4">
                    <button type="submit"
                        class="flex-1 bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Save</button>
                    <button type="button" x-show="modalType === 'edit'" @click="deleteProduct"
                        class="flex-1 bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Delete</button>
                    <button type="button" @click="close"
                        class="bg-gray-300 flex-1 py-2 rounded-md hover:bg-gray-400">Close</button>
                </div>
            </form>

            <div x-show="responseMessage" class="mt-4 text-sm text-green-600">Form submitted!</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modalsProduct', initProducts().modalsProduct());
    });
    let csrf_token = `{{ csrf_token() }}`;
</script>
@include('_layouts.header')

<script src="{{ asset('assets/js/products.js') }}"></script>

<div x-data="initCategories" x-init="init()" class="overflow-auto w-full mb-4">
    <h2 class="text-2xl font-bold text-center p-4 bg-white mb-2">Management Categories</h2>
    <div class="flex gap-2">
        <div class="w-full">
            <table class="min-w-full border bg-white border-gray-200">
                <thead class="font-bold">
                    <tr>
                        <td class="px-4 py-2">ID</td>
                        <td class="px-4 py-2">Name</td>
                        <td class="px-4 py-2">Description</td>
                    </tr>
                </thead>
                <template x-for="(row,index) in data" :key="index">
                    <tbody>
                        <tr class="bg-white cursor-pointer hover:bg-gray-200" @click="editCategory(row.id)">
                            <td class="px-4 py-2" x-text="row.id"></td>
                            <td class="px-4 py-2" x-text="row.name"></td>
                            <td class="px-4 py-2" x-text="row.description"></td>
                        </tr>
                    </tbody>
                </template>
            </table>
        </div>
        <div class="flex">
            <form @submit.prevent="submitForm" class="bg-white p-6 min-w-[300px] flex flex-col gap-4">
                <div>
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" x-model="editCategories.name" class="w-full border px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <textarea x-model="editCategories.description" class="w-full border px-3 py-2"></textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="bg-cyan-500 text-white px-4 py-2 hover:bg-blue-600">
                        Save
                    </button>
                    <button type="button" @click="deleteCategory(editCategories.id)" :disabled="!editCategories.id"
                        class="bg-red-500 text-white px-4 py-2 hover:bg-red-600">Delete</button>
                    <button type="button" @click="editCategories = []"
                        class="bg-gray-300 px-4 py-2 hover:bg-gray-400">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let csrf_token = `{{ csrf_token() }}`;
</script>

@include('_layouts.footer')
@include('_layouts.header')

<script src="{{ asset('assets/js/users.js') }}"></script>

<div x-data="initUsers" x-init="init()" class="overflow-auto w-full mb-4">
    <h2 class="text-2xl font-bold text-center p-4 bg-white mb-2">Management Users</h2>
    <div class="flex gap-2">
        <div class="w-full">
            <table class="min-w-full border bg-white border-gray-200">
                <thead class="font-bold">
                    <tr>
                        <td class="px-4 py-2">Name</td>
                        <td class="px-4 py-2">Email</td>
                        <td class="px-4 py-2">Role</td>
                        <td class="px-4 py-2">Status</td>
                    </tr>
                </thead>
                <template x-for="(row,index) in data" :key="index">
                    <tbody>
                        <tr class="bg-white cursor-pointer hover:bg-gray-200" @click="editUser(row.id)">
                            <td class="px-4 py-2" x-text="row.name"></td>
                            <td class="px-4 py-2" x-text="row.email"></td>
                            <td class="px-4 py-2" x-text="row.role"></td>
                            <td class="px-4 py-2" x-text="row.active"></td>
                        </tr>
                    </tbody>
                </template>
            </table>
        </div>
        <div class="flex">
            <form @submit.prevent="submitForm" class="bg-white p-6 min-w-[300px] flex flex-col gap-4">
                <div>
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" x-model="editUserData.name" class="w-full border px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" x-model="editUserData.email" class="w-full border px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Role</label>
                    @if(auth()->user()->role === 'admin')
                    <select x-model="editUserData.role" class="w-full border px-3 py-2" required>
                        <option value="">Select role</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                    @else
                    <input type="text" x-model="editUserData.role" class="w-full border px-3 py-2 bg-gray-100" readonly>
                    @endif
                </div>
                <div>
                    <label class="block mb-1 font-medium">Status</label>
                    @if(auth()->user()->role === 'admin')
                    <select x-model="editUserData.active" class="w-full border px-3 py-2" required>
                        <option value="Y">Active</option>
                        <option value="N">Nonactive</option>
                    </select>
                    @else
                    <input type="text" x-model="editUserData.active ? 'active' : ''"
                        class="w-full border px-3 py-2 bg-gray-100" readonly>
                    @endif
                </div>
                <div>
                    <label class="block mb-1 font-medium">Password</label>
                    <input type="password" x-model="editUserData.password" class="w-full border px-3 py-2">
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="bg-cyan-500 text-white px-4 py-2 hover:bg-blue-600">
                        Save
                    </button>
                    <button type="button" @click="editUserData = []"
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
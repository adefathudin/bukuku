@include('_layouts.header')

<script src="{{ asset('assets/js/users.js') }}"></script>

<div x-data="initUsers" x-init="init()" class="overflow-auto w-full mb-4">
    <div class="flex justify-between p-2 bg-white mb-2">
        <h2 class="text-xl font-bold p-2 text-center">Management Users</h2>
        <div class="flex gap-2">
            <button type="button" @click="addUser()"
                class="border-1 border-gray-200 px-4 py-2 rounded cursor-pointer hover:bg-gray-100">
                Add User
            </button>
            <button type="button" @click="editUser()" :disabled="!editButton"
                :class="editButton ? 'bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600' : 'bg-blue-400 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed'">
                Edit
            </button>
            <button type="button" @click="deleteUser()" :disabled="!deleteButton"
                :class="deleteButton ? 'bg-red-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-red-600' : 'bg-red-400 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed'">
                Delete
            </button>
        </div>
    </div>
    <div class="flex gap-2">
        <div class="w-full">
            <table class="min-w-full border bg-white border-gray-200">
                <thead class="font-bold">
                    <tr>
                        <td class="px-4 py-2">No</td>
                        <td class="px-4 py-2">ID</td>
                        <td class="px-4 py-2">Name</td>
                        <td class="px-4 py-2">Email</td>
                        <td class="px-4 py-2">Role</td>
                        <td class="px-4 py-2">Active</td>
                        <td class="px-4 py-2">Created</td>
                    </tr>
                </thead>
                <template x-if="data.length === 0">
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center py-4">No users found</td>
                        </tr>
                    </tbody>
                </template>
                <template x-for="(row,index) in data" :key="index">
                    <tbody>
                        <tr :class="row.id === editUserData.id ? 'bg-blue-100 cursor-pointer' : 'bg-white cursor-pointer hover:bg-blue-100'"
                            @click="selectUser(row.id)">
                            <td class="px-4 py-2" x-text="index + 1"></td>
                            <td class="px-4 py-2" x-text="row.id"></td>
                            <td class="px-4 py-2" x-text="row.name"></td>
                            <td class="px-4 py-2" x-text="row.email"></td>
                            <td class="px-4 py-2" x-text="row.role"></td>
                            <td class="px-4 py-2" x-text="row.active"></td>
                            <td class="px-4 py-2" x-text="row.created_at"></td>
                        </tr>
                    </tbody>
                </template>
            </table>
        </div>
        <div class="flex" x-show="showForm">
            <div class="bg-gray-100 p-4 w-full">
                <h3 class="text-center font-bold mb-4 p-4 bg-blue-100" x-text="formTitle"></h3>
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
                        <input type="text" x-model="editUserData.role" class="w-full border px-3 py-2 bg-gray-100"
                            readonly>
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
                        <button type="submit" class="bg-cyan-500 text-white px-4 py-2 hover:bg-cyan-600">
                            Save
                        </button>
                        <button type="button" @click="editUserData = []"
                            class="bg-gray-300 px-4 py-2 hover:bg-gray-400">Clear
                        </button>
                        <button type="button" @click="showForm = false"
                            class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600">Close
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let csrf_token = `{{ csrf_token() }}`;
    </script>

    @include('_layouts.footer')
@include('_layouts.header')

<script src="{{ asset('assets/js/users.js') }}"></script>

<div x-data="initUsers" x-init="userDetails()" class="overflow-auto w-full mb-4">

    <div class="flex justify-between p-2 bg-white mb-2">
        <h2 class="text-xl font-bold p-2 text-center">Profile</h2>
        <a href="{{ route('logout') }}"
            class="items-center cursor-pointer p-2 text-gray-900 rounded-lg border-red-200 border-1 dark:text-white hover:border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fas fa-sign-out-alt"></i>
            <span class="ms-3">Logout</span>
        </a>
    </div>

    <div class="flex gap-2">
        <div class="w-2/5">
            <ul class="bg-white rounded shadow p-4 mb-4 text-gray-800">
                <li class="flex items-center border-b border-gray-200 py-2">
                    <span class="mr-4">ID: </span>
                    <span x-text="editUserData.id"></span>
                </li>
                <li class="flex items-center border-b border-gray-200 py-2">
                    <span class="mr-4">Role: </span>
                    <span x-text="editUserData.role"></span>
                </li>
                <li class="flex items-center border-b border-gray-200 py-2">
                    <span class="mr-4">Status: </span>
                    <span x-text="editUserData.active ? 'Active' : 'Nonactive'"></span>
                </li>
                <li class="flex items-center border-b border-gray-200 py-2">
                    <span class="mr-4">Created at: </span>
                    <span x-text="editUserData.created_at"></span>
                </li>
                <li class="flex items-center border-b border-gray-200 py-2">
                    <span class="mr-4">Updated at: </span>
                    <span x-text="editUserData.updated_at"></span>
                </li>
            </ul>
        </div>
        <div class="w-3/5">
            <form @submit.prevent="updateProfile" class="bg-white p-6 min-w-[300px] flex flex-col gap-4">
                <div>
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" x-model="editUserData.name" class="w-full border border-gray-200 px-3 py-2"
                        required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" x-model="editUserData.email" class="w-full border border-gray-200 px-3 py-2"
                        required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Password</label>
                    <input type="password" x-model="editUserData.password"
                        class="w-full border border-gray-200 px-3 py-2">
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="cursor-pointer bg-cyan-500 text-white px-4 py-2 hover:bg-blue-600">
                        Save
                    </button>
                    <button type="button" @click="editUserData = []"
                        class="bg-gray-300 px-4 py-2 hover:bg-gray-400">Clear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let csrf_token = `{{ csrf_token() }}`;
    </script>

    @include('_layouts.footer')
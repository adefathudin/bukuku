<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-48 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 flex flex-col justify-between">
        <ul class="space-y-2 font-medium">
            @foreach ($menus['menu'] as $item)
            <li>
                <a href="{{ $item['url'] }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="ms-3">{{ $item['name'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
        <a href="{{ route('logout') }}"
            class="w-full flex items-center cursor-pointer p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fas fa-sign-out-alt"></i>
            <span class="ms-3">Logout</span>
        </a>
    </div>
</aside>
<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-48 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 flex flex-col justify-between">
        <ul class="space-y-2 font-medium">
            @foreach ($menus['menu'] as $item)
            @if (isset($item['role']) && !in_array(Auth::user()->role, $item['role']))
            @continue
            @endif
            <li>
                <a href="{{ $item['url'] }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="ms-3">{{ $item['name'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
        <a href="{{ route('users.profile') }}"
            class="cursor-pointer hover:bg-gray-100 hover:border-blue-200 hover:border-1">
            <div class="flex items-center space-x-3 p-2 mb-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" alt="User Avatar"
                    class="w-10 h-10 rounded-full object-cover">
                <span class="text-gray-900 dark:text-white font-semibold">{{ Auth::user()->name }}</span>
            </div>
        </a>

    </div>
</aside>
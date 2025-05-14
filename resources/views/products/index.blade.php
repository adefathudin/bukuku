@include('_layouts.header')

<script src="{{ asset('assets/js/products.js') }}"></script>
<div x-data="initProducts()" x-init="init()" class="bg-white ">

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-semibold text-center">
            <template x-for="menu in menus" :key="menu">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 rounded-t-lg cursor-pointer hover:text-cyan-500 hover:border-b-2 hover:border-[#00bcd4] dark:hover:text-gray-300"
                        :class="{ 'border-b-2 border-[#00acc1] text-cyan-600': activeMenu === menu }"
                        x-on:click="activeMenu = menu" x-text="menu"></button>
                </li>
            </template>
        </ul>
    </div>

    <div>
        <div x-show="activeMenu == 'Products'" class="px-2">

            @include('products.section.list_product')
        </div>
        <div x-show="activeMenu == 'Category'" class="px-2">

        </div>
    </div>
</div>

@include('_layouts.footer')
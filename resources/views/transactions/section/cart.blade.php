<!-- empty cart -->
<div x-show="cart.length === 0"
    class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <p>
        CART EMPTY
    </p>
</div>

<!-- cart items -->
<div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
    <div class="h-16 flex items-center justify-between px-4">
        <div class="relative flex items-center">
            <i class="fas fa-shopping-cart text-lg"></i>
            <div x-show="getItemsCount() > 0"
                class="absolute bg-cyan-500 text-white w-5 h-5 text-xs leading-5 rounded-full -top-2 -right-2 flex items-center justify-center"
                x-text="getItemsCount()"></div>
        </div>
        <div class="text-lg font-semibold text-gray-700" x-text="`Rp${priceFormat(getTotalPrice())}`">
        </div>
        <div>
            <button x-on:click="clearCart()" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                <i class="fas fa-trash-alt hover:text-red-500"></i>
            </button>
        </div>
    </div>
    <div class="flex-1 w-full px-1 overflow-auto">
        <template x-for="item in cart" :key="item.id">
            <div class="select-none border-b border-white bg-blue-gray-50 w-full text-blue-gray-700 py-2 px-2 flex justify-center hover:cursor-pointer"
                :title="item.name">
                <img x-bind:src="'/assets/images/products/' + item.image" alt=""
                    class="rounded-lg object-cover h-10 w-10 bg-white shadow mr-2">
                <div class="flex-grow"
                    x-on:click="cart.forEach(i => i.showOptions = false); item.showOptions = !item.showOptions">
                    <h5 class="text-sm line-clamp-1 cursor-pointer" x-text="item.name"></h5>
                    <p class="text-xs block"
                        x-text="`${priceFormat(item.price)} x ${item.qty} = ${priceFormat(item.price * item.qty)}`"></p>
                </div>
                <div class="py-1">
                    <div class="mr-2">
                        <!-- <div class="w-44 grid grid-cols-4 gap-4 ml-4">
                        <button x-on:click="updateCart(item, -1)"
                            class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 hover:cursor-pointer focus:outline-none">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input x-model.number="item.qty" type="text" disabled
                            class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm">
                        <button x-on:click="updateCart(item, 1)"
                            class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 hover:cursor-pointer focus:outline-none">
                            <i class="fas fa-plus"></i>
                        </button> -->
                        <button x-on:click="updateCart(item, -(item.qty))"
                            class="py-1 text-blue-gray-300 hover:text-pink-500 focus:outline-none hover:cursor-pointer">
                            <i class="fas fa-trash-alt hover:text-red-500"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
<div class="flex flex-col bg-blue-gray-50 h-full w-full">
    <div class="flex flex-row relative">
        <div class="absolute left-2 top-1 px-2 py-1">
            <i class="fas fa-search"></i>
        </div>
        <input type="text"
            class="bg-white shadow text-sm full w-full h-10 py-2 pl-12 transition-shadow focus:shadow-2xl focus:outline-none"
            placeholder="Cari produk..." x-model="keyword" />
    </div>
    <div class="h-full overflow-hidden mt-2">
        <div class="h-full overflow-y-auto">
            <div class="select-none bg-blue-gray-100 flex flex-wrap content-center justify-center h-full opacity-25"
                x-show="products.length === 0">
                <div class="w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    <p class="text-xl">
                        YOU DON'T HAVE
                        <br />
                        ANY PRODUCTS TO SHOW
                    </p>
                </div>
            </div>
            <div class="select-none bg-blue-gray-100 flex flex-wrap content-center justify-center h-full opacity-25"
                x-show="filteredProducts().length === 0 && keyword.length > 0">
                <div class="w-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-xl">
                        EMPTY SEARCH RESULT
                        <br />
                        "<span x-text="keyword" class="font-semibold"></span>"
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 pb-3">
                <template x-for="product in filteredProducts()" :key="product.id">
                    <div role="button"
                        class="select-none cursor-pointer transition-shadow overflow-hidden rounded bg-white shadow hover:shadow-2xl"
                        :title="product.name" x-on:click="updateCart(product)">
                        <img x-bind:src="'/assets/images/products/' + product.image" alt="" :alt="product.nama_produk"
                            onerror="" class="w-24 h-24 p-2 rounded-3xl object-cover mx-auto">
                        <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                            <p class="flex-grow truncate mr-1" x-text="product.name"></p>
                        </div>
                        <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                            <p class="flex-grow nowrap font-semibold mr-1" x-text="numberWithCommas(product.price)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
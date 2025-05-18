<!-- modal receipt -->
<div x-show="isShowModalReceipt"
    class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalReceipt()"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    <div class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90">
        <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
            <div class="text-center">
                <img src="{{ asset('assets/images/logo-toko.png') }}" alt="" class="mb-2 w-24 h-24 inline-block">
                <h2 class="text-xl font-semibold" x-text="toko.nama"></h2>
                <p class="text-sm" x-text="toko.alamat"></p>
                <p class="text-xs" x-text="toko.telepon"></p>
            </div>
            <hr class="my-2">
            <div class="flex mt-4 text-xs">
                <div class="flex-grow">No: <span x-text="receipt_number"></span></div>
                <div x-text="transaction_date"></div>
            </div>
            <hr class="my-2">
            <div>
                <table class="w-full text-xs">
                    <thead>
                        <tr>
                            <th class="py-1 w-1/12 text-center">#</th>
                            <th class="py-1 text-left">Item</th>
                            <th class="py-1 w-2/12 text-center">Qty</th>
                            <th class="py-1 w-3/12 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in cart" :key="item">
                            <tr>
                                <td class="py-2 text-center" x-text="index+1"></td>
                                <td class="py-2 text-left">
                                    <span x-text="item.name"></span>
                                    <br />
                                    <small x-text="priceFormat(item.price)"></small>
                                </td>
                                <td class="py-2 text-center" x-text="item.qty"></td>
                                <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <hr class="my-2">
            <div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow text-xs">TOTAL</div>
                    <div x-text="priceFormat(getTotalPrice())"></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">TUNAI</div>
                    <div x-text="priceFormat(cash)"></div>
                </div>

                <div class="flex text-xs font-semibold">
                    <div x-show="change >= 0" class="flex-grow">KEMBALI</div>
                    <div x-text="priceFormat(change)"></div>
                </div>
            </div>
            <hr class="my-2">
            <div class="text-center text-xs mt-2">
                <p>Terima kasih telah berbelanja di toko kami</p>
                <p>Silahkan kunjungi kami kembali</p>

            </div>
        </div>
        <div class="p-4 w-full">
            <button
                class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none hover:bg-cyan-600 hover:cursor-pointer"
                x-on:click="saveTransaction()">SIMPAN DAN CETAK</button>
        </div>
    </div>
</div>

<script>
    let csrf_token = `{{ csrf_token() }}`;
</script>
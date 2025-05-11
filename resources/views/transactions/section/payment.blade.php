<div class="select-none h-auto w-full text-center pb-4 px-1">
    <!-- <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
        <div class="pl-2">Total</div>
        <div class="text-right w-full pr-4" x-text="`Rp${priceFormat(getTotalPrice())}`"></div>
    </div> -->
    <div class="mb-1 text-blue-gray-700 p-2 bg-blue-gray-50">
        <div class="flex text-ms font-semibold">
            <div class="flex-grow text-left">Cash
            </div>
            <div class="flex text-right">
                <div class="mr-2">Rp</div>
                <input x-bind:value="numberFormat(cash)" x-on:click="cart.forEach(i => i.showOptions = false)"
                    x-on:keyup="updateCash($event.target.value)" type="text"
                    class="w-52 text-right bg-white shadow rounded-sm focus:bg-white focus:shadow-lg px-2 focus:outline-none">
            </div>
        </div>
    </div>
    <div x-show="cash > 0" class="flex mb-1 text-md font-semibold bg-cyan-50 text-blue-gray-700 p-2">
        <div class="text-cyan-800">Kembali</div>
        <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(change)">
        </div>
    </div>
    <button class="text-white text-lg w-full py-2 focus:outline-none" x-bind:class="{
      'bg-cyan-500 hover:bg-cyan-600 hover:cursor-pointer': submitable(),
      'bg-blue-gray-200': !submitable()
    }" :disabled="!submitable()" x-on:click="submit()">
        PROSES
    </button>
</div>
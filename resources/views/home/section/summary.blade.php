<div class="flex-grow flex mb-2">
    <section class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
            <div class="bg-white shadow rounded-sm p-4">
                <h2 class="text-lg font-semibold">Total Transactions</h2>
                <p class="text-2xl font-bold">{{ $data->totalTransactions }}</p>
            </div>
            <div class="bg-white shadow rounded-sm p-4">
                <a href=" /products" class="block hover:underline">
                    <h2 class="text-lg font-semibold">Total Products</h2>
                    <p class="text-2xl font-bold">{{ $data->totalProducts }}</p>
                </a>
            </div>
            <div class="bg-white shadow rounded-sm p-4">
                <h2 class="text-lg font-semibold">Total Revenue</h2>
                <p class="text-2xl font-bold">{{ number_format($data->totalRevenue) }}</p>
            </div>
            <div class="bg-white shadow rounded-sm p-4">
                <h2 class="text-lg font-semibold">Out of Stock</h2>
                <p class="text-2xl font-bold">{{ $data->totalOutOfStock }}</p>
            </div>
        </div>
    </section>
</div>
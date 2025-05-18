@include('_layouts.header')

<script src="{{ asset('assets/js/reports.js') }}"></script>

<div x-data="initReports" x-init="onLoad">
    <div class="flex-grow flex gap-2">

        <div class="overflow-auto w-full mb-4">
            <div class="flex justify-between p-4 bg-white mb-2">
                <div class="flex items-center gap-2 text-sm">
                    <label>Periode:</label>
                    <select @change="setPeriode($event.target.value)"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <h2 class="text-2xl font-bold dark:text-white">Reports</h2>
                <input type="text" x-model="search" placeholder="Search by receipt number"
                    class="border border-gray-300 px-2 py-1 text-sm"
                    @keyup.enter="searchTransaction($event.target.value)">

            </div>
            <div class="bg-white">
                <table class="min-w-full text-sm border border-gray-200">
                    <thead class="font-bold bg-cyan-200">
                        <td class="px-4 py-2">Product Name</td>
                        <td class="px-4 py-2 text-right">QTY</td>
                        <td class="px-4 py-2 text-right">Total</td>
                    </thead>
                    <template x-for="(row,index) in data.data" :key="index">
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 bg-gray-100" colspan="3"
                                    x-text="`${row.receipt_number} - ${row.transaction_date} - ${row.created_name}`">
                                </td>
                            </tr>
                            <template x-for="p in row.details" :key="p.id">
                                <tr colspan="3">
                                    <td class="px-4 py-2" x-text="p.product_name"></td>
                                    <td class="px-4 py-2 text-right" x-text="p.qty"></td>
                                    <td class="px-4 py-2 text-right" x-text="numberWithCommas(p.unit_price)"></td>
                                </tr>
                            </template>
                            <tr class="bg-gray-100">
                                <td class="px-4 py-2 font-semibold text-right" colspan="2">Sub Total</td>
                                <td class="px-4 py-2 font-semibold text-right"
                                    x-text="numberWithCommas(row.total_price)">
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </table>
            </div>
            <div class="flex items-center justify-between text-sm p-2 my-4 bg-white">
                <div>
                    Page <span x-text="data.current_page"></span> of <span x-text="data.last_page"></span>
                </div>
                <div class="space-x-2">
                    <button @click="changePage(data.current_page - 1)" :disabled="data.current_page === 1"
                        class="cursor-pointer px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50  disabled:cursor-not-allowed">
                        Prev
                    </button>
                    <template x-for="page in data.last_page">
                        <button @click="changePage(page)" x-text="page"
                            :class="{'opacity-50 cursor-not-allowed': data.current_page === page}"
                            class="cursor-pointer px-3 py-1 rounded bg-gray-200 hover:bg-gray-300"></button>
                    </template>
                    <button @click="changePage(data.current_page + 1)" :disabled="data.current_page === data.last_page"
                        class="cursor-pointer px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </button>
                </div>
            </div>
        </div>
        <section>
            <div class="sticky top-2">
                <div class="p-4 bg-white">
                    <canvas x-ref="byPeriode" width="400" height="200"></canvas>
                </div>
                <div class="mt-4 space-y-2 bg-white p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Transactions:</span>
                        <span x-text="data?.summary?.total_transaction ?? 0" class="text-lg font-bold"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Revenue:</span>
                        <span x-text="data?.summary?.total_revenue ?? 0" class="text-lg font-bold"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Products Sold:</span>
                        <span x-text="data?.summary?.total_qty ?? 0" class="text-lg font-bold"></span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


@include('_layouts.footer')
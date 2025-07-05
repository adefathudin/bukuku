@include('_layouts.header')

<script src="{{ asset('assets/js/transaksi.js') }}"></script>

<div x-data="$store.initReports" x-init="$store.initReports.onLoad()">
    <div class="flex-grow flex gap-2">

        <div class="overflow-auto w-full mb-4">
            <div class="flex justify-between p-4 bg-white mb-2">
                <div class="flex gap-2">
                    <div class="flex items-center gap-2 text-sm">
                        <label>Tipe:</label>
                        <select @change="setTipe($event.target.value)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="all" selected>Semua</option>
                            <option value="1">Pemasukan</option>
                            <option value="2">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <label>Periode:</label>
                        <select @change="setPeriode($event.target.value)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="daily" selected>Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <button id="refreshData" @click="onLoad()"
                        class="px-4 py-2 cursor-pointer border border-gray-300 transition hover:bg-gray-300">Refresh</button>
                </div>
                <input type="text" x-model="search" placeholder="Search by deskripsi"
                    class="border border-gray-300 px-2 py-1 text-sm" @keyup.enter="cariTransaksi($event.target.value)">

            </div>
            <div class="bg-white">
                <table class="min-w-full text-sm border border-gray-200">
                    <thead class="font-bold bg-cyan-200">
                        <td class="px-4 py-2">Kategori</td>
                        <td class="px-4 py-2">Deskripsi</td>
                        <td class="px-4 py-2 text-right">Jumlah</td>
                    </thead>
                    <template x-for="(row,index) in data.transaksi" :key="index">
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 bg-gray-100" colspan="3">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-1 py-0.5 rounded-sm"
                                        x-text="new Date(index).toLocaleDateString('id-ID', { weekday: 'long' })"></span>
                                    <span class="font-bold place-items-center"
                                        x-text="new Date(index).getDate()"></span>
                                    <span class="text-xs"
                                        x-text="new Date(index).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })"></span>
                                </td>
                            </tr>
                            <template x-for="p in row" :key="p.id">
                                <tr colspan="3" @click="$store.modals.edit(index, p.id)"
                                    class="border-b border-gray-100 hover:bg-gray-200 cursor-pointer">
                                    <td class="px-4 py-2" x-text="p.kategori.nama_kategori"></td>
                                    <td class="px-4 py-2" x-text="p.deskripsi"></td>
                                    <td class="px-4 py-2 text-right font-semibold"
                                        :class="p.tipe === 2 ? 'text-red-500' : 'text-green-500'"
                                        x-text="`Rp${numberWithCommas(p.jumlah)}`">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </template>
                </table>
            </div>
        </div>
        <section>
            <div class="sticky top-2">
                <div class="p-4 bg-white">
                    <canvas x-ref="byPeriode" width="400" height="200"></canvas>
                </div>
                <div class="mt-4 space-y-2 bg-white p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Pemasukan:</span>
                        <span x-text="`Rp${data?.summary?.pemasukan ?? 0}`"
                            class="text-lg font-bold text-green-500"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Pengeluaran:</span>
                        <span x-text="`Rp${data?.summary?.pengeluaran ?? 0}`"
                            class="text-lg font-bold text-red-500"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Saldo Akhir:</span>
                        <span x-text="`Rp${data?.summary?.saldo ?? 0}`" class="text-lg font-bold"></span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('initReports', initReports());
    });
</script>

@include('transaksi.modals')
@include('_layouts.footer')
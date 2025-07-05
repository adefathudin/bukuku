<script src="{{ asset('assets/js/home.js') }}"></script>

<div x-data="initHome()" x-init="getChart()">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow p-6 flex flex-col">
            <div class="text-gray-500 mb-2">Total Pemasukan (Rp)</div>
            <div class="text-2xl font-bold mb-4">{{ number_format($data->totalPemasukan) }}</div>
        </div>
        <div class="bg-white shadow p-6 flex flex-col">
            <div class="text-gray-500 mb-2">Total Pengeluaran (Rp)</div>
            <div class="text-2xl font-bold mb-4">{{ number_format($data->totalPengeluaran) }}</div>
        </div>
        <div class="bg-white shadow p-6 flex flex-col">
            <div class="text-gray-500 mb-2">Saldo Akhir (Rp)</div>
            <div class="text-2xl font-bold mb-4 {{ $data->status ? 'text-green-500' : 'text-red-500' }}">{{
                number_format($data->saldoAkhir) }}</div>
        </div>
    </div>

    <div class="flex-grow flex">
        <section class="w-full">
            <div class="bg-white shadow rounded-sm p-4">
                <h2 class="text-lg font-semibold mb-4">Transaksi Minggu Ini</h2>
                <canvas id="report" width="400" height="200"></canvas>
            </div>
        </section>
    </div>
</div>
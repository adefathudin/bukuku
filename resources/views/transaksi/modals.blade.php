<!-- Speed Dial Button & Modal -->
<div x-data="$store.modals" class="fixed bottom-8 right-8 z-50">
    <!-- Speed Dial Button -->
    <div class="flex flex-col items-end space-y-2 mt-2">
        <button @click="open()"
            class="w-12 h-12 flex items-center cursor-pointer justify-center rounded-full bg-cyan-500 text-white shadow hover:bg-cyan-800 transition"
            title="Tambah transaksi">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>
    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-black/50 z-50"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">Detail Transaksi</h2>
            <form @submit.prevent="save">
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" x-model="form.tanggal" class="w-full border border-gray-300 rounded px-3 py-2"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tipe</label>
                    <select x-model="form.tipe" @change="setTipe($event.target.value)"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-Tipe-</option>
                        <option value="1">Pemasukan</option>
                        <option value="2">Pengeluaran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select x-model="form.kategori_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-Kategori-</option>
                        <template x-for="kategori in listKategori" :key="kategori.id">
                            <option :value="kategori.id" x-text="kategori.nama_kategori"></option>
                        </template>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                    <input type="number" x-model="form.jumlah" class="w-full border border-gray-300 rounded px-3 py-2"
                        required min="1">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Keterangan</label>
                    <input type="text" x-model="form.deskripsi" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-cyan-500 text-white rounded cursor-pointer hover:bg-cyan-700">Simpan</button>
                    <button type="button" x-show="tipeModals == 'edit'" @click="destroy()"
                        class="px-4 py-2 bg-red-500 text-white rounded cursor-pointer hover:bg-red-700">Delete</button>
                    <button type="reset"
                        class="px-4 py-2 bg-gray-200 rounded cursor-pointer hover:bg-gray-300">Reset</button>
                    <button type="button" @click="close()"
                        class="px-4 py-2 bg-gray-200 rounded cursor-pointer hover:bg-gray-300">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modals', initReports().modal());
    });
    let csrf_token = `{{ csrf_token() }}`;
</script>
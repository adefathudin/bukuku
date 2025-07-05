<script src="{{ asset('assets/js/kategori.js') }}"></script>

<div x-data="initKategori()">
    <div class="flex justify-between mb-2">
        <h3 class="text-xl font-semibold mb-4">Pemasukan</h3>
        <button class="bg-cyan-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-cyan-600 transition"
            @click="tambah(1)">
            Tambah Kategori
        </button>
    </div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg mb-8">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 text-left font-medium text-gray-700">Nama Kategori</th>
                <th class="py-2 px-4 text-left font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori->where('tipe', 1) as $item)
            <tr class="border-t border-gray-200 hover:bg-gray-50">
                <td class="py-2 px-4">{{ $item->nama_kategori }}</td>
                <td class="py-2 px-4 flex gap-2">
                    <button @click="edit('{{ $item->id}}', '{{$item->nama_kategori}}', 1)"
                        class="text-blue-500 hover:text-blue-700 cursor-pointer">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="destroy('{{ $item->id}}')" class="text-red-500 hover:text-red-700 cursor-pointer">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-8">

    <div class="flex justify-between mb-2">
        <h3 class="text-xl font-semibold mb-4">Pengeluaran</h3>
        <button class="bg-cyan-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-cyan-600 transition"
            @click="tambah(2)">
            Tambah Kategori
        </button>
    </div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 text-left font-medium text-gray-700">Nama Kategori</th>
                <th class="py-2 px-4 text-left font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori->where('tipe', 2) as $item)
            <tr class="border-t border-gray-200 hover:bg-gray-50">
                <td class="py-2 px-4">{{ $item->nama_kategori }}</td>
                <td class="py-2 px-4 flex gap-2">
                    <button @click="edit('{{ $item->id}}', '{{$item->nama_kategori}}', 2)"
                        class="text-blue-500 hover:text-blue-700 cursor-pointer">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button @click="destroy('{{ $item->id}}')" class="text-red-500 hover:text-red-700 cursor-pointer">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let csrf_token = `{{ csrf_token() }}`;
</script>
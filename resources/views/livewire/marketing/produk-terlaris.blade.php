<div class="bg-white rounded-lg shadow p-4 h-full">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Blok Terlaris</h2>
        <div class="w-1/3">
            <input 
                type="text" 
                wire:model.debounce.300ms="search"
                placeholder="Cari blok..." 
                class="w-full px-3 py-1 border rounded-md text-sm"
            >
        </div>
    </div>

    <table class="w-full text-sm text-left border">
    <thead class="bg-gray-100 text-gray-700 font-semibold">
        <tr>
            <th class="px-3 py-2">Gambar</th>
            <th class="px-3 py-2">Blok</th>
            <th class="px-3 py-2 text-right">Jumlah Terjual</th>
        </tr>
    </thead>
    <tbody>
    @forelse($rumahTerlaris as $blok)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-3 py-2">
                <div class="flex-shrink-0 mr-3">
                    <img src="{{ asset('img/aset1.png') }}" alt="Gambar Blok" class="w-12 h-12 object-cover rounded">
                </div>
            </td>
            <td class="px-3 py-2 font-medium">
                {{ $blok->nama_blok ?? 'Blok Tidak Ditemukan' }}
            </td>
            <td class="px-3 py-2 text-right text-green-600 font-bold">{{ $blok->total_terjual }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada data ditemukan</td>
        </tr>
    @endforelse
</tbody>
</table>

</div>

<div class="bg-white rounded-lg shadow p-4 h-full">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Status Pemesanan Terbaru</h2>
        <div class="w-1/3">
            <!-- Empty space for potential future elements -->
        </div>
    </div>

    <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100 text-gray-700 font-semibold">
            <tr>
                <th class="px-3 py-2">Gambar</th>
                <th class="px-3 py-2">Rumah</th>
                <th class="px-3 py-2">Customer</th>
                <th class="px-3 py-2">Pembayaran</th>
                <th class="px-3 py-2 text-right">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemesananTerbaru as $pemesanan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">
                        <div class="flex-shrink-0">
                            @if($pemesanan->rumah->gambar)
                                <img src="{{ asset('storage/'.$pemesanan->rumah->gambar) }}" alt="{{ $pemesanan->rumah->nama_rumah }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <img src="{{ asset('img/icon.png') }}" alt="Default Icon" class="w-12 h-12 object-cover rounded">
                            @endif
                        </div>
                    </td>
                    <td class="px-3 py-2 font-medium">
                        {{ $pemesanan->rumah->nomor_rumah }}
                    </td>
                    <td class="px-3 py-2">
                        {{ $pemesanan->customer->nama }}
                    </td>
                    <td class="px-3 py-2">
                        {{ $pemesanan->jenis_pembayaran }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        @if($pemesanan->customer->status == 'pembeli')
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Lunas</span>
                        @elseif($pemesanan->customer->status == 'booking')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Proses</span>
                        @elseif($pemesanan->customer->status == 'cancelled')
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Cancelled</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ ucfirst($pemesanan->customer->status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">
                        Tidak ada data ditemukan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
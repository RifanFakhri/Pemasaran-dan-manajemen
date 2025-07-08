<div class="bg-white rounded-lg shadow p-4 h-full">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold mt-8">Status Pemesanan Terbaru</h2>
        
    </div>

    <div class="space-y-3 mt-8">
        @forelse($pemesananTerbaru as $pemesanan)
        <div class="flex items-center p-2 hover:bg-gray-50 rounded">
            <div class="flex-shrink-0 mr-3">
                @if($pemesanan->rumah->gambar)
                    <img src="{{ asset('storage/'.$pemesanan->rumah->gambar) }}" alt="{{ $pemesanan->rumah->nama_rumah }}" class="w-12 h-12 object-cover rounded">
                @else
                    <img src="{{ asset('img/icon.png') }}" alt="Default Icon" class="w-12 h-12 object-cover rounded">
                @endif
            </div>
            <div class="flex-grow">
                <div class="font-medium">{{ $pemesanan->rumah->nama_rumah }}</div>
                <div class="text-xs text-gray-500">
                    <span>Customer: {{ $pemesanan->customer->nama }}</span>
                    <span class="mx-2">|</span>
                    <span>Pembayaran: {{ $pemesanan->jenis_pembayaran }}</span>
                </div>
            </div>
            <div class="flex-shrink-0">
               
                @if($pemesanan->customer->status == 'pembeli')
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Lunas</span>
                @elseif($pemesanan->customer->status == 'booking')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Proses</span>
                @elseif($pemesanan->customer->status == 'cancelled')
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Cancelled</span>
                @else
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ ucfirst($pemesanan->customer->status) }}</span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 py-4">Tidak ada data ditemukan</div>
        @endforelse
    </div>
</div>
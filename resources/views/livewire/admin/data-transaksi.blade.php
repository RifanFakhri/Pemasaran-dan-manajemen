<div class="w-full px-6 py-6 mx-auto overflow-hidden">
    <div class="px-6 pt-2">
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Transaksi</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>

        <div class="flex items-center justify-between mt-2 mb-6">
            <h6>List Transaksi</h6>
            <a href="{{ route('admin.tambah-transaksi') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-2 py-2 rounded-lg shadow">
                + Tambah Transaksi
            </a>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto px-4 pt-4 pb-2">
                    <div class="relative w-64 sm:w-30 ml-auto">
                        <input
                            type="text"
                            wire:model.debounce.300ms="search"
                            wire:keydown.enter="applySearch"
                            placeholder="Search..."
                            class="px-4 py-2 border border-gray-300 rounded w-full sm:w-64 mb-4"
                        >
                        @if(strlen($search) > 0 && is_array($suggestions) && count($suggestions) > 0)
                            <div class="absolute z-10 w-full bg-white border border-gray-200 rounded mt-1 shadow-lg max-h-60 overflow-auto">
                                @foreach($suggestions as $suggestion)
                                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" 
                                         wire:click="selectSuggestion('{{ $suggestion['nama'] }}')">
                                        {{ $suggestion['nama'] }} ({{ $suggestion['email'] }})
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($transaksi->isNotEmpty())
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 min-w-[900px]">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-center">No</th>
                                        <th class="px-6 py-3 text-center">Invoice</th>
                                        <th class="px-6 py-3 text-center">Nama</th>
                                        <th class="px-6 py-3 text-center">Rumah</th>
                                        <th class="px-6 py-3 text-center">Status</th>
                                        <th class="px-6 py-3 text-center">Uang Muka</th>
                                        <th class="px-6 py-3 text-center">Jenis Pembayaran</th>
                                        <th class="px-6 py-3 text-center">Angsuran</th>
                                        <th class="px-6 py-3 text-center">Tanggal Pesan</th>
                                        <th class="px-6 py-3 text-center">Bukti Booking</th>
                                        <th class="px-6 py-3 text-center">Bukti DP</th>
                                         <th class="px-6 py-3 text-center">Catatan</th>
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi as $item)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b hover:bg-gray-100">
                                            <td class="px-6 py-4 text-center">{{ $loop->iteration + ($transaksi->currentPage() - 1) * $transaksi->perPage() }}</td>
                                            <td class="px-6 py-4 text-center">{{ $item->invoice }}</td>
                                            <td class="px-6 py-4 text-center">{{ $item->customer->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 text-center">{{ $item->rumah->nomor_rumah ?? '-' }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($item->status_transaksi === 'lunas')
                                                    <span class="px-2 py-1 text-xs text-white bg-green-600 rounded">Lunas</span>
                                                @elseif($item->status_transaksi === 'belum')
                                                    <span class="px-2 py-1 text-xs text-white bg-red-600 rounded">Belum</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">Rp {{ number_format($item->uang_muka, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">{{ $item->jenis_pembayaran }}</td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $item->lama_angsuran ? $item->lama_angsuran . ' tahun' : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($item->bukti_booking)
                                                    <a href="{{ asset('storage/' . str_replace('public/', '', $item->bukti_booking)) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . str_replace('public/', '', $item->bukti_booking)) }}" width="100">
                                                    </a>
                                                @endif
                                            </td>
                                             <td class="px-6 py-4 text-center">
                                                @if($item->bukti_dp)
                                                    <a href="{{ asset('storage/' . str_replace('public/', '', $item->bukti_dp)) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . str_replace('public/', '', $item->bukti_dp)) }}" width="100">
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">{{ ucfirst($item->customer->status ?? '-') }}</td> 
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('admin.edit-transaksi', $item->id) }}" class="text-sm text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded-xl">Edit</a>   
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 px-6 hidden lg:flex flex-col lg:flex-row items-start lg:items-center gap-4 text-sm text-gray-600">
                            <div class="flex w-full items-center justify-between">
                                <span>Showing {{ $transaksi->firstItem() }} to {{ $transaksi->lastItem() }} of {{ $transaksi->total() }} results</span>
                                {{ $transaksi->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4">Belum ada data transaksi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- File Preview Modal -->
  @if($showPreview)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-medium">
                Preview Bukti {{ ucfirst($previewType) }}
            </h3>
            <button wire:click="closePreview" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="p-6 flex-grow overflow-auto flex items-center justify-center">
            @if($isPdf)
                <iframe src="{{ $previewFile }}#toolbar=0" class="w-full h-[70vh] border-0"></iframe>
            @else
                <img src="{{ $previewFile }}" 
                     alt="Bukti {{ ucfirst($previewType) }}"
                     class="max-w-full max-h-[70vh] object-contain">
            @endif
        </div>
        
        <div class="border-t px-6 py-3 bg-gray-50 flex justify-end">
            <button wire:click="closePreview" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">
                Tutup
            </button>
            <a href="{{ $previewFile }}" 
               download
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Download
            </a>
        </div>
    </div>
</div>
@endif
</div>
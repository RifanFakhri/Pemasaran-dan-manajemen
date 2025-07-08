<div class="w-full px-6 py-6 mx-auto overflow-hidden">
    <div class="px-6 pt-2">
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Transaksi</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>

        <div class="flex items-center justify-between mt-2 mb-6">
            <h6>List Transaksi</h6>
            
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
                                        <th class="px-6 py-3 text-center">No HP</th>
                                        <th class="px-6 py-3 text-center">Email</th>
                                        <th class="px-6 py-3 text-center">Rumah</th>
                                        <th class="px-6 py-3 text-center">Jenis Pembayaran</th>
                                        <th class="px-6 py-3 text-center">Lama Angsuran</th>
                                        <th class="px-6 py-3 text-center">Tanggal Pesan</th>
                                        <th class="px-6 py-3 text-center">Kwitansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi as $item)
                                        <tr class="bg-white border-b hover:bg-gray-100">
                                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->invoice }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->customer->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->customer->no_hp ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->customer->email ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->rumah->nomor_rumah ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->jenis_pembayaran }}</td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $item->lama_angsuran ? $item->lama_angsuran . ' tahun' : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">{{ $item->tanggal_pesan }}</td>
                                       <td class="px-6 py-4 text-center">
                                         <a href="{{ route('marketing.surat_keterangan_penjual', $item->id) }}" target="_blank"
                                            class="text-teal-600 hover:text-teal-800 inline-block" title="Cetak Berkas">
                                                <!-- Heroicons: Printer -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 9V4h12v5M6 18h12v-5H6v5zM6 14v-1a2 2 0 012-2h8a2 2 0 012 2v1" />
                                                </svg>
                                            </a>
                                       </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 px-6 hidden lg:flex flex-col lg:flex-row items-start lg:items-center gap-4 text-sm text-gray-600">
                            <div class="flex w-full items-center justify-between">
                                <span>Showing 1 to {{ $transaksi->count() }} of {{ $transaksi->total() }} results</span>
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
</div>

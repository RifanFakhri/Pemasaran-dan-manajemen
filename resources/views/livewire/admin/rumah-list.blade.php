<div class="w-full px-6 py-6 mx-auto">
    <div class="px-6 pt-2">
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Rumah</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>
        <div class="flex items-center justify-between mt-2 mb-4">
            <h1 class="text-2xl font-bold text-black">
                {{ $rumahs->first()?->blok?->nama_blok ?? 'N/A' }}
            </h1>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                
                <!-- Header + Search -->
                <div class="flex items-center justify-between p-6 pb-0 mb-0 bg-white border-b border-gray-200 rounded-t-2xl">
                    <div class="relative w-64 ml-auto">
                        <input
                            type="text"
                            wire:model.debounce.300ms="search"
                            wire:keydown.enter="applySearch"
                            placeholder="Search..."
                            class="px-4 py-2 border rounded w-full mb-4"
                        >

                        @if(strlen($search) > 0 && count($suggestions) > 0)
                            <div class="absolute z-10 w-full bg-white border border-gray-200 rounded mt-1 shadow-lg max-h-60 overflow-auto">
                                @foreach($suggestions as $suggestion)
                                    <div
                                        wire:click="selectUser('{{ $suggestion['nomor_rumah'] }}')"
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                    >
                                        {{ $suggestion['nomor_rumah'] }} ({{ ucfirst($suggestion['status']) }})
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Table -->
                <div class="relative overflow-x-auto p-4">
                    @if($rumahs->isNotEmpty())
                        <table class="w-full text-sm text-left text-gray-500 min-w-[800px] whitespace-nowrap">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">Nomor Rumah</th>
                                    <th scope="col" class="px-6 py-3 text-center">Luas Bangunan</th>
                                    <th scope="col" class="px-6 py-3 text-center">Luas Tanah</th>
                                    <th scope="col" class="px-6 py-3 text-center">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rumahs as $rumah)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200">
                                        <td class="px-6 py-4 text-center font-medium text-gray-900">{{ $rumah->nomor_rumah }}</td>
                                        <td class="px-6 py-4 text-center">{{ $rumah->luas_bangunan }} m²</td>
                                        <td class="px-6 py-4 text-center">{{ $rumah->luas_tanah }} m²</td>
                                        <td class="px-6 py-4 text-center">Rp {{ number_format($rumah->harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center capitalize">{{ $rumah->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 px-6 hidden lg:flex flex-col lg:flex-row items-start lg:items-center gap-4 text-sm text-gray-600">
                            <div class="flex w-full items-center justify-between">
                                <span>
                                    Showing {{ $rumahs->firstItem() }} to {{ $rumahs->lastItem() }} of {{ $rumahs->total() }} results
                                </span>
                                 {{ $rumahs->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4">Tidak ada rumah yang tersedia di blok ini.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<div class="w-full px-6 py-6 mx-auto overflow-hidden">
    <div class="px-6 pt-2">
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Pengunjung</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>
        
        <div class="flex items-center justify-between mt-2 mb-6">
            <h6>List Pengunjung</h6>
           <a href="{{ route('marketing.tambahPengguna') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-2 sm:px-8 py-2 rounded-lg shadow">
                Tambah Pengunjung
            </a>
        </div>
    </div>
    
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto px-4 pt-4 pb-2">
                    <!-- Search Box -->
                    <div class="relative w-64 sm:w-30 ml-auto">
                        <input
                            type="text"
                            wire:model.debounce.300ms="search"
                            wire:keydown.enter="applySearch"
                            placeholder="Search..."
                            class="px-4 py-2 border border-gray-300 rounded w-full sm:w-64 mb-4"
                        >
                        @if(strlen($search) > 0 && count($suggestions) > 0)
                            <div class="absolute z-10 w-full bg-white border border-gray-200 rounded mt-1 shadow-lg max-h-60 overflow-auto">
                                @foreach($suggestions as $suggestion)
                                    <div
                                        wire:click="selectUser('{{ $suggestion['nama'] }}')"
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                    >
                                        {{ $suggestion['nama'] }} ({{ ucfirst($suggestion['status']) }})
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


                    @if($customers->isNotEmpty())
                        <!-- Scrollable Table Wrapper with Overflow-X -->
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 min-w-[900px]">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center">ID</th>
                                        <th scope="col" class="px-6 py-3 text-center">Nama</th>
                                        <th scope="col" class="px-6 py-3 text-center">No. HP</th>
                                        <th scope="col" class="px-6 py-3 text-center">Email</th>
                                        <th scope="col" class="px-6 py-3 text-center">Tanggal Datang</th>
                                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                                        <th scope="col" class="px-6 py-3 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 hover:bg-gray-100">
                                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-center">{{ $customer->nama }}</td>
                                            <td class="px-6 py-4 text-center">{{ $customer->no_hp }}</td>
                                            <td class="px-6 py-4 text-center">{{ $customer->email }}</td>
                                            <td class="px-6 py-4 text-center">{{ $customer->tanggal_datang }}</td>
                                            <td class="px-6 py-4 text-center">{{ ucfirst($customer->status) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('marketing.editCustomer', $customer->id) }}" class="text-sm text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded-xl">Edit</a> 
                                            </td>
                                            <td class="px-6 py-4 text-center"> 
                                                @php
                                                    $rawNomor = preg_replace('/[^0-9]/', '', $customer->no_hp);
                                                    $nomor = ltrim($rawNomor, '0');
                                                    $nomor = '62' . $nomor;
                                                    $pesan = urlencode("Permisi Bapak/Ibu {$customer->nama}, perkenalkan saya dari tim Sales Perumahan Grand Telar Residence. Izin mengonfirmasi, apakah Bapak/Ibu sedang mencari informasi mengenai hunian atau tertarik dengan promo perumahan kami saat ini?");
                                                @endphp
                                            
                                                <a href="https://wa.me/{{ $nomor }}?text={{ $pesan }}" target="_blank">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="30" height="30">
                                                </a>
                                            </td>                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination & Per Page Controls -->
                        <!-- Untuk layar besar (lg, xl) -->
                        <div class="mt-4 px-6 hidden lg:flex flex-col lg:flex-row items-start lg:items-center gap-4 text-sm text-gray-600">
                            <div class="flex w-full items-center justify-between">
                                <span>Showing 1 to {{ $customers->count() }} of {{ $customers->total() }} results</span>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden text-sm ml-auto mt-2 lg:mt-0">
                                    {{ $customers->links('vendor.pagination.tailwind') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4">Tidak ada data pengunjung yang tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

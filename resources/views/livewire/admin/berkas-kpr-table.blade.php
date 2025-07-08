@php use Illuminate\Support\Str; @endphp

<div class="p-6 bg-white rounded-xl shadow-lg">
    <!-- Header and Filters -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar Berkas KPR
            </h2>
        </div>
        </div> 

<div class="bg-gray-50 p-4 rounded-lg mb-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="date" wire:model="startDate" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
            <input type="date" wire:model="endDate" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    
                </div>
                <input type="text" wire:model.debounce.500ms="search" placeholder="Cari nama..." 
                       class="pl-10 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-3 space-x-3">
        <a href="{{ route('admin.tambah-berkas') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-2 py-2 rounded-lg shadow">
                + Tambah berkas
            </a>
        <button wire:click="resetFilters" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            Reset Filter
        </button>
        
        <button 
                type="applyFilters"
                wire:click="applyFilters"
                wire:loading.attr="disabled"
                wire:target="applyFilters"
                class="btn btn-primary position-relative px-6 py-2 rounded-lg text-white transition duration-300 ease-in-out"
                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;"
            >
                <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                cari
            </button>
    </div>
</div>

   

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th> 
                    @php
                        $fields = [
                            'ktp' => 'KTP',
                            'kk' => 'KK', 
                            'surat_nikah' => 'Surat Nikah',
                            'npwp' => 'NPWP',
                            'siup' => 'SIUP',
                            'jamsostek' => 'Jamsostek',
                            'kartu_pegawai' => 'Kartu Pegawai',
                            'surat_bekerja' => 'Surat Bekerja',
                            'foto' => 'Foto',
                            'sk_karyawan' => 'SK Karyawan',
                            'slip_gaji' => 'Slip Gaji',
                            'rekening' => 'Rekening'
                        ];
                    @endphp
                    @foreach($fields as $field => $label)
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $label }}</th>
                    @endforeach
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($berkas as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ ($berkas->currentPage() - 1) * $berkas->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{$item->customer->nama ?? 'N/A'}}</td>
                         <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->created_at->format('d/m/Y') }} <!-- Format tanggal -->
                </td>
                        @foreach(array_keys($fields) as $field)
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                @if($item->$field)
                                    <button wire:click="previewFile({{ $item->id }}, '{{ $field }}')" 
                                            class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat
                                    </button>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.edit-berkas', $item->id) }}" 
                                class="text-yellow-600 hover:text-yellow-800 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <!-- Tombol Hapus -->
                                <form id="delete-form-{{ $item->id }}" 
                                    action="{{ route('berkas-kpr.destroy', $item->id) }}" 
                                    method="POST" 
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete({{ $item->id }})"
                                            class="text-red-600 hover:text-red-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($fields) + 3 }}" class="px-4 py-4 text-center text-sm text-gray-500">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
<div class="mt-4 px-2">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="mb-2 md:mb-0">
            <span class="text-sm text-gray-700">
                Showing {{ $berkas->firstItem() }} to {{ $berkas->lastItem() }} of {{ $berkas->total() }} results
            </span>
        </div>
        <div>
            {{ $berkas->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
    <!-- Preview Modal -->
    @if($showPreview)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closePreview"></div>

                <!-- Modal content -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Pratinjau Dokumen
                            </h3>
                            <button wire:click="closePreview" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4">
                           @if(Str::endsWith($previewFilePath, ['.jpg', '.jpeg', '.png', '.gif']))
                                <div class="flex justify-center">
                                    <img src="{{ $previewFilePath }}" alt="Pratinjau Dokumen" class="max-h-[70vh] max-w-full rounded-md shadow-sm border border-gray-200">
                                </div>
                           @elseif(Str::endsWith($previewFilePath, '.pdf'))
                                <div class="h-[70vh]">
                                    <iframe src="{{ $previewFilePath }}#toolbar=0&view=fitH" class="w-full h-full border border-gray-200 rounded-md"></iframe>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-md">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">Format file tidak didukung untuk pratinjau</p>
                                    <a href="{{ $previewFilePath }}" download class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Unduh File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a href="{{ $previewFilePath }}" download class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Unduh
                        </a>
                        <button wire:click="closePreview" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

   
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6c5ce7', // Gaya Soft UI warna ungu
            cancelButtonColor: '#ddd',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white border-none rounded-lg hover:scale-105 focus:outline-none transition-all',
                cancelButton: 'bg-gray-200 text-gray-600 border-none rounded-lg hover:scale-105 focus:outline-none transition-all'
            }
            
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
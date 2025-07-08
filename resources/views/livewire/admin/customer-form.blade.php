<div class="w-full px-4 py-6 mx-auto max-w-7xl">
    <!-- Breadcrumb Navigation -->
    <div class="px-4 mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dataCustomer') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-teal-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Daftar Pengunjung
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">Tambah Pengunjung</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex items-center justify-between mt-4">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Data Pengunjung Baru</h1>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="p-6 sm:p-8">
            <form wire:submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="nama" wire:model.defer="nama" placeholder="Nama lengkap pengunjung"
                                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 ease-in-out"
                                autocomplete="name" required>
                        </div>
                        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">+62</span>
                            </div>
                            <input type="tel" id="no_hp" wire:model.defer="no_hp" placeholder="812-3456-7890"
                                class="block w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 ease-in-out"
                                autocomplete="tel" required>
                        </div>
                        @error('no_hp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" id="email" wire:model.defer="email" placeholder="email@contoh.com"
                                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 ease-in-out"
                                autocomplete="email">
                        </div>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div>
                        <label for="tanggal_datang" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="date" id="tanggal_datang" wire:model.defer="tanggal_datang"
                                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 ease-in-out"
                                required>
                        </div>
                        @error('tanggal_datang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status Pengunjung -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pengunjung <span class="text-red-500">*</span></label>
                        <div class="mt-1 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="relative flex items-start p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-teal-500 transition-colors duration-200">
                                <div class="flex items-center h-5">
                                    <input id="status-baru" type="radio" wire:model.defer="status" value="baru"
                                        class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300" required>
                                </div>
                                <div class="ml-3 flex flex-col">
                                    <span class="block text-sm font-medium text-gray-700">Pengunjung Baru</span>
                                    <span class="block text-sm text-gray-500">Kunjungan pertama kali</span>
                                </div>
                            </label>
                            <label class="relative flex items-start p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-teal-500 transition-colors duration-200">
                                <div class="flex items-center h-5">
                                    <input id="status-follow_up" type="radio" wire:model.defer="status" value="follow_up"
                                        class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300">
                                </div>
                                <div class="ml-3 flex flex-col">
                                    <span class="block text-sm font-medium text-gray-700">Follow Up</span>
                                    <span class="block text-sm text-gray-500">Sedang dalam proses follow up</span>
                                </div>
                            </label>
                        </div>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.dataCustomer') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-tl from-blue-600 to-cyan-400 hover:bg-gradient-to-tl hover:from-blue-700 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-150 ease-in-out">
                        <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event ketika data berhasil ditambahkan
    window.addEventListener('customer-added', () => {
        Swal.fire({
            title: 'Data Tersimpan!',
            text: 'Pengunjung baru berhasil ditambahkan ke sistem.',
            icon: 'success',
            confirmButtonText: 'Kembali ke Daftar',
            cancelButtonText: 'Tambah Lagi',
            showCancelButton: true,
            timer: 3000,
            didOpen: () => {
                const confirmBtn = document.querySelector('.swal2-confirm');
                const cancelBtn = document.querySelector('.swal2-cancel');

                if (confirmBtn) {
                    confirmBtn.style.setProperty('background-color', '#0f766e', 'important');
                    confirmBtn.style.setProperty('color', 'white', 'important');
                    confirmBtn.style.setProperty('border', 'none', 'important');
                    confirmBtn.style.setProperty('padding', '10px 20px', 'important');
                    confirmBtn.style.setProperty('border-radius', '6px', 'important');
                }

                if (cancelBtn) {
                    cancelBtn.style.setProperty('background-color', '#d1d5db', 'important');
                    cancelBtn.style.setProperty('color', 'black', 'important');
                    cancelBtn.style.setProperty('border', 'none', 'important');
                    cancelBtn.style.setProperty('padding', '10px 20px', 'important');
                    cancelBtn.style.setProperty('border-radius', '6px', 'important');
                }
            }
        }).then((result) => {
            if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                window.location.href = "{{ route('admin.dataCustomer') }}";
            }
        });
    });

    // Event ketika ada error saat menyimpan data
    window.addEventListener('customer-error', (event) => {
        Swal.fire({
            title: 'Gagal Menyimpan!',
            text: event.detail.message || 'Terjadi kesalahan saat menyimpan data pengunjung.',
            icon: 'error',
            confirmButtonText: 'OK',
            didOpen: () => {
                const confirmBtn = document.querySelector('.swal2-confirm');
                if (confirmBtn) {
                    confirmBtn.style.setProperty('background-color', '#dc2626', 'important'); // Merah
                    confirmBtn.style.setProperty('color', 'white', 'important');
                    confirmBtn.style.setProperty('border', 'none', 'important');
                    confirmBtn.style.setProperty('padding', '10px 20px', 'important');
                    confirmBtn.style.setProperty('border-radius', '6px', 'important');
                }
            }
        });
    });
});
</script>
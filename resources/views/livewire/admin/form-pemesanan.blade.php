<div>
    <div class="w-full px-6 py-6 mx-auto">
        <div class="px-6 pt-6">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 flex items-center space-x-1">
                <span class="hover:text-gray-700 cursor-pointer">Pemesanan</span>
                <span class="mx-1">›</span>
                <span class="text-gray-700 font-medium">Tambah Pemesanan</span>
            </nav>
  
            <div class="flex items-center justify-between mt-2 mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Form Tambah Pemesanan</h1>
            </div>
        </div>
  
        <!-- Flash Message -->
        @if (session()->has('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
  
        <!-- Form Pemesanan -->
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        <form wire:submit.prevent="submit" class="space-y-6">
                            <!-- Blok Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Blok</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @foreach($daftarBlok as $blok)
                                        <button 
                                            type="button"
                                            wire:click="$set('blok_id', {{ $blok->id }})"
                                            @class([
                                                'px-4 py-2 border rounded-lg text-center transition-all',
                                                'bg-blue-100 border-blue-500 text-blue-700 font-medium' => $blok_id == $blok->id,
                                                'border-gray-300 hover:bg-gray-50' => $blok_id != $blok->id
                                            ])
                                        >
                                            {{ $blok->nama_blok }}
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $blok->rumah_count }} rumah
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                                @error('blok_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Rumah Selection -->
                            <div x-data="{ open: false }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Rumah</label>
                                <button 
                                    type="button"
                                    @click="open = !open"
                                    @class([
                                        'w-full flex justify-between items-center px-4 py-2 border rounded-lg text-left',
                                        'border-blue-500 bg-blue-50' => $rumah_id,
                                        'border-gray-300' => !$rumah_id
                                    ])
                                    @if(!$blok_id) disabled @endif
                                >
                                    <span>
                                        @if($rumah_id)
                                            {{ $daftarRumah->firstWhere('id', $rumah_id)->nomor_rumah ?? 'Pilih Rumah' }}
                                        @else
                                            Pilih Rumah
                                        @endif
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Rumah -->
                                <div 
                                    x-show="open"
                                    @click.away="open = false"
                                    class="mt-1 w-full border border-gray-200 rounded-lg shadow-lg bg-white z-10"
                                    x-transition
                                >
                                    <div class="p-2 max-h-60 overflow-y-auto">
                                        @if($blok_id && $daftarRumah->isNotEmpty())
                                            @foreach($daftarRumah as $rumah)
                                                <button
                                                    type="button"
                                                    wire:click="$set('rumah_id', {{ $rumah->id }})"
                                                    @click="open = false"
                                                    class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded-md flex justify-between items-center"
                                                >
                                                    <span>{{ $rumah->nomor_rumah }}</span>
                                                    @if($rumah_id == $rumah->id)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            @endforeach
                                        @else
                                            <div class="px-4 py-2 text-gray-500 text-center">
                                                @if(!$blok_id)
                                                    Pilih blok terlebih dahulu
                                                @else
                                                    Tidak ada rumah tersedia
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @error('rumah_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Customer Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Customer</label>
                                <select wire:model="customer_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Customer</option>
                                    @foreach($daftarCustomer as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Jenis Pembayaran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pembayaran</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button
                                        type="button"
                                        wire:click="$set('jenis_pembayaran', 'KPR')"
                                        @class([
                                            'px-4 py-2 border rounded-lg text-center',
                                            'bg-blue-100 border-blue-500 text-blue-700 font-medium' => $jenis_pembayaran == 'KPR',
                                            'border-gray-300 hover:bg-gray-50' => $jenis_pembayaran != 'KPR'
                                        ])
                                    >
                                        KPR
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="$set('jenis_pembayaran', 'Cash')"
                                        @class([
                                            'px-4 py-2 border rounded-lg text-center',
                                            'bg-blue-100 border-blue-500 text-blue-700 font-medium' => $jenis_pembayaran == 'Cash',
                                            'border-gray-300 hover:bg-gray-50' => $jenis_pembayaran != 'Cash'
                                        ])
                                    >
                                        Cash
                                    </button>
                                </div>
                                @error('jenis_pembayaran') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Lama Angsuran (Khusus KPR) -->
                            @if($jenis_pembayaran === 'KPR')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lama Angsuran</label>
                                <select wire:model="lama_angsuran"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Lama Angsuran</option>
                                    <option value="10">10 Tahun</option>
                                    <option value="15">15 Tahun</option>
                                    <option value="20">20 Tahun</option>
                                    <option value="25">25 Tahun</option>
                                </select>
                                @error('lama_angsuran') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Uang Booking (Rp)</label>
                                <input type="text" 
                                    wire:model="uang_booking" 
                                    readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                    />
                                @error('uang_booking') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Uang Muka -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Uang Muka (10% Harga Rumah) (Rp)</label>
                                <input type="text" 
                                    wire:model="uang_muka" 
                                    readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                    />
                                @error('uang_muka') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Booking</label>
                                
                                <div x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                        
                        <!-- File Input dengan Preview -->
                        <div class="flex items-center space-x-4">
                            <label class="flex flex-col items-center justify-center w-full px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-gray-50 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Format: JPG, PNG, atau PDF (Maks. 2MB)
                                </p>
                                <input type="file" wire:model="bukti_booking" 
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    class="hidden">
                            </label>
                        </div>

                        <!-- Progress Bar -->
                        <div x-show="isUploading" class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" 
                                    x-bind:style="`width: ${progress}%`"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right" x-text="`${progress}%`"></p>
                        </div>
                            <div class="mt-4">
                                @if ($bukti_booking)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center space-x-3">
                                            @if (in_array($bukti_booking->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">{{ $bukti_booking->getClientOriginalName() }}</p>
                                                <p class="text-xs text-gray-500">{{ round($bukti_booking->getSize()/1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeBuktiBooking" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>

                                @error('bukti_booking') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                </div>
                            <!-- Tanggal Pemesanan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemesanan</label>
                                <input type="date" wire:model="tanggal_pesan"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('tanggal_pesan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Status Transaksi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Uang Muka</label>
                                <select wire:model="status_transaksi"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Status</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="belum">Belum</option>
                                </select>
                                @error('status_transaksi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Bukti Pembayaran (Hanya muncul jika status Lunas) -->
                            <div x-show="$wire.status_transaksi === 'lunas'" x-transition>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                                <div class="mt-1 flex items-center">
                                    <label for="bukti_dp" class="cursor-pointer">
                                        <div class="flex flex-col items-center justify-center px-6 py-8 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition duration-150 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <span class="mt-2 text-sm font-medium text-gray-700">
                                                <span class="text-blue-600">Upload file</span> atau drag and drop
                                            </span>
                                            <span class="text-xs text-gray-500 mt-1">
                                                PNG, JPG, PDF (Max. 5MB)
                                            </span>
                                        </div>
                                        <input 
                                            id="bukti_dp" 
                                            type="file" 
                                            wire:model="bukti_dp"
                                            class="sr-only"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                        >
                                    </label>
                                </div>
                                @error('bukti_dp') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                
                                <!-- Preview File -->
                                <div x-show="$wire.bukti_dp" class="mt-2">
                                    <template x-if="$wire.bukti_dp">
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex items-center space-x-3">
                                                <template x-if="['image/jpeg','image/png','image/gif'].includes($wire.bukti_pembayaran.type)">
                                                    <img x-bind:src="URL.createObjectURL($wire.bukti_pembayaran)" class="h-10 w-10 object-cover rounded" alt="Preview">
                                                </template>
                                                <template x-if="$wire.bukti_dp.type === 'application/pdf'">
                                                    <div class="h-10 w-10 bg-red-100 flex items-center justify-center rounded">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                </template>
                                                <div>
                                                    <span x-text="$wire.bukti_dp.name" class="text-sm font-medium text-gray-700"></span>
                                                    <div class="text-xs text-gray-500" x-text="Math.round($wire.bukti_pembayaran.size / 1024) + 'KB'"></div>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="$set('bukti_dp', null)" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
  
                            <!-- Submit Button -->
                            <div class="pt-4 flex justify-end space-x-3">
                                <a href="{{ route('admin.data-transaksi') }}" 
                                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition duration-200">
                                    Batal
                                </a>
                                <div class="pt-4">
                                <a href="#" wire:click.prevent="submit"
                                class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition duration-200">
                                Simpan Pemesanan
                                </a>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('tambah-transaksi', () => {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data Transaksi Berhasil Ditambahkan.',
            icon: 'success',
            confirmButtonColor: '#0f766e',
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            window.location.href = "{{ route('admin.data-transaksi') }}";
        });
    });
</script>
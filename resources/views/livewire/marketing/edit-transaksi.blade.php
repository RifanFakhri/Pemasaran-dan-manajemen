<div>
    <div class="w-full px-6 py-6 mx-auto">
        <div class="px-6 pt-6">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 flex items-center space-x-1">
                <a href="{{ route('marketing.data-transaksi') }}" class="hover:text-gray-700 cursor-pointer">Transaksi</a>
                <span class="mx-1">›</span>
                <span class="text-gray-700 font-medium">Edit Transaksi #{{ $invoice }}</span>
            </nav>
  
            <div class="flex items-center justify-between mt-2 mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Form Edit Transaksi</h1>
            </div>
        </div>
  
        <!-- Flash Message -->
        @if (session()->has('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
  
        <!-- Form Edit -->
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        <form wire:submit.prevent="update" class="space-y-6">
                            <!-- Invoice (Readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Invoice</label>
                                <input type="text" 
                                    wire:model="invoice" 
                                    readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            </div>
                            
                            <!-- Rumah Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rumah</label>
                                <select wire:model="rumah_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Rumah</option>
                                    @foreach($rumah as $r)
                                        <option value="{{ $r->id }}" @selected($r->id == $rumah_id)>
                                            {{ $r->nomor_rumah }} ( {{ $r->blok->nama_blok ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('rumah_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Customer Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                                <select wire:model="customer_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected($customer->id == $customer_id)>
                                            {{ $customer->nama }} 
                                        </option>
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
                                        wire:click="$set('jenis_pembayaran', 'kpr')"
                                        @class([
                                            'px-4 py-2 border rounded-lg text-center',
                                            'bg-blue-100 border-blue-500 text-blue-700 font-medium' => $jenis_pembayaran == 'kpr',
                                            'border-gray-300 hover:bg-gray-50' => $jenis_pembayaran != 'kpr'
                                        ])
                                    >
                                        KPR
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="$set('jenis_pembayaran', 'cash')"
                                        @class([
                                            'px-4 py-2 border rounded-lg text-center',
                                            'bg-blue-100 border-blue-500 text-blue-700 font-medium' => $jenis_pembayaran == 'cash',
                                            'border-gray-300 hover:bg-gray-50' => $jenis_pembayaran != 'cash'
                                        ])
                                    >
                                        Cash
                                    </button>
                                </div>
                                @error('jenis_pembayaran') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Lama Angsuran (Khusus KPR) -->
                            @if($jenis_pembayaran === 'kpr')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lama Angsuran</label>
                                <select wire:model="lama_angsuran"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Lama Angsuran</option>
                                    <option value="10" @selected($lama_angsuran == 10)>10 Tahun</option>
                                    <option value="15" @selected($lama_angsuran == 15)>15 Tahun</option>
                                    <option value="20" @selected($lama_angsuran == 20)>20 Tahun</option>
                                </select>
                                @error('lama_angsuran') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            @endif
                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Booking</label>
                                
                                <div x-data="{ isUploading: false, progress: 0 }"
                                     x-on:livewire-upload-start="isUploading = true"
                                     x-on:livewire-upload-finish="isUploading = false"
                                     x-on:livewire-upload-error="isUploading = false"
                                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                                     
                                    <!-- Current File Preview -->
                                    @if($bukti_booking && !is_string($bukti_booking))
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 mb-1">File saat ini:</p>
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center space-x-3">
                                                    @if(in_array($bukti_booking->getClientOriginalExtension(), ['jpg','jpeg','png']))
                                                        <img src="{{ $bukti_booking->temporaryUrl() }}" class="h-12 w-12 object-cover rounded" alt="Preview">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700">{{ $bukti_booking->getClientOriginalName() }}</p>
                                                        <p class="text-xs text-gray-500">{{ round($bukti_booking->getSize()/1024, 1) }} KB</p>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="$set('bukti_booking', null)" class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($bukti_booking_path)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 mb-1">File saat ini:</p>
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center space-x-3">
                                                    @if(pathinfo($bukti_booking_path, PATHINFO_EXTENSION) === 'pdf')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    @else
                                                        <img src="{{ asset('storage/'.$bukti_booking_path) }}" class="h-12 w-12 object-cover rounded" alt="Bukti Booking">
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700">{{ basename($bukti_booking_path) }}</p>
                                                        <a href="{{ asset('storage/'.$bukti_booking_path) }}" target="_blank" class="text-xs text-blue-500 hover:underline">Lihat Full</a>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="removeBuktiBooking" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- File Upload Area -->
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

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading" class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" 
                                                x-bind:style="`width: ${progress}%`"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 text-right" x-text="`${progress}%`"></p>
                                    </div>
                                </div>
                                @error('bukti_booking') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
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
        <label class="block text-sm font-medium text-gray-700 mb-2">Status Transaksi</label>
        <select wire:model="status_transaksi"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="belum" @selected($status_transaksi == 'belum')>Belum Lunas</option>
            <option value="lunas" @selected($status_transaksi == 'lunas')>Lunas</option>
        </select>
        @error('status_transaksi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Bukti DP (Muncul hanya jika status Lunas) -->
    <div x-show="$wire.status_transaksi === 'lunas'" x-transition>
        <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran DP</label>
        
        <!-- Tampilkan bukti yang sudah ada -->
        @if($bukti_dp_path)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-1">Bukti DP Terupload:</p>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center space-x-3">
                        @if(pathinfo($bukti_dp_path, PATHINFO_EXTENSION) === 'pdf')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @else
                            <img src="{{ asset('storage/'.$bukti_dp_path) }}" class="h-12 w-12 object-cover rounded" alt="Bukti DP">
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ basename($bukti_dp_path) }}</p>
                            <a href="{{ asset('storage/'.$bukti_dp_path) }}" target="_blank" class="text-xs text-blue-500 hover:underline">Lihat Full</a>
                        </div>
                    </div>
                    <button type="button" wire:click="removeBuktiDp" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Form Upload (Muncul jika belum ada bukti atau ingin ganti) -->
        <div x-data="{ isUploading: false, progress: 0 }"
             x-on:livewire-upload-start="isUploading = true"
             x-on:livewire-upload-finish="isUploading = false"
             x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress">
            
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
                <input type="file" wire:model="bukti_dp" 
                       accept=".jpg,.jpeg,.png,.pdf"
                       class="hidden">
            </label>

            <!-- Progress Bar -->
            <div x-show="isUploading" class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" 
                         x-bind:style="`width: ${progress}%`"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1 text-right" x-text="`${progress}%`"></p>
            </div>

            <!-- Preview File Baru -->
            <div x-show="$wire.bukti_dp" class="mt-2">
                <template x-if="$wire.bukti_dp">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <template x-if="['image/jpeg','image/png','image/gif'].includes($wire.bukti_dp.type)">
                                <img x-bind:src="URL.createObjectURL($wire.bukti_dp)" class="h-10 w-10 object-cover rounded" alt="Preview">
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
                                <div class="text-xs text-gray-500" x-text="Math.round($wire.bukti_dp.size / 1024) + 'KB'"></div>
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
        @error('bukti_dp') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
    </div>


                            <!-- Status Customer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Customer</label>
                                <select wire:model="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pembeli" @selected($status == 'pembeli')>Pembeli</option>
                                    <option value="booking" @selected($status == 'booking')>Booking</option>
                                    <option value="cancelled" @selected($status == 'cancelled')>Dibatalkan</option>
                                </select>
                                @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
  
                            <!-- Submit Button -->
                            <div class="pt-4 flex justify-end space-x-3">
                                <a href="{{ route('marketing.data-transaksi') }}" 
                                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition duration-200">
                                    Batal
                                </a>
                                <div class="pt-4">
                                <a href="#" wire:click.prevent="update"
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
window.addEventListener('transaction-updated', () => {
    Swal.fire({
        title: 'Berhasil!',
        text: 'Data Transaksi Berhasil Diperbarui.',
        icon: 'success',
        confirmButtonText: 'OK',
        showConfirmButton: true,
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
            const confirmBtn = document.querySelector('.swal2-confirm');
            if (confirmBtn) {
                confirmBtn.style.setProperty('background-color', '#0f766e', 'important');
                confirmBtn.style.setProperty('color', 'white', 'important');
                confirmBtn.style.setProperty('border', 'none', 'important');
                confirmBtn.style.setProperty('padding', '10px 20px', 'important');
                confirmBtn.style.setProperty('border-radius', '6px', 'important');
                confirmBtn.style.setProperty('box-shadow', 'none', 'important');
            }
        }
    }).then(() => {
        window.location.href = "{{ route('marketing.data-transaksi') }}";
    });
});
</script>

<div class="p-6 bg-white rounded-xl shadow-lg max-w-5xl mx-auto">
    <!-- Success Notification -->
    @if(session()->has('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg flex items-start space-x-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-medium">Success!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data" autocomplete="off" class="space-y-8">
        <!-- Customer Selection -->
        <div class="space-y-2">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Customer Information</h2>
            </div>
            <div class="pl-7">
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                <select id="customer_id" wire:model="customer_id" required
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                    transition duration-150 ease-in-out">
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->nama }}</option>
                    @endforeach
                </select>
                @error('customer_id')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        @php
            $docGroups = [
                'Dokumen Identitas' => [
                    'ktp' => ['label' => 'KTP', 'icon' => 'id-card'],
                    'kk' => ['label' => 'Kartu Keluarga', 'icon' => 'users'],
                    'surat_nikah' => ['label' => 'Surat Nikah', 'icon' => 'heart'],
                    'npwp' => ['label' => 'NPWP', 'icon' => 'receipt-tax']
                ],
                'Dokumen Pekerjaan' => [
                    'siup' => ['label' => 'SIUP', 'icon' => 'briefcase'],
                    'jamsostek' => ['label' => 'Jamsostek', 'icon' => 'shield-check'],
                    'kartu_pegawai' => ['label' => 'Kartu Pegawai', 'icon' => 'badge-check'],
                    'surat_bekerja' => ['label' => 'Surat Bekerja', 'icon' => 'document-text'],
                    'sk_karyawan' => ['label' => 'SK Karyawan', 'icon' => 'document-duplicate']
                ],
                'Dokumen Keuangan' => [
                    'slip_gaji' => ['label' => 'Slip Gaji', 'icon' => 'currency-dollar'],
                    'rekening' => ['label' => 'Rekening', 'icon' => 'banknotes'],
                    'foto' => ['label' => 'Foto', 'icon' => 'camera']
                ],
            ];
        @endphp

        <!-- Document Sections -->
        @foreach($docGroups as $groupName => $fields)
            <fieldset class="border border-gray-200 rounded-xl p-5 space-y-4 bg-gray-50/50">
                <legend class="px-3 text-lg font-semibold text-gray-800 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>{{ $groupName }}</span>
                </legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($fields as $field => $details)
                        <div class="space-y-2">
                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 flex-items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($details['icon'] === 'id-card')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    @elseif($details['icon'] === 'users')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    @elseif($details['icon'] === 'heart')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    @elseif($details['icon'] === 'receipt-tax')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                                    @elseif($details['icon'] === 'briefcase')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    @elseif($details['icon'] === 'shield-check')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    @elseif($details['icon'] === 'badge-check')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    @elseif($details['icon'] === 'document-text')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    @elseif($details['icon'] === 'document-duplicate')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    @elseif($details['icon'] === 'currency-dollar')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @elseif($details['icon'] === 'banknotes')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    @elseif($details['icon'] === 'camera')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    @endif
                                </svg>
                                <span>{{ $details['label'] }}</span>
                            </label>
                            
                            <div class="relative">
                                <input type="file" id="{{ $field }}" wire:model="berkas.{{ $field }}" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                    transition duration-150 ease-in-out" />
                            </div>
                            
                            @error('berkas.'.$field)
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            @if($field === 'foto')
                                <p class="mt-1 text-xs text-gray-500 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Format: JPG/PNG (Max 2MB)
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </fieldset>
        @endforeach

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button type="button" 
                onclick="window.history.back()" 
                class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                Cancel
            </button>
           <button 
                type="submit"
                wire:click="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="btn btn-primary position-relative px-6 py-2 rounded-lg text-white transition duration-300 ease-in-out"
                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;"
            >
                <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Submit Documents
            </button>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.addEventListener('tambah-berkas', () => {
    Swal.fire({
        title: 'Success!',
        text: 'Dokumen telah berhasil diunggah.',
        icon: 'success',
        showConfirmButton: true,
        confirmButtonText: 'OK',
        timer: 3000,
        timerProgressBar: true,
        didOpen: () => {
            const confirmBtn = document.querySelector('.swal2-confirm');
            if (confirmBtn) {
                confirmBtn.style.setProperty('background-color', '#2563eb', 'important'); // Biru
                confirmBtn.style.setProperty('color', 'white', 'important');
                confirmBtn.style.setProperty('border', 'none', 'important');
                confirmBtn.style.setProperty('padding', '10px 20px', 'important');
                confirmBtn.style.setProperty('border-radius', '6px', 'important');
                confirmBtn.style.setProperty('box-shadow', 'none', 'important');
            }
        },
        willClose: () => {
            window.location.href = "{{ route('admin.data-berkas') }}";
        }
    });
});
</script>

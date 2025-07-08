<div class="p-8 bg-white rounded-xl shadow-lg max-w-5xl mx-auto">
    <div class="flex items-center mb-8">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Berkas KPR</h2>
            <p class="text-gray-600">Kelola dokumen persyaratan KPR nasabah</p>
        </div>
    </div>

    <form wire:submit.prevent="update" enctype="multipart/form-data" class="space-y-8">
        <!-- Customer Selection -->
        <div class="bg-blue-50 p-5 rounded-lg">
            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Pembeli</label>
            <select id="customer_id" wire:model="customer_id" required
                class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                @foreach($customers as $cust)
                    @if($cust->id == $customer_id)
                        <option value="{{ $cust->id }}" selected>
                            {{ $cust->nama }}   
                        </option>
                    @endif
                @endforeach
            </select>

        </div>

        @php
            $docGroups = [
                'Dokumen Identitas' => [
                    'ktp' => 'KTP',
                    'kk' => 'Kartu Keluarga', 
                    'surat_nikah' => 'Surat Nikah',
                    'npwp' => 'NPWP'
                ],
                'Dokumen Pekerjaan' => [
                    'siup' => 'SIUP/SIUL/TDP', 
                    'jamsostek' => 'Kartu Jamsostek/BPJS',
                    'kartu_pegawai' => 'Kartu Pegawai',
                    'surat_bekerja' => 'Surat Bekerja',
                    'sk_karyawan' => 'SK Karyawan'
                ],
                'Dokumen Keuangan' => [
                    'slip_gaji' => 'Slip Gaji 3 Bulan Terakhir',
                    'rekening' => 'Rekening Koran 3 Bulan Terakhir',
                    'foto' => 'Pas Foto 4x6'
                ],
            ];
        @endphp

        <!-- Document Sections -->
        @foreach($docGroups as $groupName => $fields)
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ $groupName }}
                    </h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($fields as $field => $label)
                        <div class="space-y-2">
                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">
                                {{ $label }}
                                <span class="text-xs text-gray-500">(PDF/JPG/PNG, max 2MB)</span>
                            </label>
                            
                            @if(isset($existingFiles[$field]))
                                <div class="flex items-center justify-between bg-blue-50 p-3 rounded-lg mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <a href="{{ Storage::url($existingFiles[$field]) }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                    <button type="button" wire:click="removeFile('{{ $field }}')" 
                                            class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                            
                            <div class="relative">
                                <input type="file" id="{{ $field }}" wire:model="berkas.{{ $field }}" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            </div>
                            
                            @error('berkas.'.$field)
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('admin.data-berkas') }}" 
               class="px-6 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                    style="background-color: #2563eb !important; color: white !important;">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('edit-berkas', () => {
        Swal.fire({
            title: 'Success!',
            text: 'Documents have been successfully uploaded.',
            icon: 'success',
            confirmButtonColor: '#2563eb',
            showConfirmButton: true,
            timer: 3000,
            timerProgressBar: true,
            willClose: () => {
                window.location.href = "{{ route('admin.data-berkas') }}";
            }
        });
    });
</script>
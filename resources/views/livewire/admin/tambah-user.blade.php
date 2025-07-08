<div class="w-full px-6 py-6 mx-auto">
    <div class="px-6 pt-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Pengunjung</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">Tambah Pengunjung</span>
        </nav>

        <div class="flex items-center justify-between mt-2 mb-4">
            <h1 class="text-2xl font-bold text-black">Form Tambah Pengunjung</h1>
        </div>
    </div>

    <!-- Form -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6">
                    <form wire:submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" wire:model.defer="name" placeholder="Masukkan nama"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" wire:model.defer="username" placeholder="Masukkan username"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" wire:model.defer="password" placeholder="Masukkan password"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select wire:model.defer="role"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih role</option>
                                <option value="admin">Admin</option>
                                <option value="marketing">Marketing</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="md:col-span-2 flex justify-end">
                            <a href="#" wire:click.prevent="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-xl shadow-md inline-block text-center">
                                Simpan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.addEventListener('user-added', () => {
    Swal.fire({
        title: 'Berhasil!',
        text: 'User berhasil ditambahkan.',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    }).then(() => {
        window.location.href = "{{ route('admin.user') }}"; // Ganti dengan rute yang sesuai
    });
});
</script>


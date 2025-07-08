<div class="w-full px-6 py-6 mx-auto">
    <div class="px-6 pt-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Users</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>

        <!-- Header & Tambah Button -->
        <div class="flex items-center justify-between mt-2 mb-4">
            <h1 class="text-2xl font-bold text-black">Users Table</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.tambah-user') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-xl inline-block">
                    Tambah User
                </a>
            </div>
        </div>

        <!-- Card Container -->
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-md rounded-2xl bg-clip-border">

                    <!-- Search Box -->
                    <div class="flex items-center justify-between p-6 pb-0 mb-0 border-b border-gray-200 rounded-t-2xl">
                        <div class="relative w-64 ml-auto">
                            <input
                                type="text"
                                wire:model.debounce.300ms="search"
                                wire:keydown.enter="applySearch"
                                placeholder="Search..."
                                class="px-4 py-2 border border-gray-300 rounded w-full mb-4"
                            >

                            @if(strlen($search) > 0 && count($suggestions) > 0)
                                <div class="absolute z-10 w-full bg-white border border-gray-200 rounded mt-1 shadow-lg">
                                    @foreach($suggestions as $name)
                                        <div
                                            wire:click="selectUser('{{ $name }}')"
                                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-700"
                                        >
                                            {{ $name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="relative overflow-x-auto sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Username</th>
                                        <th scope="col" class="px-6 py-3">Role</th>
                                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b hover:bg-gray-100">
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4">{{ $user->username }}</td>
                                            <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                                            <td class="px-6 py-4 text-center space-x-2">
                                                <a href="{{ route('admin.edit-user', $user->id) }}"
                                                class="font-medium text-blue-600 hover:underline"
                                                title="Edit">
                                                ✏️ Edit
                                                </a>

                                               <form id="delete-form-{{ $user->id }}" action="{{ route('admin.delete-user', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:void(0);"
                                                    onclick="confirmDelete({{ $user->id }})"
                                                    class="font-medium text-red-600 hover:underline"
                                                    title="Delete">
                                                    🗑️ Delete
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center px-6 py-4 text-gray-400">
                                                No users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="mt-4 px-6">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>

                </div> <!-- card -->
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data user akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6c5ce7', // Gaya Soft UI warna ungu
            cancelButtonColor: '#ddd', // Warna untuk tombol cancel
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white border-none rounded-lg hover:scale-105 focus:outline-none transition-all',
                cancelButton: 'bg-gray-200 text-gray-600 border-none rounded-lg hover:scale-105 focus:outline-none transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form untuk menghapus user
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>

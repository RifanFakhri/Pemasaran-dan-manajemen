@extends('layouts.index')

@section('admin')
<div class="w-full px-6 py-6 mx-auto">
    <div class="px-6 pt-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">User</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">Edit User</span>
        </nav>

        <div class="flex items-center justify-between mt-2 mb-4">
            <h1 class="text-2xl font-bold text-black">Form Edit User</h1>
        </div>
    </div>

    <!-- Form -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6">
                    <form action="{{ route('admin.update-user', $users->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $users->name) }}" placeholder="Masukkan nama"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', $users->username) }}" placeholder="Masukkan username"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Pilih role</option>
                                <option value="admin" {{ $users->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="marketing" {{ $users->role === 'marketing' ? 'selected' : '' }}>Marketing</option>
                            </select>
                        </div>

                        <!-- Tombol Update -->
                        <div class="md:col-span-2 flex justify-end space-x-2 mt-4">
                            <a href="{{ route('admin.user') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl shadow-md inline-block text-center">
                                Batal
                            </a>
                           <button type="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-xl shadow-md inline-block text-center"
                                style="background-color: #0f766e !important; color: white !important;">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

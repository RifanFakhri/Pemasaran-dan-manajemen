<div class="w-full px-4 sm:px-6 py-6 mx-auto">
    <div class="px-2 sm:px-6 pt-6">
        <nav class="text-sm text-gray-500 flex items-center space-x-1">
            <span class="hover:text-gray-700 cursor-pointer">Bloks</span>
            <span class="mx-1">›</span>
            <span class="text-gray-700 font-medium">List</span>
        </nav>
        <div class="flex items-center justify-between mt-2 mb-4">
            <h1 class="text-2xl font-bold text-black">Bloks Table</h1>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">

                <div class="flex-auto px-4 pt-4 pb-2">
                    <!-- Scrollable Table Container -->
                    <div class="relative overflow-x-auto">
                        <table class="min-w-[700px] w-full text-sm text-left text-gray-500 whitespace-nowrap table-fixed">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center font-bold text-black w-1/4">Nama Blok</th>
                                    <th scope="col" class="px-6 py-3 text-center font-bold text-black w-1/4">Jumlah Terjual</th>
                                    <th scope="col" class="px-6 py-3 text-center font-bold text-black w-1/4">Jumlah Tersedia</th>
                                    <th scope="col" class="px-6 py-3 text-center font-bold text-black w-1/4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bloks as $blok)
                                    <tr class="odd:bg-white even:bg-gray-50 border-b hover:bg-gray-100">
                                        <td class="px-6 py-4 text-center font-medium text-gray-900">{{ $blok->nama_blok }}</td>
                                        <td class="px-6 py-4 text-center">{{ $blok->rumah_terjual }}</td>
                                        <td class="px-6 py-4 text-center">{{ $blok->rumah_tersedia }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.detailBlok', $blok->id) }}"
                                               class="text-sm text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded-xl">
                                                Lihat Rumah
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-slate-400">No bloks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 px-6">
                        {{ $bloks->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

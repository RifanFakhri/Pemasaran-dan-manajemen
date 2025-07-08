<div class="bg-white rounded-lg shadow p-4 h-full">
    <h1 class="text-2xl font-bold text-center mb-6">Laporan Pemesanan</h1>
    
    <div class="filter-section no-print mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="filter-group">
                <label for="start-date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" wire:model="startDate" id="start-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div class="filter-group">
                <label for="end-date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                <input type="date" wire:model="endDate" id="end-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div class="filter-group">
                <label for="status" class="block text-sm font-medium text-gray-700">Status Pemesanan</label>
                <select wire:model="statusFilter" id="status" class="mt-1 block w-full h-8 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="belum">Belum</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="jenis_pembayaran" class="block text-sm font-medium text-gray-700">Jenis Pembayaran</label>
                <select wire:model="jenisPembayaranFilter" id="jenis_pembayaran" class="mt-1 block w-full h-8 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Jenis</option>
                    <option value="cash">Cash</option>
                    <option value="kpr">KPR</option>
                </select>
            </div>
        </div>
        
        <div class="filter-group mb-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Cari (Invoice/Nama Customer)</label>
            <input type="text" wire:model.debounce.500ms="searchTerm" id="search" placeholder="Masukkan kata kunci..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        
        <div class="button-group no-print flex flex-wrap gap-2 mb-4">
            <button 
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700 transition"
                wire:click="$refresh">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>

            <button 
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-green-600 rounded-md font-semibold text-xs text-white uppercase hover:bg-green-700 transition"
                wire:click="exportToExcel">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Excel
            </button>

            <button 
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-600 rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 transition"
                onclick="printTableData()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>

            <button 
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase hover:bg-red-700 transition"
                wire:click="resetFilters">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </button>
        </div>
    </div>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="printable-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Invoice</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Rumah</th>
                    <th class="px-6 py-3">Jenis Bayar</th>
                    <th class="px-6 py-3">Uang Booking</th>
                    <th class="px-6 py-3">Uang Muka</th>
                    <th class="px-6 py-3">Lama Angsuran</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $pemesanan)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $pemesanan->invoice }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanan->customer->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanan->rumah->nomor_rumah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($pemesanan->jenis_pembayaran) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pemesanan->uang_booking, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pemesanan->uang_muka, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanan->lama_angsuran }} bulan</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'booking' => 'bg-yellow-100 text-yellow-800',
                                    'dp' => 'bg-blue-100 text-blue-800',
                                    'lunas' => 'bg-green-100 text-green-800',
                                    'batal' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$pemesanan->status_transaksi] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($pemesanan->status_transaksi) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pemesanan ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-6 hidden lg:flex flex-col lg:flex-row items-start lg:items-center gap-4 text-sm text-gray-600">
            <div class="flex w-full items-center justify-between">
                <span>
                    Showing {{ $pemesanans->firstItem() }} to {{ $pemesanans->lastItem() }} of {{ $pemesanans->total() }} results
                </span>
                    {{ $pemesanans->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
    
</div>

<script>
function printTableData() {
    // Get the table and title elements
    const table = document.getElementById('printable-table').cloneNode(true);
    const title = document.querySelector('h1.text-2xl').cloneNode(true);
    
    // Remove any elements with class 'no-print' from the cloned table
    const noPrintElements = table.querySelectorAll('.no-print');
    noPrintElements.forEach(el => el.remove());
    
    // Create a new window for printing
    const printWindow = window.open('', '_blank');
    
    // Build the HTML content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Laporan Pemesanan</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; margin-bottom: 20px; color: #000; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th { background-color: #f3f4f6; text-align: left; padding: 8px; border: 1px solid #ddd; }
                td { padding: 8px; border: 1px solid #ddd; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .uppercase { text-transform: uppercase; }
                .font-semibold { font-weight: 600; }
                .text-xs { font-size: 0.75rem; }
                .bg-gray-100 { background-color: #f3f4f6; }
                .bg-blue-100 { background-color: #dbeafe; }
                .bg-green-100 { background-color: #d1fae5; }
                .bg-yellow-100 { background-color: #fef3c7; }
                .bg-red-100 { background-color: #fee2e2; }
                .rounded-full { border-radius: 9999px; }
                .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
                .inline-flex { display: inline-flex; }
                .leading-5 { line-height: 1.25rem; }
            </style>
        </head>
        <body>
    `);
    
    // Add the title and table to the print window
    printWindow.document.write(title.outerHTML);
    printWindow.document.write(table.outerHTML);
    
    // Add print date footer
    printWindow.document.write(`
        <div style="text-align: right; margin-top: 20px; font-size: 0.8rem;">
            Dicetak pada: ${new Date().toLocaleString()}
        </div>
    `);
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    
    // Wait for content to load before printing
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}
</script>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-12">
    <h2 class="text-3xl font-extrabold mb-6 text-gray-900">Performa Staf</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($performaStaf as $staf)
            <div class="p-6 rounded-lg shadow-md
                {{ $staf['color'] === 'green' ? 'bg-green-600 text-white' : 'bg-white text-gray-900' }}
                hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-xl font-semibold mb-1 truncate">
                    {{ $staf['name'] }} 
                    @if($staf['top'] ?? false)
                        <span class="text-yellow-300 font-medium">(Top)</span>
                    @endif
                </h3>
                <p class="text-sm text-gray-300 mb-3 {{ $staf['color'] === 'green' ? 'text-green-200' : 'text-gray-500' }}">
                    Total Rumah Terjual: <span class="font-medium">{{ $staf['total_terjual'] }}</span>
                </p>
                <p class="text-3xl font-bold mb-3">
                    Rp{{ number_format($staf['total'], 0, ',', '.') }}
                </p>
                <div class="w-full h-5 rounded bg-gray-200 overflow-hidden">
                    <div 
                        class="h-full rounded transition-all duration-500" 
                        style="width: {{ $staf['percent'] }}%;
                            background-color: 
                                {{ $staf['color'] === 'green' ? '#ffffff' : ($staf['color'] === 'orange' ? '#f59e0b' : '#ef4444') }};">
                    </div>
                </div>
                <p class="mt-2 text-sm font-medium {{ $staf['color'] === 'green' ? 'text-green-100' : 'text-gray-600' }}">
                    Target: Rp50.000.000 - {{ $staf['percent'] }}%
                </p>
            </div>
        @endforeach
    </div>

    @if(count($performaStaf) > 0)
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
    <h3 class="text-2xl font-bold mb-4">Detail Penjualan Staf</h3>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Staf</th>
                @foreach($performaStaf[0]['produk'] as $blokId => $count)
                    @php
                        $blok = \App\Models\Blok::find($blokId);
                    @endphp
                    <th scope="col" class="px-6 py-3 text-center">{{ $blok->nama_blok ?? 'Blok '.$blokId }}</th>
                @endforeach
                <th scope="col" class="px-6 py-3">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performaStaf as $staf)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $staf['name'] }}</th>
                    @foreach($staf['produk'] as $blokId => $count)
                        <td class="px-6 py-4 text-center">{{ $count }}</td>
                    @endforeach
                    <td class="px-6 py-4 font-medium text-center">{{ $staf['total_terjual'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

</div>

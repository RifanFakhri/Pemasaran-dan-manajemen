<div id="kpr" class="bg-gray-100 min-h-screen py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Simulasi KPR Grand Telar Residence</h1>
        <p class="text-gray-500 mb-10 max-w-2xl">
            Dapatkan informasi KPR dengan bank bank yang berkerjasama dengan kami, dan simulasikan KPR anda di sini.
        </p>

        <!-- Responsive Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Bagian Cards (2/3 kolom) -->
            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($banks as $bank)
                    <div class="flex items-start gap-4 bg-white p-5 rounded-lg shadow hover:shadow-md transition">
                        <div class="text-yellow-400 text-3xl">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg">{{ $bank['name'] }}</h2>
                            <p class="text-gray-500 mb-4 text-sm">
                                {{ $bank['description'] }}
                            </p>
                            <a href="{{ $bank['link'] }}" class="inline-block bg-blue-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-full text-xs md:text-sm">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bagian Formulir (1/3 kolom) -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form id="kprForm" class="space-y-4">
                    <div>
                        <label for="harga" class="block text-gray-700 mb-1">Harga Properti</label>
                        <input id="harga" type="text" name="harga" value="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div>
                        <label for="tahun" class="block text-gray-700 mb-1">Jangka Waktu (Tahun)</label>
                        <input id="tahun" type="number" name="tahun" value="0" min="1" max="30" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div>
                        <label for="bunga" class="block text-gray-700 mb-1">Bunga (%)</label>
                        <input id="bunga" type="number" step="0.1" name="bunga" value="0" min="0" max="20" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-700 hover:bg-indigo-800 text-white py-2 rounded-full">
                        Hitung
                    </button>
                </form>

                <!-- Hasil Angsuran -->
                <div class="mt-6 text-center">
                    <h3 class="text-gray-600">Angsuran per Bulan</h3>
                    <p id="angsuran" class="text-black font-bold text-lg">Rp. 0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome Icons -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<!-- Script Perhitungan -->
<script>
    document.getElementById('kprForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const harga = parseFloat(document.getElementById('harga').value.replace(/\D/g, '')) || 0;
        const tahun = parseFloat(document.getElementById('tahun').value) || 0;
        const bunga = parseFloat(document.getElementById('bunga').value) || 0;
        
        const bulan = tahun * 12;
        const bungaBulanan = bunga / 12 / 100;
        
        if (bulan > 0 && bungaBulanan > 0) {
            const angsuran = Math.round((harga * bungaBulanan) / (1 - Math.pow(1 + bungaBulanan, -bulan)));
            document.getElementById('angsuran').textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angsuran);
        } else {
            document.getElementById('angsuran').textContent = "Rp. 0";
        }
    });

    // Format input harga properti
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });
</script>
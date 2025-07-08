<div class="bg-gray-50 h-auto md:h-[332px] px-6 md:px-16 py-8 rounded-lg shadow-md flex flex-col md:flex-row items-center justify-between gap-8">
    <!-- Kiri: Gambar -->
    <div class="flex justify-center md:ml-20">
        <img src="{{ asset('img/booking.png') }}" alt="Promo" class="w-60 md:w-[300px] h-auto">
    </div>

    <!-- Tengah: Teks -->
    <div class="text-center md:text-left text-black flex-1 md:ml-12">
        <h2 class="text-2xl md:text-4xl font-semibold">Dapatkan promo dan diskon</h2>
        <p class="text-base md:text-lg text-black mt-2">
            Booking Sekarang dan Nikmati Penawaran Khusus!
        </p>
    </div>

    <!-- Kanan: Tombol Arah ke Detail -->
    <div class="mt-4 md:mt-0 md:mr-40">
        <a 
            href="https://wa.me/6285156116173?text=Halo%2C%20saya%20tertarik%20dengan%20promo%20dan%20diskon%20properti" target="_blank"
            class="bg-black text-white px-6 py-3 rounded-lg shadow-md flex items-center hover:bg-indigo-800 transition"
        >
            Kirim Pesan
            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.293 15.707a1 1 0 010-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" />
            </svg>
        </a>
    </div>
</div>

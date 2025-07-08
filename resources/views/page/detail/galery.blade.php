<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.13.5/dist/cdn.min.js"></script>

<div x-data="carousel()" x-init="startAutoplay()" class="max-w-6xl mx-auto mb-4 px-2">
  <!-- Gambar Utama -->
  <div class="relative w-full h-[200px] sm:h-[300px] md:h-[400px] lg:h-[500px] overflow-hidden rounded-lg">
    <img :src="images[active]" @click="showModal = true"
         class="w-full h-full object-cover transition duration-500 cursor-pointer" />

    <!-- Tombol Kiri -->
    <button @click="prev"
            class="absolute top-1/2 left-2 -translate-y-1/2 bg-white hover:bg-gray-100 text-black p-2 rounded-full shadow z-10">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Tombol Kanan -->
    <button @click="next"
            class="absolute top-1/2 right-2 -translate-y-1/2 bg-white hover:bg-gray-100 text-black p-2 rounded-full shadow z-10">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>

  <!-- Thumbnail -->
  <div class="mt-4 flex overflow-x-auto gap-3 px-1 sm:px-2 scrollbar-hide">
    <template x-for="(img, index) in images" :key="index">
      <img
        :src="img"
        @click="active = index"
        class="w-24 h-16 sm:w-28 sm:h-20 object-cover rounded-lg cursor-pointer border-2 transition duration-300"
        :class="{ 'border-blue-500': active === index, 'border-transparent': active !== index }"
      />
    </template>
  </div>

  <!-- Modal -->
  <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
       @click.self="showModal = false" @keydown.escape.window="showModal = false">
    <div class="relative w-full max-w-6xl px-2 sm:px-4">
      <!-- Tombol Close -->
      <button @click="showModal = false"
              class="absolute top-4 right-4 text-white hover:text-gray-300 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <!-- Gambar -->
      <img :src="images[active]" class="w-full h-auto max-h-[70vh] object-contain rounded shadow-lg" />

      <!-- Navigasi Kiri -->
      <button @click.stop="prev"
              class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-black p-2 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

      <!-- Navigasi Kanan -->
      <button @click.stop="next"
              class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-black p-2 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
    </div>
  </div>
</div>

<script>
function carousel() {
  return {
    active: 0,
    interval: null,
    showModal: false,
    images: [
      '/img/aset1.png', 
      '/img/latar2.png',
      '/img/rumah3.png',
      '/img/dapur.jpg',
      '/img/dalem.jpg',
      '/img/wc.jpg'
    ],
    prev() {
      this.active = (this.active - 1 + this.images.length) % this.images.length;
    },
    next() {
      this.active = (this.active + 1) % this.images.length;
    },
    startAutoplay() {
      this.interval = setInterval(() => {
        this.next();
      }, 9000);
    }
  };
}
</script>

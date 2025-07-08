<div class="flex justify-center">
    <nav id="mainNav" class="w-full fixed top-0 left-0 z-30 bg-transparent transition-colors duration-300">
      <div class="max-w-[1440px] mx-auto flex items-center justify-between px-6 py-4">
        <div class="text-white text-2xl font-bold flex items-center gap-2 hover:text-blue-400 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span>Grand Telar</span>
        </div>
        <div class="hidden md:flex gap-12 text-white text-lg">
          <a href="{{ url('/#home') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Home</a>
          <a href="{{ url('/#about') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Tentang Kami</a>
          <a href="{{ url('/#keuntungan') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Keuntungan</a>
          <a href="{{ url('/#properti') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Properti</a>
          <a href="{{ url('/#faq') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">FAQ</a>
          <a href="{{ url('/#lokasi') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Lokasi</a>
          <a href="{{ url('/#kpr') }}" class="hover:text-blue-300 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-blue-300">Simulasi KPR</a>
        </div>
        <div class="hidden md:flex items-center gap-[20px]">
        <a href="{{ route('login') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/30">
          Login<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
        </a>
        </div>
        <div class="md:hidden">
          <button id="menuBtn" class="text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
  
      <div id="mobileMenu" class="md:hidden hidden absolute top-[64px] left-0 w-full bg-black/80 backdrop-blur-md px-[30px] pb-6 transition-all duration-300">
        <a href="{{ url('/#home') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Home</a>
        <a href="{{ url('/#about') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Tentang Kami</a>
        <a href="{{ url('/#keuntungan') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Keuntungan</a>
        <a href="{{ url('/#properti') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Properti</a>
        <a href="{{ url('/#faq') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">FAQ</a>
        <a href="{{ url('/#lokasi') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Lokasi</a>
        <a href="{{ url('/#kpr') }}" class="block text-white hover:text-blue-300 mb-3 text-lg">Kpr</a>
        <a href={{ route('login') }} class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-[20px] hover:bg-blue-700 transition">
          Login
        </a>
      </div>
    </nav>  
</div>

<script>
  // Add scroll event listener to change navbar background
  window.addEventListener('scroll', function() {
    const nav = document.getElementById('mainNav');
    if (window.scrollY > 50) {
      nav.classList.add('bg-black/80');
      nav.classList.remove('bg-transparent');
    } else {
      nav.classList.add('bg-transparent');
      nav.classList.remove('bg-black/80');
    }
  });
</script>
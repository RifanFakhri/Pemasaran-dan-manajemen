<!DOCTYPE html>
<html lang="en"  class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>@yield('title', 'Grand Telar Residence')</title>
  {{-- <html lang="id"> --}}
  
  <!-- Vite CSS & JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-['Poppins']">
  @include('navbar.navbar')
  <main>
    @yield('page.content')
  </main>
  @include('navbar.footer')
  @stack('scripts')
  <script src="{{ asset('js/menu.js') }}" defer></script>
  
  <a href="https://wa.me/6285156116173" 
   class="fixed bottom-6 right-6 z-40 group"
   target="_blank" rel="noopener noreferrer"
   aria-label="Chat via WhatsApp">
   
   <!-- Main Button -->
   <div class="relative">
    
     <!-- Floating effect background -->
     <div class="absolute -inset-1 bg-green-500/30 rounded-full blur-md group-hover:bg-green-600/40 transition-all duration-500 animate-pulse"></div>
     
     <!-- Main button with icon and tooltip -->
     <div class="relative flex items-center justify-center bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
       <i class="fab fa-whatsapp text-3xl"></i>
       
       <!-- Tooltip (hidden on mobile) -->
       <span class="hidden md:block absolute right-full mr-3 px-3 py-1 bg-gray-800 text-white text-sm font-medium rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">
         Chat via WhatsApp
         <span class="absolute top-1/2 right-0 -mt-1 -mr-1 w-2 h-2 transform rotate-45 bg-gray-800"></span>
       </span>
     </div>
     
     <!-- Optional notification badge -->
     <div class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 bg-red-500 rounded-full text-xs text-white font-bold shadow-sm animate-bounce">
       1
     </div>
     
   </div>
   
   <!-- Optional floating animation -->
   <style>
     @keyframes float {
       0% { transform: translateY(0px); }
       50% { transform: translateY(-5px); }
       100% { transform: translateY(0px); }
     }
     .group:hover .relative > div:first-child {
       animation: float 2s ease-in-out infinite;
     }
   </style>
</a>
</body>
</html>

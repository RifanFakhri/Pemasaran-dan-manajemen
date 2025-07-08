<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>@yield('title', 'Grand Telar Residence')</title>
  @vite('resources/css/app.css')
  @livewireStyles
</head>

<body class="bg-gray-50 font-['Poppins']">
  @include('navbar.navbar')
  <main>
    @include('page.detail.home')
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        @yield('page.detail')
      </div>
      @include('page.detail.sidebar')
    </div>
  </main>
  @include('navbar.footer')
  @stack('scripts')
  <script src="{{ asset('js/menu.js') }}" defer></script>
  @livewireScripts
</body>
</html>

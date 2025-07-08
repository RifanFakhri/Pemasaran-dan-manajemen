<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Grand Telar Residence</title>

  @vite('resources/css/app.css')
  @include('component.link')
  @livewireStyles
</head>
<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-100 text-slate-500">
  @include('navbar.navbarAdmin')

  <!-- Ini tempat isi komponen masuk -->
  {{ $slot }}

 
  @livewireScripts
  
</body>
</html>

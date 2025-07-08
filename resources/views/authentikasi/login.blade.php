
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>@yield('title', 'Grand Telar Residence')</title>
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-['Poppins']">

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg flex overflow-hidden">
            <!-- Left Side (Illustration) -->
            <div class="w-1/2 bg-gradient-to-tr from-purple-200 to-green-200 hidden md:flex">
                <img src="{{ asset('img/icon2.png') }}" alt="Login Illustration" class="w-full h-full object-cover">
            </div>
    
            <!-- Right Side (Form) -->
            <div class="w-full md:w-1/2 p-10">
                <div class="mb-6 text-center mt-12">
                    <h2 class="text-2xl font-bold text-gray-700">Login</h2>
                </div>
    
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                
                    <div class="mb-4">
                        <input type="text" name="username" required autofocus
                            class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="yourusername">
                    </div>
                
                    <div class="mb-4 relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 pr-10"
                            placeholder="••••••••">
                        <span id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-500 cursor-pointer">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                
                    <div class="mb-6">
                        <button type="submit"
                            class="w-full py-3 bg-purple-600 text-white font-semibold rounded-md hover:bg-purple-700">
                            LOGIN
                        </button>
                    </div>
                
                    @if ($errors->any())
                        <div class="text-red-500 text-sm text-center mt-2">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </form>                
    
                <div class="mt-8 text-center text-xs text-gray-400">
                    Terms of use. Privacy policy
                </div>
            </div>
        </div>
    </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
  
    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
  
      // Toggle ikon
      this.querySelector('i').classList.toggle('fa-eye');
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  </script>
  
</body>
</html>

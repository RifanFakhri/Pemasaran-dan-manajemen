<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('authentikasi.login');
    }

    // Proses login
    public function Login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mencari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Redirect sesuai dengan role user
            if ($user->role === 'admin') {
                return redirect()->route('admin.index'); // Redirect ke admin dashboard
            } elseif ($user->role === 'marketing') {
                return redirect()->route('marketing.index'); // Redirect ke marketing dashboard
            } else {
                Auth::logout();
                return back()->withErrors(['username' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }
}

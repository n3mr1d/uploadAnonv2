<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPost extends Controller
{
    // Tampilkan halaman login
    public function index()
    {
        return view('admin.login', [
            'title' => 'Login',
        ]);
    }

    // Proses login admin
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|min:3|string',
            'password' => 'required|min:4',
        ]);

        // Cek apakah checkbox "remember me" dicentang
        $remember = $request->has('rememberme');

        // Autentikasi
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // regenerasi session

            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Login success');
        }

        // Jika gagal login
        return redirect()->back()
            ->withErrors(['username' => 'Username or password failed'])
            ->withInput();
    }

    // Tampilkan dashboard admin (harus login)
    public function showDashboard()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard',
        ]);
    }

    public function logout(Request $req)
    {
        $user = Auth();
        $user->logout();
        $req->session()->invalidate();
        $req->session()->regenerate();
        $req->session()->regenerateToken();

        return redirect('/admin')->with('success', 'logout success goodbye');

    }
}

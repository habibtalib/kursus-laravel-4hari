<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Papar borang log masuk.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses log masuk pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak sah.',
            'password.required' => 'Kata laluan wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('pembayar.index'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'E-mel atau kata laluan tidak sepadan.',
        ])->onlyInput('email');
    }

    /**
     * Log keluar pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berjaya log keluar.');
    }
}

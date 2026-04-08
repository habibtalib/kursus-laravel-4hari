<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SelamatDatangMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Papar borang pendaftaran.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran pengguna baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh melebihi 255 aksara.',
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak sah.',
            'email.unique' => 'E-mel ini telah didaftarkan.',
            'password.required' => 'Kata laluan wajib diisi.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Hantar e-mel selamat datang
        Mail::to($user->email)->send(new SelamatDatangMail($user));

        Auth::login($user);

        return redirect()->route('pembayar.index')
            ->with('success', 'Pendaftaran berjaya! Selamat datang, ' . $user->name . '.');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\user;

class LoginController extends Controller
{
    public function login()
    {
        return view('user.account.login');
    }

    public function authenticate(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Coba autentikasi
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('home')->with('success', 'Login berhasil.');
            }

            // Autentikasi gagal
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();

        } catch (ValidationException $e) {
            // Jika validasi gagal
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Jika ada error tak terduga (misal database down, server error)
            Log::error('Login error: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti.',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }


    public function register()
    {
        return view('user.account.register'); // Sesuaikan dengan lokasi file Blade
    }

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => [
                'nullable',
                'string',
                'max:15',
                'regex:/^(08|628)[0-9]{7,12}$/',
            ],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ], [
            'name.min' => 'Nama minimal harus 3 huruf.',
            'phone.regex' => 'Nomor HP harus diawali dengan 08 atau 628.',
        ]);

        $username = strtolower(str_replace(' ', '', $request->name));

        $originalUsername = $username;
        $counter = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        User::create([
            'name' => $request->name,
            'username' => $username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silahkan login.');
    }
}

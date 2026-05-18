<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Kayıt formunu gösterir.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Yeni kullanıcı kaydını yapar.
     */
    public function register(Request $request)
    {
        // Veri Doğrulama
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kullanıcıyı Veritabanına Kaydet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Varsayılan olarak normal üye
            'balance' => 0.00 // İlk kayıt bakiyesi
        ]);

        // Kayıttan sonra otomatik giriş yap
        Auth::login($user);

        return redirect('/products')->with('success', 'Aramıza hoş geldin! İlk alışverişine başlayabilirsin.');
    }
}
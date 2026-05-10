<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Profil sayfasını getir
    public function index()
    {
        return view('profile');
    }

    // İsim, E-posta ve Adres Güncelleme
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string'
        ], [
            'name.required' => 'Ad soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.unique' => 'Bu e-posta adresi başka bir hesap tarafından kullanılıyor.'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    // Şifre Değiştirme İşlemi
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Mevcut şifrenizi girmelisiniz.',
            'password.required' => 'Yeni bir şifre belirlemelisiniz.',
            'password.min' => 'Yeni şifreniz en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Yeni şifreleriniz birbiriyle eşleşmiyor.'
        ]);

        $user = Auth::user();

        // Eski şifre doğru mu kontrol et
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifrenizi yanlış girdiniz.']);
        }

        // Şifreyi şifreleyerek kaydet
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Şifreniz başarıyla değiştirildi.');
    }

    // Hesabı Pasife Al (Dondur)
    public function deactivate(Request $request)
    {
        $user = Auth::user();
        
        // Admin panelinde de kullandığımız is_frozen sütununu 1 yapıyoruz
        $user->is_frozen = 1; 
        $user->save();

        // Kullanıcının oturumunu kapat
        Auth::logout();
        
        // Güvenlik için oturum verilerini temizle
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('info', 'Hesabınız başarıyla pasife alınmıştır. Yeniden aktifleştirmek için lütfen yönetici ile iletişime geçin.');
    }
}
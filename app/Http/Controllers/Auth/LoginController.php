<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
    }

    public function showLoginForm()
    {
        // Eğer kullanıcı zaten giriş yapmışsa ana sayfaya gönder
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    // Sisteme başarılı giriş yapıldıktan hemen sonra çalışan metod
    protected function authenticated(Request $request, $user)
    {
        // Kullanıcının hesabı pasife alınmışsa veya admin tarafından dondurulmuşsa
        if ($user->is_frozen == 1) {
            Auth::logout(); // Oturumu geri kapat
            
            // Güvenlik için oturum verilerini temizle
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Hesabınız pasife alınmış veya dondurulmuştur. Lütfen sistem yöneticisi ile iletişime geçin.');
        }

        // Hesap aktifse normal yönlendirmeye devam et
        return redirect()->intended($this->redirectTo);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Başarıyla çıkış yapıldı.');
    }
}
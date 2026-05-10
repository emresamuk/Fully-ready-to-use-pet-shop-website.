<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function index() {
        return view('contact');
    }

    public function store(Request $request) {
        // 1. Veri Doğrulama ve Özelleştirilmiş Hata Mesajları
        $validatedData = $request->validate([
            'name'    => 'required|min:3|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|min:10'
        ], [
            // Burası hata mesajlarını Türkçeleştirdiğimiz yer
            'name.required'     => 'Ad soyad alanı zorunludur.',
            'name.min'          => 'Adınız en az 3 karakter olmalıdır.',
            'email.required'    => 'E-posta adresi zorunludur.',
            'email.email'       => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'message.required'  => 'Mesaj alanı boş bırakılamaz.',
            'message.min'       => 'Mesajınız en az 10 karakterden oluşmalıdır.'
        ]);

        // 2. Veritabanına Kayıt
        Message::create([
            'name'    => $validatedData['name'],
            'email'   => $validatedData['email'],
            'message' => $validatedData['message']
        ]);

        // 3. Başarı Mesajıyla Geri Dönüş
        return redirect()->back()->with('success', 'Mesajınız patili dostlarımıza ulaştı! En kısa sürede döneceğiz.');
    }
}
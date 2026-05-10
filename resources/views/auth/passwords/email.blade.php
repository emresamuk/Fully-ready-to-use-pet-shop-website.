@extends('layouts.app')

@section('content')
<style>
    .auth_page { background-color: #0a2458; min-height: 100vh; display: flex; align-items: center; padding: 50px 0; }
    .auth_card { background: #ffffff; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); border-bottom: 5px solid #fdd31d; }
    .form_input_custom { border-radius: 10px; padding: 12px 15px; border: 2px solid #eee; transition: 0.3s; }
    .form_input_custom:focus { border-color: #fdd31d; box-shadow: 0 0 10px rgba(253, 211, 29, 0.3); outline: none; }
    .btn_auth { background: #0a2458; color: #fdd31d; width: 100%; padding: 12px; border-radius: 30px; font-weight: 700; border: none; transition: 0.3s; margin-top: 15px; }
    .btn_auth:hover { background: #fdd31d; color: #0a2458; transform: translateY(-2px); }
</style>

<div class="auth_page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth_card">
                    <h3 class="font-weight-bold text-center mb-3" style="color: #0a2458;">Şifremi Unuttum</h3>
                    <p class="text-muted text-center small mb-4">Kayıtlı e-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.</p>
                    
                    @if (session('status'))
                        <div class="alert alert-success shadow-sm" style="border-radius: 10px;">
                            <i class="fa-solid fa-check-circle mr-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold" style="color: #0a2458;">E-Posta Adresiniz</label>
                            <input type="email" name="email" class="form-control form_input_custom @error('email') is-invalid @enderror" required autofocus>
                            @error('email') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn_auth">BAĞLANTIYI GÖNDER <i class="fa-solid fa-paper-plane ml-2"></i></button>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="small" style="color: #0a2458; font-weight: bold;"><i class="fa-solid fa-arrow-left mr-1"></i> Giriş Ekranına Dön</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
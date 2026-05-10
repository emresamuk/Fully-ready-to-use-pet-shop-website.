@extends('layouts.app')

@section('content')
<style>
    .auth_page {
        background-color: #0a2458;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 50px 0;
    }
    .auth_card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border-bottom: 5px solid #fdd31d;
    }
    .auth_title {
        color: #0a2458;
        font-weight: 800;
        text-align: center;
        margin-bottom: 10px;
    }
    .form-group label {
        color: #0a2458;
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    .form_input_custom {
        border-radius: 10px !important;
        padding: 12px 15px !important;
        border: 2px solid #eee !important;
        transition: 0.3s;
        width: 100%;
    }
    .form_input_custom:focus {
        border-color: #fdd31d !important;
        box-shadow: 0 0 10px rgba(253, 211, 29, 0.3) !important;
        outline: none;
    }
    .btn_auth {
        background: #0a2458;
        color: #fdd31d;
        width: 100%;
        padding: 12px;
        border-radius: 30px;
        font-weight: 700;
        text-transform: uppercase;
        border: none;
        transition: 0.3s;
        margin-top: 20px;
        cursor: pointer;
    }
    .btn_auth:hover {
        background: #fdd31d;
        color: #0a2458;
        transform: translateY(-2px);
    }
</style>

<div class="auth_page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="auth_card">
                    <h2 class="auth_title">Aramıza Katıl</h2>
                    <p class="text-center text-muted mb-4 small">Dostunuz için en iyisini seçmeye bir adım kaldı!</p>
                    
                    {{-- Hata Mesajlarını Gösterme Alanı --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="name">Adınız Soyadınız</label>
                            <input id="name" type="text" name="name" class="form_input_custom @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ad Soyad" autofocus>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">E-Posta Adresiniz</label>
                            <input id="email" type="email" name="email" class="form_input_custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="ornek@mail.com">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input id="password" type="password" name="password" class="form_input_custom @error('password') is-invalid @enderror" required placeholder="******">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password-confirm">Şifre Tekrar</label>
                                    <input id="password-confirm" type="password" name="password_confirmation" class="form_input_custom" required placeholder="******">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn_auth">
                            KAYDI TAMAMLA <i class="fa-solid fa-user-plus ml-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="small text-muted">Zaten üye misin? <a href="{{ route('login') }}" style="color: #0a2458; font-weight: bold;">Giriş Yap</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
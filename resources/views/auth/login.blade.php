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
        margin-bottom: 30px;
    }
    .form-group label {
        color: #0a2458;
        font-weight: 600;
    }
    .form_input_custom {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #eee;
        transition: 0.3s;
    }
    .form_input_custom:focus {
        border-color: #fdd31d;
        box-shadow: 0 0 10px rgba(253, 211, 29, 0.3);
        outline: none;
    }
    .is-invalid {
        border-color: #e74c3c !important;
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
        margin-top: 15px;
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
            <div class="col-md-5">
                <div class="auth_card">
                    <h2 class="auth_title">Giriş Yap</h2>
                    
                    {{-- Şifre Başarıyla Değişince Gelen Yeşil Bildirim --}}
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm border-0 mb-4" style="border-radius: 10px;">
                            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 10px;">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info shadow-sm border-0 mb-4" style="border-radius: 10px;">
                            <i class="fa-solid fa-circle-info mr-2"></i> {{ session('info') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">E-Posta Adresiniz</label>
                            <input id="email" type="email" name="email" class="form-control form_input_custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="ornek@mail.com">
                            @error('email')
                                <span class="small text-danger font-weight-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Şifreniz</label>
                            <input id="password" type="password" name="password" class="form-control form_input_custom @error('password') is-invalid @enderror" required placeholder="******">
                            @error('password')
                                <span class="small text-danger font-weight-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" for="remember" style="margin-top: 2px;">Beni Hatırla</label>
                            </div>
                            <a href="{{ url('password/reset') }}" class="small" style="color: #e74c3c; font-weight: bold; text-decoration: none;">
                                Şifremi Unuttum?
                            </a>
                        </div>

                        <button type="submit" class="btn_auth">
                            OTURUM AÇ <i class="fa-solid fa-right-to-bracket ml-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="small text-muted">Hesabın yok mu? <a href="{{ route('register') }}" style="color: #0a2458; font-weight: bold;">Hemen Kayıt Ol</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
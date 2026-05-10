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
                    <h3 class="font-weight-bold text-center mb-4" style="color: #0a2458;">Yeni Şifre Belirle</h3>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label class="font-weight-bold" style="color: #0a2458;">E-Posta Adresiniz</label>
                            <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control form_input_custom @error('email') is-invalid @enderror" required readonly>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" style="color: #0a2458;">Yeni Şifre</label>
                            <input type="password" name="password" class="form-control form_input_custom @error('password') is-invalid @enderror" required autofocus>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color: #0a2458;">Yeni Şifre (Tekrar)</label>
                            <input type="password" name="password_confirmation" class="form-control form_input_custom" required>
                        </div>

                        <button type="submit" class="btn_auth">ŞİFREYİ GÜNCELLE <i class="fa-solid fa-save ml-2"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
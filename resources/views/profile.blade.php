@extends('layouts.app')

@section('content')
<style>
    .profile_page {
        background-color: #0a2458;
        min-height: 100vh;
        padding: 80px 0;
    }
    .profile_card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }
    .profile_header {
        background: #fdd31d;
        padding: 40px;
        text-align: center;
        color: #0a2458;
    }
    .profile_content {
        padding: 40px;
    }
    .balance_badge {
        background: #0a2458;
        color: #fdd31d;
        padding: 15px 30px;
        border-radius: 50px;
        font-size: 24px;
        font-weight: 800;
        display: inline-block;
        margin-top: 20px;
    }
    .form_control_custom {
        border-radius: 10px;
        border: 2px solid #eee;
        padding: 12px;
        transition: 0.3s;
    }
    .form_control_custom:focus {
        border-color: #fdd31d;
        box-shadow: 0 0 10px rgba(253, 211, 29, 0.2);
        outline: none;
    }
    .btn_custom {
        background: #0a2458;
        color: #fdd31d;
        font-weight: bold;
        border-radius: 30px;
        padding: 12px 30px;
        border: none;
        transition: 0.3s;
        width: 100%;
    }
    .btn_custom:hover {
        background: #fdd31d;
        color: #0a2458;
        transform: translateY(-2px);
    }
    .btn_danger_custom {
        background: #e74c3c;
        color: white;
        font-weight: bold;
        border-radius: 30px;
        padding: 12px 30px;
        border: none;
        transition: 0.3s;
        width: 100%;
    }
    .btn_danger_custom:hover {
        background: #c0392b;
        color: white;
        transform: translateY(-2px);
    }

    /* Gizli Form Alanı İçin Animasyon */
    #editProfileSection {
        display: none;
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="profile_page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile_card">
                    {{-- Üst Kısım: Profil Özeti --}}
                    <div class="profile_header">
                        <div class="mb-3">
                            <i class="fa-solid fa-circle-user fa-5x"></i>
                        </div>
                        <h2 class="font-weight-bold">{{ auth()->user()->name }}</h2>
                        <p class="mb-0">Üyelik Tarihi: {{ auth()->user()->created_at->format('d.m.Y') }}</p>
                        <div class="balance_badge">
                            <i class="fa-solid fa-wallet mr-2"></i>${{ number_format(auth()->user()->balance, 2) }}
                        </div>
                    </div>

                    <div class="profile_content">
                        {{-- Başarı ve Hata Mesajları --}}
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- SABİT GÖRÜNÜM MODU --}}
                        <div class="row" id="viewModeSection">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-dark mb-4"><i class="fa-solid fa-address-card mr-2 text-warning"></i>Kişisel Bilgiler</h5>
                                
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <p class="text-muted small text-uppercase mb-1">Adınız Soyadınız</p>
                                        <p class="font-weight-bold text-dark" style="font-size: 1.1rem;">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <p class="text-muted small text-uppercase mb-1">E-Posta</p>
                                        <p class="font-weight-bold text-dark" style="font-size: 1.1rem;">{{ auth()->user()->email }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-muted small text-uppercase mb-1">Teslimat Adresi</p>
                                        <p class="font-weight-bold text-dark">
                                            {{ auth()->user()->address ?? 'Henüz bir adres eklemediniz.' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Düzenleme Modunu Açan Buton --}}
                                <div class="text-center mt-2">
                                    <button type="button" class="btn_custom d-inline-block w-auto px-5" id="toggleEditBtn" onclick="toggleEditMode()">
                                        PROFİLİ GÜNCELLE <i class="fa-solid fa-pen-to-square ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- DÜZENLEME MODU (GİZLİ FORMLAR) --}}
                        <div id="editProfileSection" class="mt-5 pt-4" style="border-top: 2px dashed #eee;">
                            <div class="row">
                                {{-- Sol Taraf: Hesap Bilgilerini Güncelleme Formu --}}
                                <div class="col-md-6 border-right pr-md-4 mb-4 mb-md-0">
                                    <h5 class="font-weight-bold text-dark mb-4"><i class="fa-solid fa-user-pen mr-2 text-warning"></i>Bilgileri Düzenle</h5>
                                    
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-uppercase text-muted">Adınız Soyadınız</label>
                                            <input type="text" name="name" class="form-control form_control_custom" value="{{ auth()->user()->name }}" required>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-uppercase text-muted">E-Posta</label>
                                            <input type="email" name="email" class="form-control form_control_custom" value="{{ auth()->user()->email }}" required>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="small font-weight-bold text-uppercase text-muted">Teslimat Adresi</label>
                                            <textarea name="address" class="form-control form_control_custom" rows="3" placeholder="Siparişlerinizin gönderileceği adres...">{{ auth()->user()->address }}</textarea>
                                        </div>

                                        <button type="submit" class="btn_custom">
                                            BİLGİLERİ KAYDET <i class="fa-solid fa-save ml-2"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Sağ Taraf: Şifre Değiştirme Formu --}}
                                <div class="col-md-6 pl-md-4">
                                    <h5 class="font-weight-bold text-dark mb-4"><i class="fa-solid fa-shield-halved mr-2 text-danger"></i>Şifre Değiştir</h5>
                                    
                                    <form action="{{ route('profile.password') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-uppercase text-muted">Mevcut Şifre</label>
                                            <input type="password" name="current_password" class="form-control form_control_custom" placeholder="Şu anki şifreniz" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-uppercase text-muted">Yeni Şifre</label>
                                            <input type="password" name="password" class="form-control form_control_custom" placeholder="En az 6 karakter" required>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="small font-weight-bold text-uppercase text-muted">Yeni Şifre (Tekrar)</label>
                                            <input type="password" name="password_confirmation" class="form-control form_control_custom" placeholder="Yeni şifre tekrar" required>
                                        </div>
                                        
                                        <button type="submit" class="btn_danger_custom">
                                            ŞİFREYİ GÜNCELLE <i class="fa-solid fa-key ml-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- HESAP DONDURMA (TEHLİKELİ BÖLGE) --}}
                        <div class="row mt-5 pt-4" style="border-top: 2px dashed #e74c3c;">
                            <div class="col-12 text-center">
                                <h5 class="font-weight-bold mb-3" style="color: #e74c3c;">
                                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>Hesap Pasifleştirme
                                </h5>
                                <p class="text-muted small mb-3">Hesabınızı pasife aldığınızda sistemden otomatik çıkış yapılır ve bir daha giriş yapamazsınız. Yeniden aktifleştirmek için yönetici ile iletişime geçmeniz gerekir.</p>
                                
                                <form action="{{ route('profile.deactivate') }}" method="POST" onsubmit="return confirm('DİKKAT: Hesabınızı pasife almak (dondurmak) istediğinize emin misiniz?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger px-4 py-2" style="border-radius: 30px; font-weight: bold; border-width: 2px;">
                                        <i class="fa-solid fa-user-lock mr-2"></i> HESABIMI PASİFE AL
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function toggleEditMode() {
        var editSection = document.getElementById("editProfileSection");
        var toggleBtn = document.getElementById("toggleEditBtn");

        if (editSection.style.display === "none" || editSection.style.display === "") {
            // Formu Aç
            editSection.style.display = "block";
            toggleBtn.innerHTML = 'GÜNCELLEMEYİ İPTAL ET <i class="fa-solid fa-times ml-2"></i>';
            toggleBtn.classList.remove('btn_custom');
            toggleBtn.classList.add('btn_danger_custom');
        } else {
            // Formu Kapat
            editSection.style.display = "none";
            toggleBtn.innerHTML = 'PROFİLİ GÜNCELLE <i class="fa-solid fa-pen-to-square ml-2"></i>';
            toggleBtn.classList.remove('btn_danger_custom');
            toggleBtn.classList.add('btn_custom');
        }
    }

    // Eğer sayfada bir doğrulama hatası varsa (şifre yanlış vb.), formu açık tut
    @if ($errors->any())
        document.getElementById("editProfileSection").style.display = "block";
        var toggleBtn = document.getElementById("toggleEditBtn");
        toggleBtn.innerHTML = 'GÜNCELLEMEYİ İPTAL ET <i class="fa-solid fa-times ml-2"></i>';
        toggleBtn.classList.remove('btn_custom');
        toggleBtn.classList.add('btn_danger_custom');
    @endif
</script>
@endsection
@endsection
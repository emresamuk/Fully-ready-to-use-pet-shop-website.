@extends('layouts.app')

@section('content')
<section class="contact_section layout_padding" style="background-color: #f4f7f6;">
    <div class="container">
        <div class="heading_container mb-5 text-center">
            <h2 style="color: #0a2458; font-weight: 800; position: relative; display: inline-block;">
                Bizimle İletişime Geçin
                <div style="height: 4px; width: 60px; background: #fdd31d; margin: 10px auto; border-radius: 2px;"></div>
            </h2>
            <p class="text-muted">Sorularınız, önerileriniz veya patili dostlarınız hakkındaki her şey için bize yazabilirsiniz.</p>
        </div>

        {{-- Başarı Mesajı --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 animate__animated animate__fadeIn" style="border-radius: 15px; background-color: #27ae60; color: white;">
                <i class="fa-solid fa-paper-plane mr-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Hata Mesajları --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            {{-- İletişim Formu --}}
            <div class="col-md-6 mb-4">
                <div class="form_container shadow-sm p-4 bg-white" style="border-radius: 20px; border-top: 6px solid #fdd31d; height: 100%;">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" style="font-weight: 600; color: #0a2458;">Adınız Soyadınız</label>
                            <input type="text" name="name" id="name" class="form-control" style="border-radius: 10px; padding: 12px; border: 1px solid #eee;" placeholder="Adınızı ve soyadınızı giriniz" value="{{ old('name') }}" required />
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email" style="font-weight: 600; color: #0a2458;">E-Posta Adresiniz</label>
                            <input type="email" name="email" id="email" class="form-control" style="border-radius: 10px; padding: 12px; border: 1px solid #eee;" placeholder="E-posta adresinizi giriniz" value="{{ old('email') }}" required />
                        </div>

                        <div class="form-group mb-4">
                            <label for="message" style="font-weight: 600; color: #0a2458;">Mesajınız</label>
                            <textarea name="message" id="message" class="form-control" style="border-radius: 10px; height: 150px; border: 1px solid #eee;" placeholder="Mesajınızı buraya yazabilirsiniz..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 shadow-sm" style="background-color: #0a2458; border: none; border-radius: 30px; font-weight: bold; color: #fdd31d; transition: 0.3s;">
                            MESAJI GÖNDER <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Harita ve Bilgiler --}}
            <div class="col-md-6 mb-4">
                <div class="map_container shadow-sm bg-white" style="border-radius: 20px; overflow: hidden; height: 100%; min-height: 450px; display: flex; flex-direction: column;">
                    <div style="flex-grow: 1; width: 100%;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0; min-height: 350px;" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2134.92672923382!2d29.91964885613384!3d40.82264048914438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cb4ef33844cccb%3A0x783e419b5d0539ef!2sKocaeli%20%C3%9Cniversitesi%20Teknoloji%20Fak%C3%BCltesi!5e0!3m2!1str!2str!4v1778363791380!5m2!1str!2str" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    
                    <div class="p-4" style="background-color: #ffffff;">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 style="color: #0a2458; font-weight: 700; font-size: 16px;">Drool Ofis</h5>
                                <p class="text-muted small mb-1"><i class="fa-solid fa-location-dot mr-2 text-warning"></i> Kabaoğlu, İzmit/Kocaeli</p>
                                <p class="text-muted small"><i class="fa-solid fa-phone mr-2 text-warning"></i> +90 262 123 45 67</p>
                            </div>
                            <div class="col-sm-6">
                                <h5 style="color: #0a2458; font-weight: 700; font-size: 16px;">Çalışma Saatleri</h5>
                                <p class="text-muted small mb-1">Pzt - Cmt: 09:00 - 20:00</p>
                                <p class="text-muted small">Pazar: Kapalı</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .form_container button:hover {
        background-color: #fdd31d !important;
        color: #0a2458 !important;
        transform: translateY(-3px);
    }
    .form-control:focus {
        border-color: #fdd31d !important;
        box-shadow: 0 0 10px rgba(253, 211, 29, 0.2) !important;
    }
</style>
@endsection
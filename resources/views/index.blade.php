@extends('layouts.app')

@section('content')
  <section class="slider_section" style="background-color: #fdd31d; padding: 80px 0;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="detail_box">
            <h1 style="color: #0a2458; font-weight: 800; font-size: 3.5rem;">
              Dostlarınız İçin <br>
              <span style="color: #ffffff; text-shadow: 2px 2px #0a2458;">En İyisi!</span>
            </h1>
            <p style="font-size: 1.1rem; color: #0a2458; margin: 20px 0;">
              Drool Pet Shop olarak, patili dostlarınızın mutluluğu ve sağlığı için dünya markalarını kapınıza getiriyoruz. 
            </p>
            <div class="btn-box">
              <a href="{{ url('/products') }}" class="btn" style="background: #0a2458; color: white; border-radius: 30px; padding: 10px 30px; font-weight: bold;"> Alışverişe Başla </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{ asset('images/slider-img.png') }}" alt="" class="img-fluid" style="max-height: 400px;">
        </div>
      </div>
    </div>
  </section>

  <section class="features_section layout_padding" style="background: #ffffff;">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-3 mb-4">
          <div class="feature_box">
            <i class="fa-solid fa-truck-fast fa-3x mb-3" style="color: #fdd31d;"></i>
            <h5 style="color: #0a2458; font-weight: bold;">Hızlı Teslimat</h5>
            <p class="small text-muted">Aynı gün kargo imkanı ile mamalar taze kalsın.</p>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="feature_box">
            <i class="fa-solid fa-award fa-3x mb-3" style="color: #fdd31d;"></i>
            <h5 style="color: #0a2458; font-weight: bold;">%100 Orijinal</h5>
            <p class="small text-muted">Sadece onaylı ve kaliteli markaları satıyoruz.</p>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="feature_box">
            <i class="fa-solid fa-headset fa-3x mb-3" style="color: #fdd31d;"></i>
            <h5 style="color: #0a2458; font-weight: bold;">7/24 Destek</h5>
            <p class="small text-muted">Müşteri hizmetlerimiz her sorunuzda yanınızda.</p>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="feature_box">
            <i class="fa-solid fa-wallet fa-3x mb-3" style="color: #fdd31d;"></i>
            <h5 style="color: #0a2458; font-weight: bold;">Güvenli Ödeme</h5>
            <p class="small text-muted">Bakiye sistemimiz ile hızlı ve korumalı işlem.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="food_section layout_padding" style="background: #0a2458;">
    <div class="container">
      <div class="heading_container text-center mb-5">
        <h2 style="color: #fdd31d; font-weight: bold;">Öne Çıkan Ürünler</h2>
        <p style="color: white;">Sizin için seçtiğimiz popüler ürünlere göz atın.</p>
      </div>
      
      <div class="row">
        @foreach($products as $product)
          <div class="col-md-4 mb-4">
            <div class="box shadow-sm text-center" style="background: white; padding: 20px; border-radius: 20px;">
              <div class="img-box">
                <img src="{{ asset('images/' . $product->image) }}" width="150" class="img-fluid">
              </div>
              <div class="detail-box mt-3">
                <h6 style="color: #0a2458; font-weight: bold;">{{ $product->name }}</h6>
                <h5 style="color: #fdd31d; background: #0a2458; display: inline-block; padding: 5px 15px; border-radius: 10px;">${{ number_format($product->price, 2) }}</h5>
                <div class="mt-3">
                    <a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-sm font-weight-bold" style="border-radius: 20px;">Sepete Ekle</a>
                    <a href="{{ url('/product/'.$product->id) }}" class="btn btn-outline-dark btn-sm ml-1" style="border-radius: 20px;">İncele</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <div class="text-center mt-5">
        <a href="{{ url('/products') }}" class="btn btn-warning" style="border-radius: 30px; font-weight: bold; padding: 10px 40px;">
          Tüm Ürünleri Gör <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="about_section layout_padding" style="background: #fdd31d;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="img-box text-center">
            <img src="{{ asset('images/pet-img.png') }}" alt="" class="img-fluid rounded shadow" style="max-height: 400px;">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box p-4">
            <h2 style="color: #0a2458; font-weight: bold;">Biz Kimiz?</h2>
            <p class="mt-3" style="color: #0a2458;">
              Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği çatısı altında temelleri atılan Drool, sadece bir mağaza değil, evcil hayvan severlerin buluşma noktasıdır. 
            </p>
            <a href="{{ url('/about') }}" class="btn mt-3" style="background: #0a2458; color: #fdd31d; border-radius: 30px; font-weight: bold; padding: 10px 30px;">Daha Fazla Bilgi</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="client_section layout_padding">
    <div class="container text-center">
      <h2 style="color: #0a2458; font-weight: bold; margin-bottom: 40px;">Müşterilerimiz Ne Diyor?</h2>
      <div class="row">
        @php 
          $testimonials = [
            ['name' => 'Ertuğrul Ö.', 'text' => 'Sipariş verdim, 24 saat geçmeden mama elimdeydi. Gerçekten çok hızlılar.'],
            ['name' => 'Kadir Ç.', 'text' => 'Ürünler kaliteli ve paketleme çok sağlamdı. Artık tek adresim Drool.'],
            ['name' => 'Emre S.', 'text' => 'Bakiye sistemi çok pratik olmuş, iadeler anında hesabıma geçiyor.'],
          ];
        @endphp
        @foreach($testimonials as $t)
        <div class="col-md-4">
          <div class="testimonial shadow-sm p-4 bg-white mb-4" style="border-radius: 15px; border-bottom: 5px solid #fdd31d;">
            <p class="italic">"{{ $t['text'] }}"</p>
            <h6 class="mt-3 font-weight-bold" style="color: #0a2458;">- {{ $t['name'] }}</h6>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
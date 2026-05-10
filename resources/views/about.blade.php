@extends('layouts.app')

@section('content')
  <section class="about_section layout_padding">
    <div class="container">
      <div class="detail-box">
        <div class="heading_container">
          <img src="{{ asset('images/heading-img.png') }}" alt="">
          <h2>About Us</h2>
        </div>
        <p>
          Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği Web Programlama projesi kapsamında geliştirilen bu e-ticaret sitesi, evcil hayvan sahiplerinin ihtiyaçlarını en hızlı ve güvenilir şekilde karşılamayı amaçlamaktadır.
        </p>
        <div class="btn-box">
        </div>
      </div>
    </div>
  </section>
  <section class="animal_section layout_padding">
    <div class="container">
      <div class="animal_container">
        <div class="box b1">
          <div class="img-box">
            <img src="{{ asset('images/dog.jpg') }}" alt="">
          </div>
          <div class="detail-box">
            <h5>Köpekler</h5>
            <p>Sadık dostlarınız için en kaliteli mamalar ve aksesuarlar.</p>
          </div>
        </div>
        <div class="box b2">
          <div class="img-box">
            <img src="{{ asset('images/bird.jpg') }}" alt="">
          </div>
          <div class="detail-box">
            <h5>Kuşlar</h5>
            <p>Kanatlı dostlarınızın sağlığı için her şey burada.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
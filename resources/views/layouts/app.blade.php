<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
  <title>Drool Pet Shop</title>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,500|Poppins:400,700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />

  <style>
    header.header_section {
      background: #fdd31d; 
      padding: 12px 0;
      width: 100%;
      z-index: 1050;
      position: relative;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      padding: 0;
    }

    .icon_btn {
      background: #0a2458; 
      color: #fdd31d;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid transparent;
      margin-left: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .icon_btn:hover { 
      background: #ffffff; 
      color: #0a2458; 
      border-color: #0a2458;
      transform: translateY(-2px);
      text-decoration: none;
    }

    .balance_text {
      color: #0a2458;
      font-weight: 700;
      margin-right: 5px;
      font-size: 16px;
      background: rgba(255,255,255,0.3);
      padding: 5px 15px;
      border-radius: 20px;
    }

    .menu_dropdown {
      position: absolute;
      top: 65px;
      right: 0; 
      background: #0a2458;
      width: 240px;
      border-radius: 15px;
      display: none;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      z-index: 2000;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,0.1);
    }

    .menu_dropdown a {
      color: white;
      padding: 15px 25px;
      text-decoration: none;
      display: block;
      font-size: 15px;
      transition: 0.2s;
      border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .menu_dropdown a:hover { 
      background: #fdd31d; 
      color: #0a2458; 
      padding-left: 30px;
    }

    .show { display: block !important; }

    body { background-color: #ffffff; }
    .sub_page header.header_section { position: relative; }
    
    .info_section {
      background-color: #0a2458;
      color: white;
      padding: 60px 0 30px 0;
    }

    .footer_section {
      background-color: #252525;
      padding: 20px 0;
      color: #888;
      border-top: 1px solid rgba(255,255,255,0.1);
    }
  </style>
</head>

<body class="{{ Request::is('/') ? '' : 'sub_page' }}">

  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg d-flex justify-content-between align-items-center p-0">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('images/logo.png') }}" width="50" alt="Drool Logo">
        </a>

        <div class="d-flex align-items-center position-relative">
          @auth
              {{-- Bakiye --}}
              <span class="balance_text d-none d-sm-inline">
                <i class="fa-solid fa-wallet mr-1"></i> ${{ number_format(auth()->user()->balance, 2) }}
              </span>
              
              {{-- Sepet --}}
              <a href="{{ url('/cart') }}" class="icon_btn position-relative" title="Sepetim">
                <i class="fa-solid fa-cart-shopping"></i>
                @if(session('cart') && count(session('cart')) > 0)
                  <span class="badge badge-danger position-absolute" 
                        style="top: -5px; right: -5px; border-radius: 50%; font-size: 10px; padding: 4px 6px; border: 2px solid #fdd31d;">
                    {{ count(session('cart')) }}
                  </span>
                @endif
              </a>

              {{-- Çıkış Yap --}}
              <form action="{{ url('/logout') }}" method="POST" id="logout-form" style="display:none;">@csrf</form>
              <button class="icon_btn" onclick="document.getElementById('logout-form').submit()" title="Çıkış Yap">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
              </button>

              {{-- Menü  --}}
              <button class="icon_btn" onclick="toggleMenu()" title="Menü">
                <i class="fa-solid fa-bars"></i>
              </button>

          @else
              {{-- Giriş yapmamış kullanıcı sıralaması --}}
              <a href="{{ url('/cart') }}" class="icon_btn position-relative" title="Sepetim">
                <i class="fa-solid fa-cart-shopping"></i>
              </a>
              <a href="{{ url('/login') }}" class="icon_btn" title="Giriş Yap"><i class="fa-solid fa-user"></i></a>
              
              <button class="icon_btn" onclick="toggleMenu()" title="Menü">
                <i class="fa-solid fa-bars"></i>
              </button>
          @endauth

          {{-- Dropdown Menü --}}
          <div id="myDropdown" class="menu_dropdown">
            <a href="{{ url('/') }}"><i class="fa-solid fa-house mr-2"></i> Anasayfa</a>
            <a href="{{ url('/products') }}"><i class="fa-solid fa-paw mr-2"></i> Ürünlerimiz</a>
            <a href="{{ url('/about') }}"><i class="fa-solid fa-info-circle mr-2"></i> Hakkımızda</a>
            <a href="{{ url('/contact') }}"><i class="fa-solid fa-envelope mr-2"></i> İletişim</a>
            @auth
              <a href="{{ url('/my-orders') }}"><i class="fa-solid fa-box mr-2"></i> Siparişlerim</a>
              <a href="{{ url('/profile') }}"><i class="fa-solid fa-user-gear mr-2"></i> Profilim</a>
              @if(auth()->user()->role == 'admin')
                <a href="{{ url('/admin') }}" style="color: #fdd31d;"><i class="fa-solid fa-gauge-high mr-2"></i> Admin Paneli</a>
              @endif
            @endauth
          </div>
        </div>
      </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <section class="info_section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 style="color: #fdd31d; font-weight: bold; margin-bottom: 20px;">DROOL PET SHOP</h5>
          <p style="font-size: 14px; opacity: 0.8;">
            Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği tarafından patili dostlarımız için sevgiyle geliştirildi.
          </p>
        </div>
        <div class="col-md-4 px-md-5">
          <h5 style="color: #fdd31d; font-weight: bold; margin-bottom: 20px;">HIZLI ERİŞİM</h5>
          <ul class="list-unstyled">
            <li><a href="{{ url('/products') }}" class="text-white small d-block mb-2">Ürünlerimiz</a></li>
            <li><a href="{{ url('/about') }}" class="text-white small d-block mb-2">Biz Kimiz?</a></li>
            <li><a href="{{ url('/contact') }}" class="text-white small d-block mb-2">Bize Ulaşın</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5 style="color: #fdd31d; font-weight: bold; margin-bottom: 20px;">İLETİŞİM BİLGİLERİ</h5>
          <p class="small mb-2"><i class="fa-solid fa-location-dot mr-2" style="color: #fdd31d;"></i> Umuttepe, Kocaeli</p>
          <p class="small mb-2"><i class="fa-solid fa-envelope mr-2" style="color: #fdd31d;"></i> info@droolpetshop.com</p>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer_section text-center" style="background-color: #1a1a1a; padding: 10px 0; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container">
      <p style="color: #fdd31d; margin: 0; font-size: 12px; font-weight: 300; letter-spacing: 1px; font-family: 'Poppins', sans-serif;">
        &copy; 2026 <strong>DROOL PET SHOP</strong>. TÜM HAKLARI SAKLIDIR.
      </p>
    </div>
  </footer>

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  
  <script>
    function toggleMenu() {
      document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
      if (!event.target.closest('.icon_btn')) {
        var dropdowns = document.getElementsByClassName("menu_dropdown");
        for (var i = 0; i < dropdowns.length; i++) {
          if (dropdowns[i].classList.contains('show')) {
            dropdowns[i].classList.remove('show');
          }
        }
      }
    }
  </script>
  
  @yield('scripts')
</body>

</html>
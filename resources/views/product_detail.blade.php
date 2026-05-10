@extends('layouts.app')

@section('content')
<section class="about_section layout_padding" style="background-color: #f9f9f9; min-height: 80vh;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Hata Mesajı (Stok yetersizliği uyarısı için) --}}
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="img-box shadow-sm" style="background: white; padding: 20px; border-radius: 20px;">
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 15px; {{ $product->stock <= 0 ? 'filter: grayscale(0.5);' : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box px-md-4">
                    <div class="heading_container mb-3">
                        <h2 style="color: #0a2458; font-weight: 800; font-size: 2.5rem;">{{ $product->name }}</h2>
                    </div>
                    
                    <div class="price_box mb-4">
                        <h4 style="color: #27ae60; font-weight: 700;">
                            <span style="font-size: 1.2rem; color: #888;">Fiyat:</span> ${{ number_format($product->price, 2) }}
                        </h4>
                        <p class="mt-2">
                            <i class="fa-solid fa-boxes-stacked mr-1"></i> Stok Durumu: 
                            @if($product->stock > 0)
                                <strong class="text-success">{{ $product->stock }} Adet</strong>
                            @else
                                <strong class="text-danger">TÜKENDİ</strong>
                            @endif
                        </p>
                    </div>

                    <p style="line-height: 1.8; color: #555; font-size: 1.1rem;">
                        Bu ürün evcil hayvanınız için en yüksek kalite standartlarında üretilmiştir. 
                        Drool Pet Shop güvencesiyle patili dostunuzun mutluluğu için özenle paketlenir.
                    </p>

                    <hr class="my-4" style="opacity: 0.1;">

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <label class="small font-weight-bold text-uppercase d-block mb-1">Adet</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                           class="form-control text-center" 
                                           style="width: 80px; border-radius: 10px; border: 2px solid #eee;">
                                </div>

                                <div class="flex-grow-1 pt-4">
                                    <button type="submit" class="btn btn-block py-3 shadow-sm" 
                                            style="background-color: #0a2458; color: #fdd31d; border-radius: 15px; font-weight: 700; font-size: 1.1rem; transition: 0.3s;">
                                        <i class="fa-solid fa-cart-plus mr-2"></i> SEPETE EKLE
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mt-4">
                            <button class="btn btn-secondary btn-block py-3 shadow-sm" style="border-radius: 15px; font-weight: 700; opacity: 0.8;" disabled>
                                <i class="fa-solid fa-ban mr-2"></i> ŞU AN STOKTA YOK
                            </button>
                            <p class="text-danger small mt-2 font-weight-bold">Bu ürün tükendiği için sipariş verilememektedir.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
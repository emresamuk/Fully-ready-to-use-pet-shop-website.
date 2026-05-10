@extends('layouts.app')

@section('content')
<style>
    .all_products_page {
        background-color: #0a2458;
        min-height: 100vh;
        padding: 80px 0;
    }
    .all_products_page h2 { color: #fdd31d !important; font-weight: 800; }
    .all_products_page p { color: #ffffff !important; opacity: 0.9; }
    
    /* Filtreleme Formu Stili */
    .filter_box {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 50px;
    }
    .filter_label {
        color: #0a2458;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        display: block;
        margin-bottom: 8px;
    }
    
    /* Input ve Select Ortak Stil */
    .filter_input {
        height: 50px !important; /* Yükseklik sabitlendi */
        border-radius: 12px;
        border: 2px solid #eee;
        padding: 10px 15px;
        transition: 0.3s;
        width: 100%;
        color: #333;
    }
    
    /* Dropdown (Select) Özel Düzenleme */
    select.filter_input {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%230a2458' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        cursor: pointer;
    }

    .filter_input:focus {
        border-color: #fdd31d;
        box-shadow: none;
        outline: none;
    }

    /* Kart Boyutlarını Eşitleme */
    .product_card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        transition: 0.3s;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    .product_card:hover { transform: translateY(-10px); }
    .product_name { color: #0a2458; font-weight: 700; font-size: 1.2rem; }
    .product_price { color: #fdd31d; background: #0a2458; display: inline-block; padding: 6px 18px; border-radius: 10px; font-weight: bold; }
    
    .sold_out_badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #e74c3c;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 2;
    }
</style>

<div class="all_products_page">
    <div class="container">
        <div class="heading_container text-center mb-5">
            <img src="{{ asset('images/heading-img.png') }}" alt="" class="mx-auto d-block">
            <h2 class="mt-3">Tüm Ürünlerimiz</h2>
            <p>Patili dostlarınız için en kaliteli seçenekler lacivert şıklığıyla burada.</p>
        </div>

        <div class="filter_box">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label class="filter_label"><i class="fa fa-search mr-1"></i> Ürün Ara</label>
                        <input type="text" name="search" class="form-control filter_input" 
                               placeholder="Hangi ürünü aramıştınız?" value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="filter_label"><i class="fa fa-tags mr-1"></i> Kategori</label>
                        <select name="category" class="form-control filter_input">
                            <option value="">Tüm Kategoriler</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-warning font-weight-bold flex-grow-1 mr-2" 
                                    style="border-radius: 12px; color: #0a2458; height: 50px;">
                                FİLTRELE
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                               style="border-radius: 12px; width: 50px; height: 50px;">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            @forelse($products as $product)
            <div class="col-md-4 mb-5 d-flex align-items-stretch">
                <div class="product_card text-center w-100">
                    @if($product->stock <= 0)
                        <div class="sold_out_badge">TÜKENDİ</div>
                    @endif

                    <div>
                        <div class="img-box mb-3">
                            <img src="{{ asset('images/' . $product->image) }}" alt="" 
                                 style="max-height: 160px; {{ $product->stock <= 0 ? 'filter: grayscale(1); opacity: 0.6;' : '' }}" 
                                 class="img-fluid">
                        </div>
                        <div class="detail-box">
                            <h5 class="product_name">{{ $product->name }}</h5>
                            <h4 class="product_price mt-2">${{ number_format($product->price, 2) }}</h4>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        @if($product->stock > 0)
                            <a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning font-weight-bold btn-block mb-2" style="border-radius: 20px;">
                                <i class="fa-solid fa-cart-plus mr-2"></i> Sepete Ekle
                            </a>
                        @else
                            <button class="btn btn-danger font-weight-bold btn-block mb-2" style="border-radius: 20px;" disabled>
                                <i class="fa-solid fa-ban mr-2"></i> STOKTA YOK
                            </button>
                        @endif
                        
                        <a href="{{ url('/product/'.$product->id) }}" class="btn btn-outline-dark btn-block" style="border-radius: 20px;">
                            İncele
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-magnifying-glass fa-3x text-white mb-3" style="opacity: 0.5;"></i>
                <h4 class="text-white">Aradığınız kriterlere uygun ürün bulunamadı.</h4>
                <p class="text-white-50">Lütfen farklı bir kelime veya kategori deneyin.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
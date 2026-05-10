@extends('layouts.app')

@section('content')
<style>
    .cart_page {
        background-color: #0a2458;
        min-height: 100vh;
        padding: 80px 0;
    }
    .cart_container {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }
    .table tbody td {
        vertical-align: middle;
        text-align: center;
        color: #333;
    }
    .product_img {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }
    .quantity_btn {
        width: 35px;
        height: 35px;
        border: 1px solid #0a2458;
        background: white;
        color: #0a2458;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.2s;
    }
    .quantity_btn:hover {
        background: #0a2458;
        color: #fdd31d;
    }
    .quantity_btn:disabled {
        border-color: #ccc;
        color: #ccc;
        cursor: not-allowed;
    }
    .quantity_value {
        margin: 0 15px;
        font-weight: bold;
        font-size: 16px;
    }
    .btn_checkout {
        background: #fdd31d;
        color: #0a2458;
        font-weight: 800;
        padding: 15px;
        border-radius: 30px;
        border: none;
        width: 100%;
        transition: 0.3s;
    }
    .btn_checkout:hover:not(:disabled) {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    .btn_checkout:disabled {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
    }
    .payment_box {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #eee;
    }
</style>

<div class="cart_page">
    <div class="container">
        <div class="cart_container">
            <h2 class="mb-4 text-dark font-weight-bold"><i class="fa-solid fa-cart-shopping mr-2 text-warning"></i>Alışveriş Sepetim</h2>

            @if(session('success'))
                <div class="alert alert-success" style="border-radius: 10px;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" style="border-radius: 10px;">{{ session('error') }}</div>
            @endif

            @if(session('cart') && count(session('cart')) > 0)
                @php $hasStockIssue = false; @endphp
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead>
                            <tr class="text-dark" style="border-bottom: 2px solid #0a2458;">
                                <th class="text-left">Ürün</th>
                                <th>Fiyat</th>
                                <th>Adet</th>
                                <th>Durum</th> {{-- Yeni Sütun --}}
                                <th>Toplam</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @foreach(session('cart') as $id => $details)
                                @php 
                                    $total += $details['price'] * $details['quantity'];
                                    $productData = \App\Models\Product::find($id);
                                    $isOutOfStock = !$productData || $productData->stock < $details['quantity'];
                                    if($isOutOfStock) $hasStockIssue = true;
                                @endphp
                                <tr>
                                    <td class="text-left">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/'.$details['image']) }}" class="product_img mr-3">
                                            <span class="font-weight-bold">{{ $details['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($details['price'], 2) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form action="{{ url('/cart/decrement/'.$id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="quantity_btn">-</button>
                                            </form>

                                            <span class="quantity_value">{{ $details['quantity'] }}</span>

                                            <form action="{{ url('/cart/increment/'.$id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="quantity_btn" {{ ($productData && $details['quantity'] >= $productData->stock) ? 'disabled' : '' }}>+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td> {{-- Stok Uyarı Alanı --}}
                                        @if(!$productData || $productData->stock <= 0)
                                            <span class="badge badge-danger">Tükendi</span>
                                        @elseif($productData->stock < $details['quantity'])
                                            <span class="badge badge-warning text-dark">Yetersiz Stok (Max: {{ $productData->stock }})</span>
                                        @else
                                            <span class="badge badge-success">Stokta Var</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold text-dark">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                    <td>
                                        <form action="{{ url('remove-from-cart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 50%; width: 35px; height: 35px; padding: 0;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-5">
                    <div class="col-md-5 mb-4 mb-md-0">
                        <a href="{{ url('/products') }}" class="btn btn-outline-dark px-4 py-2" style="border-radius: 30px; font-weight: bold;">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Alışverişe Devam Et
                        </a>
                    </div>

                    <div class="col-md-7">
                        <div class="payment_box shadow-sm">
                            <h4 class="font-weight-bold text-dark mb-4 border-bottom pb-2">Sipariş Özeti ve Ödeme</h4>
                            
                            @auth
                                @php
                                    $userBalance = auth()->user()->balance ?? 0;
                                    $amountToPay = $total;
                                    $usedBalance = 0;

                                    if ($userBalance > 0) {
                                        if ($userBalance >= $total) {
                                            $usedBalance = $total;
                                            $amountToPay = 0;
                                        } else {
                                            $usedBalance = $userBalance;
                                            $amountToPay = $total - $userBalance;
                                        }
                                    }
                                @endphp

                                <div class="d-flex justify-content-between mb-2 text-muted">
                                    <span>Sepet Toplamı:</span>
                                    <span class="font-weight-bold text-dark">${{ number_format($total, 2) }}</span>
                                </div>

                                @if($usedBalance > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span><i class="fa-solid fa-wallet mr-1"></i> Cüzdandan Düşülen:</span>
                                        <span class="font-weight-bold">- ${{ number_format($usedBalance, 2) }}</span>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mb-4 border-top pt-3" style="font-size: 1.3rem;">
                                    <span class="font-weight-bold text-dark">Ödenecek Tutar:</span>
                                    <span class="font-weight-bold" style="color: #e74c3c;">${{ number_format($amountToPay, 2) }}</span>
                                </div>

                                {{-- Stok hatası varsa ödeme formunu kısıtla --}}
                                @if($hasStockIssue)
                                    <div class="alert alert-danger small mb-4" style="border-radius: 10px;">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> Sepetinizdeki bazı ürünlerin stoğu değişmiş. Lütfen adetleri güncelleyin.
                                    </div>
                                @endif

                                <form action="{{ url('/checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cart_total" value="{{ $total }}">

                                    @if($amountToPay > 0)
                                        <div class="credit-card-info bg-white p-3 mb-4" style="border-radius: 10px; border: 1px dashed #ccc; opacity: {{ $hasStockIssue ? '0.5' : '1' }}">
                                            <p class="small font-weight-bold text-muted mb-3"><i class="fa-regular fa-credit-card mr-1"></i> Kredi Kartı Bilgileri</p>
                                            
                                            <div class="form-group mb-2">
                                                <input type="text" name="cc_name" class="form-control" placeholder="Kart Üzerindeki İsim" required {{ $hasStockIssue ? 'disabled' : '' }}>
                                            </div>
                                            <div class="form-group mb-2">
                                                <input type="text" id="cc_number" name="cc_number" class="form-control" placeholder="Kart Numarası" maxlength="19" required {{ $hasStockIssue ? 'disabled' : '' }}>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="cc_expiry" class="form-control" placeholder="12/28" required {{ $hasStockIssue ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="cc_cvv" class="form-control" placeholder="CVV" maxlength="3" required {{ $hasStockIssue ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <button type="submit" class="btn_checkout shadow-sm" {{ $hasStockIssue ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-lock mr-2"></i> {{ $hasStockIssue ? 'STOKLARI KONTROL EDİN' : 'GÜVENLİ ÖDEMEYİ TAMAMLA' }}
                                    </button>
                                </form>
                            @else
                                {{-- Giriş yapmamış kullanıcı alanı aynı kalabilir --}}
                                <div class="d-flex justify-content-between mb-4" style="font-size: 1.3rem;">
                                    <span class="font-weight-bold text-dark">Genel Toplam:</span>
                                    <span class="font-weight-bold" style="color: #0a2458;">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="alert alert-warning small text-center" style="border-radius: 10px;">
                                    Siparişi tamamlamak için giriş yapmalısınız.
                                </div>
                                <a href="{{ url('/login') }}" class="btn btn-dark w-100 py-3" style="border-radius: 30px; font-weight: bold;">
                                    GİRİŞ YAP / KAYIT OL
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

            @else
                {{-- Boş sepet alanı aynı kalabilir --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-cart-arrow-down fa-4x text-muted" style="opacity: 0.5;"></i>
                    </div>
                    <h4 class="text-muted font-weight-bold">Sepetiniz şu an boş.</h4>
                    <a href="{{ url('/products') }}" class="btn btn-warning px-5 py-2 font-weight-bold" style="border-radius: 30px; color: #0a2458;">
                        ALIŞVERİŞE BAŞLA
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ccInput = document.getElementById('cc_number');
        if (ccInput) {
            ccInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.replace(/(.{4})/g, '$1 ').trim();
                e.target.value = value;
            });
        }
    });
</script>
@endsection
@endsection
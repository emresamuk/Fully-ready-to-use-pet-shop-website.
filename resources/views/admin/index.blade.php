@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="heading_container mb-5">
        <h2 style="color: #0a2458; font-weight: 800;">
            <i class="fa-solid fa-gauge-high mr-2"></i> Admin Kontrol Paneli
            <div style="height: 4px; width: 60px; background: #fdd31d; margin-top: 10px; border-radius: 2px;"></div>
        </h2>
        <p class="text-muted">Hoş geldin, sistemdeki tüm hareketliliği buradan yönetebilirsin.</p>
    </div>

    {{-- İstatistik Özet Kartları --}}
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px; border-left: 5px solid #0a2458;">
                <h6 class="text-muted small font-weight-bold">TOPLAM SİPARİŞ</h6>
                <h3 class="font-weight-bold" style="color: #0a2458;">{{ $stats['orders_count'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px; border-left: 5px solid #fdd31d;">
                <h6 class="text-muted small font-weight-bold">TOPLAM ÜRÜN</h6>
                <h3 class="font-weight-bold" style="color: #0a2458;">{{ $stats['products_count'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px; border-left: 5px solid #27ae60;">
                <h6 class="text-muted small font-weight-bold">KAYITLI MÜŞTERİ</h6>
                <h3 class="font-weight-bold" style="color: #0a2458;">{{ $stats['users_count'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px; border-left: 5px solid #e74c3c;">
                <h6 class="text-muted small font-weight-bold">YENİ MESAJ</h6>
                <h3 class="font-weight-bold" style="color: #0a2458;">{{ $stats['messages_count'] }}</h3>
            </div>
        </div>
    </div>

    {{-- YÖNETİM MENÜSÜ --}}
    <div class="row">
        {{-- Ürün Yönetimi --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 admin-card" style="border-radius: 20px; transition: 0.3s;">
                <div class="card-body text-center py-5">
                    <div class="icon-box mb-3 mx-auto" style="width: 80px; height: 80px; background: #fff4cc; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-boxes-stacked fa-2x" style="color: #f39c12;"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: #0a2458;">Ürün Yönetimi</h5>
                    <p class="text-muted small px-3">Yeni ürün ekle, fiyatları güncelle ve stokları kontrol et.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark px-4" style="border-radius: 20px; font-weight: bold; border-width: 2px;">YÖNET</a>
                </div>
            </div>
        </div>

        {{-- Sipariş Yönetimi --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 admin-card" style="border-radius: 20px; transition: 0.3s;">
                <div class="card-body text-center py-5">
                    <div class="icon-box mb-3 mx-auto" style="width: 80px; height: 80px; background: #e1f5fe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-truck-fast fa-2x" style="color: #0288d1;"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: #0a2458;">Sipariş Yönetimi</h5>
                    <p class="text-muted small px-3">Gelen siparişleri onayla, hazırlık aşamalarını güncelle ve takip et.</p>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark px-4" style="border-radius: 20px; font-weight: bold; border-width: 2px;">YÖNET</a>
                </div>
            </div>
        </div>

        {{-- Kullanıcı Yönetimi --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 admin-card" style="border-radius: 20px; transition: 0.3s;">
                <div class="card-body text-center py-5">
                    <div class="icon-box mb-3 mx-auto" style="width: 80px; height: 80px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-users-gear fa-2x" style="color: #2e7d32;"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: #0a2458;">Kullanıcı Yönetimi</h5>
                    <p class="text-muted small px-3">Müşteri listesini gör, hesap dondur/sil ve bakiyeleri incele.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark px-4" style="border-radius: 20px; font-weight: bold; border-width: 2px;">YÖNET</a>
                </div>
            </div>
        </div>

        {{-- Mesajlar --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 admin-card" style="border-radius: 20px; transition: 0.3s;">
                <div class="card-body text-center py-5">
                    <div class="icon-box mb-3 mx-auto" style="width: 80px; height: 80px; background: #fce4ec; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-envelope-open-text fa-2x" style="color: #d81b60;"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: #0a2458;">Müşteri Mesajları</h5>
                    <p class="text-muted small px-3">İletişim formundan gelen soruları ve önerileri oku.</p>
                    <a href="{{ route('admin.messages') }}" class="btn btn-outline-dark px-4" style="border-radius: 20px; font-weight: bold; border-width: 2px;">YÖNET</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        border-bottom: 5px solid #fdd31d !important;
    }
</style>
@endsection
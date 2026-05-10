@extends('layouts.app')

@section('content')
<section class="about_section layout_padding" style="background-color: #f4f7f6; min-height: 80vh;">
    <div class="container">
        <div class="heading_container mb-4">
            <img src="{{ asset('images/heading-img.png') }}" alt="heading">
            <h2 class="mt-2" style="color: #0a2458; font-weight: 800;">Siparişlerim</h2>
            <p class="text-muted">Vermiş olduğunuz siparişlerin durumunu buradan takip edebilir ve detaylarını inceleyebilirsiniz.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="table-responsive mt-4 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <table class="table table-hover bg-white mb-0">
                <thead style="background-color: #0a2458; color: #fdd31d;">
                    <tr>
                        <th class="py-3 px-4">Sipariş No</th>
                        <th class="py-3">Tarih</th>
                        <th class="py-3">Toplam Tutar</th>
                        <th class="py-3">Mevcut Durum</th>
                        <th class="py-3 text-center">İncele</th> {{-- Yeni Sütun Başlığı --}}
                        <th class="py-3 text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user_orders as $order)
                    <tr>
                        <td class="font-weight-bold px-4 align-middle">#{{ $order->id }}</td>
                        <td class="align-middle text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="align-middle font-weight-bold" style="color: #0a2458;">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-pill py-2 px-3 shadow-sm"
                                style="font-size: 11px; min-width: 120px;
                                @if($order->status == 'iptal_edildi') background-color: #e74c3c; color: white;
                                @elseif($order->status == 'teslim_edildi') background-color: #27ae60; color: white;
                                @elseif($order->status == 'onay_bekliyor') background-color: #f39c12; color: white;
                                @else background-color: #3498db; color: white; @endif">
                                {{ str_replace('_', ' ', strtoupper($order->status)) }}
                            </span>
                        </td>
                        
                        {{-- DETAY BUTONU --}}
                        <td class="align-middle text-center">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info shadow-sm" style="border-radius: 20px; font-weight: 600; padding: 5px 15px; background-color: #0a2458; border: none; color: #fdd31d;">
                                <i class="fa-solid fa-eye mr-1"></i> Detay
                            </a>
                        </td>

                        <td class="align-middle text-center">
                            @if($order->status == 'onay_bekliyor')
                                <form action="{{ url('/order/cancel/'.$order->id) }}" method="POST" onsubmit="return confirm('Siparişi iptal etmek istediğinize emin misiniz? Bakiye iade edilecektir.')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" style="border-radius: 20px; font-weight: 600; padding: 5px 15px;">
                                        <i class="fa-solid fa-xmark mr-1"></i> İptal Et
                                    </button>
                                </form>
                            @elseif($order->status == 'urunleriniz_size_teslim_edilmistir')
                                <form action="{{ url('/order/delivered/'.$order->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success shadow-sm" style="border-radius: 20px; font-weight: 600; padding: 5px 15px; background-color: #27ae60; border:none;">
                                        <i class="fa-solid fa-check mr-1"></i> Teslim Aldım
                                    </button>
                                </form>
                            @elseif($order->status == 'iptal_edildi')
                                <span class="badge badge-outline-danger border border-danger text-danger py-1 px-3" style="border-radius: 20px; font-size: 10px;">
                                    İADE EDİLDİ
                                </span>
                            @elseif($order->status == 'teslim_edildi')
                                <span class="badge badge-outline-success border border-success text-success py-1 px-3" style="border-radius: 20px; font-size: 10px;">
                                    TAMAMLANDI
                                </span>
                            @else
                                <span class="text-info font-weight-bold small italic">
                                    <i class="fa-solid fa-truck-fast fa-fade mr-1"></i> Hazırlanıyor...
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 bg-light">
                            <i class="fa-solid fa-inbox fa-4x" style="color:#dee2e6;"></i>
                            <p class="text-muted font-weight-bold mt-3">Henüz bir siparişiniz bulunmuyor.</p>
                            <a href="{{ url('/products') }}" class="btn btn-warning btn-sm mt-2" style="border-radius: 20px; color: #0a2458; font-weight: bold;">Alışverişe Başla</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
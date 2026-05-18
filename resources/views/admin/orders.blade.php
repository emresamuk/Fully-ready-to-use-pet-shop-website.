@extends('layouts.app')

@section('content')
<section class="about_section layout_padding" style="background-color: #f4f7f6; min-height: 80vh;">
    <div class="container">
        <div class="heading_container mb-4">
            <img src="{{ asset('images/heading-img.png') }}" alt="heading">
            <h2 class="mt-2" style="color: #0a2458; font-weight: 800;">Admin Sipariş Yönetimi</h2>
            <p class="text-muted">Sistemdeki genel durumu ve siparişleri buradan yönetebilirsiniz.</p>
        </div>

        {{-- İstatistikler --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm text-white" style="background-color: #0a2458; border-radius: 15px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 bg-white p-3" style="border-radius: 12px;">
                            <i class="fa-solid fa-cart-shopping fa-2xl" style="color: #0a2458;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 small text-uppercase" style="color: #fdd31d;">Toplam Sipariş</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $totalOrders }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm text-white" style="background-color: #27ae60; border-radius: 15px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box mr-3 bg-white p-3" style="border-radius: 12px;">
                            <i class="fa-solid fa-money-bill-trend-up fa-2xl" style="color: #27ae60;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 small text-uppercase" style="color: #ffffff; opacity: 0.9;">Toplam Kazanç</h6>
                            <h3 class="mb-0 font-weight-bold">${{ number_format($totalEarnings, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bildirimler --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
        @endif

        {{-- Sipariş Tablosu --}}
        <div class="table-responsive shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <table class="table table-hover bg-white mb-0">
                <thead style="background-color: #0a2458; color: #fdd31d;">
                    <tr>
                        <th class="py-3 px-4">Sipariş No</th>
                        <th class="py-3">Müşteri</th>
                        <th class="py-3">Tutar</th>
                        <th class="py-3">Mevcut Durum</th>
                        <th class="py-3 text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="font-weight-bold px-4 align-middle">#{{ $order->id }}</td>
                        <td class="align-middle font-weight-bold">{{ $order->user->name }}</td>
                        <td class="align-middle font-weight-bold" style="color: #0a2458;">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-pill py-2 px-3 
                                @if($order->status == 'iptal_edildi') badge-danger 
                                @elseif($order->status == 'teslim_edildi') badge-success 
                                @elseif($order->status == 'onay_bekliyor') badge-warning
                                @else badge-primary @endif">
                                {{ str_replace('_', ' ', strtoupper($order->status)) }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            @if($order->status == 'iptal_edildi')
                                <span class="text-danger font-weight-bold small"><i class="fa-solid fa-ban mr-1"></i> İPTAL EDİLDİ</span>
                            @elseif($order->status == 'teslim_edildi')
                                <span class="text-success font-weight-bold small"><i class="fa-solid fa-check-double mr-1"></i> TAMAMLANDI</span>
                            @elseif($order->status == 'urunleriniz_size_teslim_edilmistir')
                                <span class="text-info font-weight-bold small"><i class="fa-solid fa-hourglass-half mr-1"></i> MÜŞTERİ ONAYI BEKLENİYOR</span>
                            @else
                                <form action="{{ url('/admin/order/update/'.$order->id) }}" method="POST">
                                    @csrf
                                    <button name="status" value="{{ $order->status == 'onay_bekliyor' ? 'onaylandi' : 'next' }}" 
                                            class="btn btn-sm {{ $order->status == 'onay_bekliyor' ? 'btn-primary' : 'btn-success' }}" 
                                            style="border-radius: 20px; padding: 5px 15px; font-weight: 600;">
                                        <i class="fa-solid {{ $order->status == 'onay_bekliyor' ? 'fa-thumbs-up' : 'fa-angles-right' }} mr-1"></i>
                                        {{ $order->status == 'onay_bekliyor' ? 'Onayla' : 'İlerlet' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5">Sipariş bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
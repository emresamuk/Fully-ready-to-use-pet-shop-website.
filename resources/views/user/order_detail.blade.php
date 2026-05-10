@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0" style="border-radius: 20px;">
        <div class="card-header bg-white py-3" style="border-radius: 20px 20px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 font-weight-bold" style="color: #0a2458;">
                    <i class="fa-solid fa-file-invoice mr-2"></i> Sipariş Detayı #{{ $order->id }}
                </h4>
                <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 20px;">
                    <i class="fa-solid fa-arrow-left"></i> Siparişlerime Dön
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            {{-- Üst Bilgi Alanı --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted mb-1 small text-uppercase font-weight-bold">Teslimat Adresi</p>
                    <p class="font-weight-bold">{{ $order->address }}</p>
                </div>
                <div class="col-md-3">
                    <p class="text-muted mb-1 small text-uppercase font-weight-bold">Sipariş Tarihi</p>
                    <p class="font-weight-bold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <div class="col-md-3">
                    <p class="text-muted mb-1 small text-uppercase font-weight-bold">Durum</p>
                    <span class="badge badge-primary px-3 py-2" style="border-radius: 10px;">
                        {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>

            {{-- Ürün Tablosu --}}
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="bg-light">
                        <tr>
                            <th>Ürün</th>
                            <th class="text-center">Fiyat</th>
                            <th class="text-center">Adet</th>
                            <th class="text-right">Ara Toplam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/' . $item->product->image) }}" width="50" class="mr-3" style="border-radius: 10px;">
                                    <span class="font-weight-bold">{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td class="text-center py-3">${{ number_format($item->price, 2) }}</td>
                            <td class="text-center py-3">{{ $item->quantity }}</td>
                            <td class="text-right py-3 font-weight-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right pt-4 font-weight-bold h5">Genel Toplam:</td>
                            <td class="text-right pt-4 font-weight-bold h5 text-primary">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
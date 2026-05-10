@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #0a2458; font-weight: 800;"><i class="fa-solid fa-boxes-stacked mr-2"></i> Ürün Yönetimi</h2>
        <a href="{{ route('admin.products.create') }}" class="btn shadow-sm" style="background-color: #fdd31d; color: #0a2458; font-weight: bold; border-radius: 30px; padding: 10px 20px;">
            <i class="fa-solid fa-plus mr-1"></i> YENİ ÜRÜN EKLE
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 10px;">
            <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center align-middle">
                <thead style="background-color: #0a2458; color: white;">
                    <tr>
                        <th>Görsel</th>
                        <th>Ürün Adı</th>
                        <th>Fiyat</th>
                        <th>Stok</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td class="font-weight-bold" style="color: #0a2458;">{{ $product->name }}</td>
                            <td style="color: #27ae60; font-weight: bold;">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock > 0)
                                    <span class="badge badge-warning" style="font-size: 14px;">{{ $product->stock }} Adet</span>
                                @else
                                    <span class="badge badge-danger" style="font-size: 14px;">Stok Yok</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success px-3 py-2" style="border-radius: 20px;">Satışta</span>
                                @else
                                    <span class="badge badge-secondary px-3 py-2" style="border-radius: 20px;">Satış Dışı</span>
                                @endif
                            </td>
                            <td>
                                {{-- Satışa Sun / Kaldır Butonu --}}
                                <a href="{{ route('admin.products.toggle', $product->id) }}" class="btn btn-sm btn-{{ $product->is_active ? 'secondary' : 'success' }} mr-1" title="{{ $product->is_active ? 'Satıştan Kaldır' : 'Satışa Sun' }}">
                                    <i class="fa-solid fa-{{ $product->is_active ? 'eye-slash' : 'eye' }}"></i>
                                </a>
                                
                                {{-- Düzenle Butonu --}}
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info mr-1" style="color: white;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                {{-- Sil Butonu --}}
                                <a href="{{ route('admin.products.destroy', $product->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bu ürünü tamamen silmek istediğinize emin misiniz?')" title="Sil">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-muted">Sistemde kayıtlı henüz bir ürün bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
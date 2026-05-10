@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header text-center" style="background-color: #17a2b8; color: white; border-radius: 20px 20px 0 0; padding: 20px;">
                    <h4 class="mb-0 font-weight-bold"><i class="fa-solid fa-pen-to-square mr-2"></i> Ürün Düzenle</h4>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Mevcut Görseli Göster --}}
                        <div class="text-center mb-4">
                            <p class="text-muted small mb-2">Mevcut Görsel:</p>
                            <img src="{{ asset('images/' . $product->image) }}" alt="Mevcut Görsel" style="width: 120px; height: 120px; object-fit: cover; border-radius: 15px; border: 3px solid #eee;">
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Ürün Adı</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Fiyat ($)</label>
                                    <input type="number" name="price" step="0.01" min="0" class="form-control" value="{{ $product->price }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Stok Adeti</label>
                                    <input type="number" name="stock" min="0" class="form-control" value="{{ $product->stock }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Yeni Görsel Yükle (İsteğe Bağlı)</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*" style="padding: 10px; border: 1px dashed #ccc; border-radius: 10px; width: 100%;">
                            <small class="form-text text-muted mt-2">Sadece görseli değiştirmek istiyorsanız yükleyin. Aksi halde boş bırakın.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 py-2" style="border-radius: 30px;"><i class="fa-solid fa-arrow-left mr-2"></i> İptal</a>
                            <button type="submit" class="btn btn-info px-4 py-2" style="color: white; font-weight: bold; border-radius: 30px;">DEĞİŞİKLİKLERİ KAYDET <i class="fa-solid fa-check ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
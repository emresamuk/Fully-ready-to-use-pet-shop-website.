@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header text-center" style="background-color: #0a2458; color: white; border-radius: 20px 20px 0 0; padding: 20px;">
                    <h4 class="mb-0 font-weight-bold"><i class="fa-solid fa-plus-circle mr-2 text-warning"></i> Yeni Ürün Ekle</h4>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Ürün Adı</label>
                            <input type="text" name="name" class="form-control" placeholder="Örn: Premium Kedi Maması" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Fiyat ($)</label>
                                    <input type="number" name="price" step="0.01" min="0" class="form-control" placeholder="Örn: 25.50" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Stok Adeti</label>
                                    <input type="number" name="stock" min="0" class="form-control" placeholder="Örn: 100" required style="border-radius: 10px; padding: 12px; border: 1px solid #ccc;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Ürün Görseli Yükle</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*" required style="padding: 10px; border: 1px dashed #ccc; border-radius: 10px; width: 100%;">
                            <small class="form-text text-muted mt-2">Kabul edilen formatlar: JPG, PNG, WEBP (Max: 2MB)</small>
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 py-2" style="border-radius: 30px;"><i class="fa-solid fa-arrow-left mr-2"></i> İptal ve Geri Dön</a>
                            <button type="submit" class="btn px-4 py-2" style="background-color: #0a2458; color: #fdd31d; font-weight: bold; border-radius: 30px;">ÜRÜNÜ KAYDET <i class="fa-solid fa-save ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
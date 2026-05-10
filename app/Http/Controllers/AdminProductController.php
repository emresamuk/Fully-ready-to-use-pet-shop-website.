<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    // Tüm Ürünleri Listele
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    // Ürün Ekleme Formunu Göster
    public function create()
    {
        return view('admin.products.create');
    }

    // Yeni Ürünü Veritabanına ve Klasöre Kaydet
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->is_active = 1; // Varsayılan olarak satışta

        // Fotoğraf Yükleme İşlemi
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    // Ürün Düzenleme Formunu Göster
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Ürün Bilgilerini Güncelle
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Eğer yeni fotoğraf yüklendiyse
        if ($request->hasFile('image')) {
            // Eski fotoğrafı sunucudan sil
            if (File::exists(public_path('images/' . $product->image))) {
                File::delete(public_path('images/' . $product->image));
            }

            // Yeni fotoğrafı yükle
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Ürün bilgileri güncellendi.');
    }

    // Ürünü ve Fotoğrafını Tamamen Sil
    public function destroy($id)
{
    $product = Product::findOrFail($id);
    
    // Gerçekten silmek yerine pasife çekiyoruz
    $product->is_active = 0;
    $product->save();

    return back()->with('success', 'Ürün başarıyla satıştan kaldırıldı ve arşivlendi.');
}

    // Satışa Sun / Satıştan Kaldır İşlemi
    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'tekrar satışa sunuldu.' : 'satıştan kaldırıldı.';
        return redirect()->back()->with('success', 'Ürün ' . $status);
    }
}
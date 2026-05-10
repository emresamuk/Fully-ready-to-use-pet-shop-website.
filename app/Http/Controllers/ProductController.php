<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Sadece aktif (is_active = 1) olan ürünleri baz alıyoruz
        $query = Product::where('is_active', 1); 

        // 2. İsimle Arama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Kategoriye Göre Filtreleme
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->get();

        // 4. Sadece aktif ürünlerin kategorilerini filtre listesine getiriyoruz
        $categories = Product::where('is_active', 1)
                             ->select('category')
                             ->distinct()
                             ->pluck('category');

        return view('all_products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::where('id', $id)
                          ->where('is_active', 1)
                          ->firstOrFail();

        return view('product_detail', compact('product'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Sepete Ürün Ekle
    public function add($id)
    {
        $product = Product::findOrFail($id);

        // 1. GÜVENLİK KONTROLÜ: Ürün aktif mi?
        if ($product->is_active == 0) {
            return redirect()->back()->with('error', 'Bu ürün artık satışta değildir.');
        }

        // 2. GÜVENLİK KONTROLÜ: Stok var mı?
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Bu ürünün stoğu tükenmiştir.');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Stok limitine ulaştınız.');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect('/cart')->with('success', 'Ürün sepete eklendi!');
    }

    public function increment($id)
    {
        $product = Product::findOrFail($id);
        
        // Ürün pasifse artırma yapma
        if ($product->is_active == 0) {
            return redirect()->back()->with('error', 'Bu ürün artık satışta olmadığı için işlem yapılamaz.');
        }

        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Maksimum stok miktarına ulaştınız.');
            }
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }
        return redirect('/cart');
    }

    public function decrement($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect('/cart');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect('/cart')->with('success', 'Ürün sepetten çıkarıldı!');
        }
    }

    // Ödeme Yap ve Siparişi Tamamla
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) return redirect('/cart')->with('error', 'Sepetiniz boş!');

        $total = 0;
        foreach($cart as $id => $item) {
            $product = Product::find($id);
            
            // 3. GÜVENLİK KONTROLÜ: Ödeme anında ürünün aktifliği ve stoğu hala uygun mu?
            if (!$product || $product->is_active == 0) {
                return redirect('/cart')->with('error', ($item['name'] ?? 'Bir ürün') . ' artık satışta değil. Lütfen sepetinizden çıkarın.');
            }

            if ($product->stock < $item['quantity']) {
                return redirect('/cart')->with('error', $product->name . ' için yeterli stok kalmadı.');
            }

            $total += $item['price'] * $item['quantity'];
        }

        $user = auth()->user();

        if ($user->balance > 0) {
            if ($user->balance >= $total) {
                $user->balance -= $total;
            } else {
                $user->balance = 0;
            }
            $user->save();
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'onay_bekliyor',
                'address' => $user->address ?? 'Adres belirtilmemiş'
            ]);

            foreach($cart as $id => $item) {
                $product = Product::find($id);
                $product->decrement('stock', $item['quantity']);

                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect('/my-orders')->with('success', 'Ödemeniz onaylandı, stoklar güncellendi ve siparişiniz alındı.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/cart')->with('error', 'Sipariş sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
}
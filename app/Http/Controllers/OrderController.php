<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function myOrders()
    {
        $user_orders = Order::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('user.orders', compact('user_orders'));
    }


    public function show($id)
    {
        $order = Order::with('items.product')
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('user.order_detail', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status == 'onay_bekliyor') {
            $user = Auth::user();
            $user->balance += $order->total_amount;
            $user->save();

            // Stok İadesi: order_items tablosuna bakarak stokları artırıyoruz
            $items = DB::table('order_items')->where('order_id', $order->id)->get();
            foreach ($items as $item) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }

            $order->status = 'iptal_edildi';
            $order->save();

            return back()->with('success', 'Sipariş iptal edildi. Ücret iade edildi ve stoklar güncellendi.');
        }

        return back()->with('error', 'Bu sipariş artık iptal edilemez.');
    }

    public function delivered($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status == 'urunleriniz_size_teslim_edilmistir') {
            $order->status = 'teslim_edildi';
            $order->save();
            return back()->with('success', 'Sipariş tamamlandı. Keyifli kullanımlar!');
        }

        return back()->with('error', 'Bu işlem şu an yapılamaz.');
    }
}
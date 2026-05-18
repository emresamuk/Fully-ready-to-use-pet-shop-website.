<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Message; 
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin ana sayfası
    public function dashboard()
    {
        // Ana sayfadaki kartlardaki genel şeyler
        $stats = [
            'orders_count'   => Order::count(),
            'total_earnings' => Order::where('status', '!=', 'iptal_edildi')->sum('total_amount'), // mevcut kazanç
            'products_count' => Product::count(),
            'users_count'    => User::where('role', 'user')->count(),
            'messages_count' => Message::count(),
        ];

        return view('admin.index', compact('stats'));
    }

    // Siparişler 
    public function index()
    {
        // Toplam Sipariş Sayısı
        $totalOrders = Order::count(); 
        
        // Toplam Kazanç
        $totalEarnings = Order::where('status', '!=', 'iptal_edildi')->sum('total_amount');
        
        // Bekleyen Mesaj Sayısı
        $pendingMessages = Message::count();

        // Siparişleri listele
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.orders', compact('orders', 'totalOrders', 'totalEarnings', 'pendingMessages'));
    }

    // Sipariş durumunu güncelleme
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status == 'iptal_edildi') {
            return back()->with('error', 'İptal edilmiş bir siparişin durumu değiştirilemez!');
        }
        
        if ($order->status == 'teslim_edildi') {
            return back()->with('error', 'Tamamlanmış bir siparişin durumu değiştirilemez!');
        }

        $statuses = [
            'onay_bekliyor', // Başlangıç durumu
            'onaylandi', 
            'urunleriniz_tedarik_ediliyor', 
            'urunleriniz_kutulaniyor', 
            'urunleriniz_kargoya_veriliyor', 
            'urunleriniz_size_dogru_yola_cikti', 
            'urunleriniz_size_teslim_edilmistir'
        ];

        if ($request->status == 'next') {
            $currentIndex = array_search($order->status, $statuses);
            
            // Eğer mevcut durum dizide bulunuyorsa ve bir sonraki aşama varsa ilerlet
            if ($currentIndex !== false && isset($statuses[$currentIndex + 1])) {
                $order->status = $statuses[$currentIndex + 1];
            } else {
                return back()->with('info', 'Sipariş zaten son aşamada veya durumu manuel olarak değiştirilmiş.');
            }
        } else {
            $order->status = $request->status;
        }

        $order->save();
        return back()->with('success', 'Sipariş durumu başarıyla güncellendi.');
    }

    // Kullanıcı yönetimi
    public function manageUsers()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    // Mesaj yönetimi
    public function manageMessages()
    {
        // En yeni mesajlar en üstte gelecek şekilde tüm mesajları listele
        $messages = Message::orderBy('created_at', 'desc')->get();

        return view('admin.messages', compact('messages'));
    }

    // Mesaj silme
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return back()->with('success', 'Mesaj başarıyla silindi.');
    }
}
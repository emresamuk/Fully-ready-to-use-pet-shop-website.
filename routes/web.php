<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController; 

// Genel Sayfalar
Route::get('/', function () {
    $products = Product::where('is_active', 1)->take(3)->get(); 
    return view('index', compact('products'));
});

Route::get('/about', function () { return view('about'); });

// Ürün Listeleme (Arama ve Filtreleme için Controller'a yönlendirdik)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

// İletişim Formu
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');


// Kimlik Doğrulama

// Giriş & Çıkış
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Kayıt
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Şifre Sıfırlama
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');


// Sadece Giriş Yapmış Kullanıcılar
Route::middleware(['auth'])->group(function () {
    
    // Profil ve Bakiye
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/add-balance', [ProfileController::class, 'addBalance']);
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

    // Sepet İşlemleri
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [CartController::class, 'add']);
    Route::post('/remove-from-cart', [CartController::class, 'remove']);
    Route::post('/cart/increment/{id}', [CartController::class, 'increment']);
    Route::post('/cart/decrement/{id}', [CartController::class, 'decrement']);
    Route::post('/checkout', [CartController::class, 'checkout']);

    // Kullanıcı Sipariş Yönetimi
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('order.show'); // YENİ EKLENDİ (DETAY SAYFASI)
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancel']);
    Route::post('/order/delivered/{id}', [OrderController::class, 'delivered']);

    // Admin Paneli İşlemleri
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Siparişler
        Route::get('/orders', [AdminController::class, 'index'])->name('admin.orders');
        Route::post('/order/update/{id}', [AdminController::class, 'updateStatus']);
        
        // Mesajlar
        Route::get('/messages', [AdminController::class, 'manageMessages'])->name('admin.messages');
        Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])->name('admin.messages.delete');

        // Admin Ürün Yönetimi
        Route::get('/products', [App\Http\Controllers\AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [App\Http\Controllers\AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [App\Http\Controllers\AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/products/{id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('admin.products.update');
        Route::get('/products/{id}/delete', [App\Http\Controllers\AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/products/{id}/toggle', [App\Http\Controllers\AdminProductController::class, 'toggleActive'])->name('admin.products.toggle');

        // Admin Kullanıcı Yönetimi
        Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{id}/toggle-freeze', [App\Http\Controllers\AdminUserController::class, 'toggleFreeze'])->name('admin.users.toggle-freeze');
        Route::get('/users/{id}/delete', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
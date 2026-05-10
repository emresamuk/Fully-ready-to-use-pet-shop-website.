<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Sipariş bağlantısı (orders tablosundaki id)
            $table->unsignedBigInteger('order_id');
            // Ürün bağlantısı (products tablosundaki id)
            $table->unsignedBigInteger('product_id');
            
            $table->integer('quantity'); // Kaç adet alındı?
            $table->decimal('price', 10, 2); // Satın alındığı andaki birim fiyatı
            
            $table->timestamps();

            // İlişkiler: Sipariş silinirse detayları da silinsin (opsiyonel)
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // Ürün silinirse hata vermesin diye genelde product_id'ye cascade verilmez
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
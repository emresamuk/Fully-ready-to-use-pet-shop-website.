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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siparişi veren kullanıcı
        $table->decimal('total_amount', 10, 2); // Toplam tutar
        $table->string('status')->default('onay_bekliyor'); // Sipariş durumu
        $table->text('address'); // Teslimat adresi
        $table->timestamps(); // created_at ve updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAndProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Kullanıcılar tablosuna adres ve dondurma durumu ekliyoruz
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('email');
            $table->boolean('is_frozen')->default(0)->after('role'); // 0: Aktif, 1: Dondurulmuş
        });

        // Ürünler tablosuna satışta/satış dışı durumu ekliyoruz
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(1)->after('stock'); // 1: Satışta, 0: Satıştan Kaldırıldı
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'is_frozen']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
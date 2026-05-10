<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Hata veren kısmı bu satırla çözüyoruz:
    // Bu dizi içindeki sütunlar veritabanına toplu olarak yazılabilir hale gelir.
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'address',
    ];

    /**
     * Siparişin kime ait olduğunu belirtir (İlişki)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
{
    // Bir siparişin birden fazla kalemi (item) olur
    return $this->hasMany(\App\Models\OrderItem::class, 'order_id');
}
}
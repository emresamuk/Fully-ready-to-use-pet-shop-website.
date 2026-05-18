<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Hangi sütunların toplu olarak kaydedilebileceğini belirtiyoruz
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Bu sipariş kalemi hangi ürüne ait?
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * işlem hangi siparişe ait?
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
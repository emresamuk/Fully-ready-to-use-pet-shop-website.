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
     * Bu ilişki sayesinde $item->product->name diyerek ürün ismine ulaşabilirsin.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Bu kalem hangi siparişe ait?
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
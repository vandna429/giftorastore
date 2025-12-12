<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items'; // your table name

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relationship: belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship: belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

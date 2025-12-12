<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
         'user_id',
        'name',
        'phone',
        'email',
        'address',
        'total_price',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'total_price' => 'decimal:2',
    ];

    // Relationship: Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_price', 'shipping_address',
        'phone', 'recipient_name', 'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

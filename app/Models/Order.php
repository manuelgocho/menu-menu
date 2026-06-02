<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'total_usd',
        'total_bs',
        'status',
        'notes',
        'whatsapp_message',
    ];

    protected $casts = [
        'total_usd' => 'float',
        'total_bs' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'note', 'subtotal')
            ->withTimestamps();
    }
}

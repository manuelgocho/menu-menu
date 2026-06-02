<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_usd',
        'price_bs',
        'category',
        'image_url',
        'is_active',
    ];

    protected $casts = [
        'price_usd' => 'float',
        'price_bs' => 'float',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'note', 'subtotal')
            ->withTimestamps();
    }
}

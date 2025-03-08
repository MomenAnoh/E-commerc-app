<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }
    public function cart()
    {
        return $this->belongsToMany(Cart::class,'cart_products', 'cart_id','product_id')->withPivot('quantity');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }
}

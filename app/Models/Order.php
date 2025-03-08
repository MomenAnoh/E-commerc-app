<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id'
    ];
    public function users()
    {
        $this->belongsTo('User');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity', 'price');
    }
    public function orderProducts()
    {
        return $this->hasMany(Order_product::class, 'order_id');
    }
}

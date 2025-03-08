<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['zone_id', 'area_id', 'user_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

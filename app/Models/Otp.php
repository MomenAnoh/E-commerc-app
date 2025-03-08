<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'code',
        'expire_at',
        'user_id',
      ];
    public function users()
    {
        $this->belongsTo('User');
    }
}

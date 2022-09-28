<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShopingFriend extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','friend_id','request_id'];

    public function user_()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class,'friend_id','id');
    }

    public function request()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
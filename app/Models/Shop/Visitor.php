<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Shop;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','time','user_id','device_id'];

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }
}

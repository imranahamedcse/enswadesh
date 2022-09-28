<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'region',
        'city',
        'area',
        'address',
        'bio',
        'dob',
        'blood_group',
        'social_link',
        'image',
        'user_type','nid',
        'passport_id',
        'driving_license'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
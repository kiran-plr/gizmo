<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayoutMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'type',
        'name',
        'description',
        'external_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPayouts()
    {
        return $this->hasMany(UserPayout::class);
    }
}

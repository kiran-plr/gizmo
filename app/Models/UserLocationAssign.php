<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocationAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

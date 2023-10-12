<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions');
    }

    public static function getUserPermissionsForAssign()
    {
        return Permission::whereIn('slug', AppHelper::USERPERMISSIONS)->pluck('id');
    }

    public static function getVendorPermissionsForAssign()
    {
        return Permission::whereIn('slug', AppHelper::VENDORPERMISSIONS)->pluck('id');
    }
}

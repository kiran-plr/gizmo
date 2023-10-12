<?php

namespace Database\Seeders;

use App\Helpers\AppHelper;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermission = Permission::getUserPermissionsForAssign();
        $vendorPermission = Permission::whereIn('slug', AppHelper::VENDORPERMISSIONS)->pluck('id');
        $userPermission = Permission::whereIn('slug', AppHelper::USERPERMISSIONS)->pluck('id');
        User::findOrFail(1)->permissions()->attach($adminPermission);
        User::findOrFail(2)->permissions()->attach($vendorPermission);
        User::findOrFail(3)->permissions()->attach($userPermission);
    }
}

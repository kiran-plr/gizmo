<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'      =>      'Dashboard Access',
                'slug'      =>      'dashboard_access',
            ],
            [
                'name'      =>      'User Access',
                'slug'      =>      'user_access',
            ],
        ];

        Permission::insert($permissions);
    }
}

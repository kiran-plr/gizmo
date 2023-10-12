<?php

namespace Database\Seeders;

use App\Helpers\AppHelper;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            AppHelper::ADMIN,
            AppHelper::VENDOR,
            AppHelper::USER,
        ];

        Role::insert($roles);
    }
}

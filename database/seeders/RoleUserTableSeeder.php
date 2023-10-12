<?php

namespace Database\Seeders;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::findOrFail(1)->roles()->sync(AppHelper::ADMIN['id']);
        User::findOrFail(2)->roles()->sync(AppHelper::VENDOR['id']);
        User::findOrFail(3)->roles()->sync(AppHelper::USER['id']);
    }
}

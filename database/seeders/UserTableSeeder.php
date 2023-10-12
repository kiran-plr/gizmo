<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\User');
        $user = [
            [
                'name' => 'Barry Adminsky',
                'email' => 'admin@dev-team.net',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'password' => bcrypt('uDMjdv2P'),
                'email_verified_at' => \Carbon\Carbon::now(),
                'remember_token' => \Str::random(10),
                'active' => '1',
            ],
            [
                'name' => 'Stephen Vendorsky',
                'email' => 'vendor@dev-team.net',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'password' => bcrypt('tF55mKe2'),
                'email_verified_at' => \Carbon\Carbon::now(),
                'remember_token' => \Str::random(10),
                'active' => '1',
            ],
            [
                'name' => 'Cory Usersky',
                'email' => 'user@dev-team.net',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'password' => bcrypt('sDBeE33t'),
                'email_verified_at' => \Carbon\Carbon::now(),
                'remember_token' => \Str::random(10),
                'active' => '1',
            ]
        ];

        User::insert($user);
    }
}

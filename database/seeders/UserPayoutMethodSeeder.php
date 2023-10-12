<?php

namespace Database\Seeders;

use App\Models\UserPayoutMethod;
use Illuminate\Database\Seeder;

class UserPayoutMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userPayoutMethods = [
            [
                'type' => 'paypal',
                'name' => 'PayPal',
                'description' => 'PayPal',
            ],
            [
                'type' => 'digital_payment',
                'name' => 'Digital Payment',
                'description' => 'Digital Payment',
            ],
            [
                'type' => 'check',
                'name' => 'Check',
                'description' => 'Check',
            ],
        ];

        // UserPayoutMethod::insert($userPayoutMethods);
    }
}

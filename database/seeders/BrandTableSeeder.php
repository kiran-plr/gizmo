<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
            ],
            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
            ]
        ];

        \App\Models\Brand::insert($Brands);
    }
}

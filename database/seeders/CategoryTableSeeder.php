<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Phones',
                'slug' => 'phones',
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
            ],
            [
                'name' => 'Computers',
                'slug' => 'computers',
            ],

        ];

        \App\Models\Category::insert($categories);
    }
}

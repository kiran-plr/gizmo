<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributeFamily = [
            [
                'name' => 'Phone',
                'slug' => 'phone'
            ],
            [
                'name' => 'Buyback',
                'slug' => 'buyback'
            ]
        ];

        \App\Models\AttributeFamily::insert($attributeFamily);
    }
}

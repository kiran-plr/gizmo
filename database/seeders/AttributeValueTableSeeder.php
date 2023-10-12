<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AttributeValues = [
            [
                'attribute_id' => 1,
                'value' => '64 GB',
                'slug' => '64-gb',
            ],
            [
                'attribute_id' => 1,
                'value' => '128 GB',
                'slug' => '128-gb',
            ],
            [
                'attribute_id' => 1,
                'value' => '256 GB',
                'slug' => '256-gb',
            ],
            [
                'attribute_id' => 2,
                'value' => 'New',
                'slug' => 'new',
            ],
            [
                'attribute_id' => 2,
                'value' => 'Good',
                'slug' => 'good',
            ],
            [
                'attribute_id' => 2,
                'value' => 'Fair',
                'slug' => 'fair',
            ],
            [
                'attribute_id' => 3,
                'value' => 'AT&T',
                'slug' => 'att',
            ],
            [
                'attribute_id' => 3,
                'value' => 'Sprint',
                'slug' => 'sprint',
            ],
            [
                'attribute_id' => 3,
                'value' => 'T-Mobile',
                'slug' => 't-mobile',
            ],

            // Second Attribute Family Attribute Value
            [
                'attribute_id' => 4,
                'value' => '64GB',
                'slug' => '64gb',
            ],
            [
                'attribute_id' => 4,
                'value' => '128GB',
                'slug' => '128gb',
            ],
            [
                'attribute_id' => 4,
                'value' => '256GB',
                'slug' => '256gb',
            ],
            [
                'attribute_id' => 5,
                'value' => 'Excellent',
                'slug' => 'excellent',
            ],
            [
                'attribute_id' => 5,
                'value' => 'Good',
                'slug' => 'good',
            ],
            [
                'attribute_id' => 5,
                'value' => 'Broken',
                'slug' => 'broken',
            ],
            [
                'attribute_id' => 6,
                'value' => 'AT&T',
                'slug' => 'att',
            ],
            [
                'attribute_id' => 6,
                'value' => 'Sprint',
                'slug' => 'sprint',
            ],
            [
                'attribute_id' => 6,
                'value' => 'T-Mobile',
                'slug' => 't-mobile',
            ],
        ];

        \App\Models\AttributeValue::insert($AttributeValues);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Attributes = [
            [
                'name' => 'Storage',
                'slug' => 'storage',
                'attribute_family_id' => 1,
                'attribute_question' => 'How much storage does your device have?',
                'description' => null,
            ],
            [
                'name' => 'Condition',
                'slug' => 'condition',
                'attribute_family_id' => 1,
                'attribute_question' => 'Is it in good Working Condition?',
                'description' => '<ul>
                                        <li>It powers on and off</li>
                                        <li>All buttons work</li>
                                        <li>All cameras work</li>
                                        <li>Battery has at least 80% health</li>
                                    </ul>',
            ],
            [
                'name' => 'Carrier',
                'slug' => 'carrier',
                'attribute_family_id' => 1,
                'attribute_question' => 'What carrier are you with?',
                'description' => null,
            ],
            [
                'name' => 'Storage',
                'slug' => 'storage',
                'attribute_family_id' => 2,
                'attribute_question' => 'How much storage does your device have?',
                'description' => null,
            ],
            [
                'name' => 'Condition',
                'slug' => 'condition',
                'attribute_family_id' => 2,
                'attribute_question' => 'Is it in good Working Condition?',
                'description' => '<ul>
                                        <li>It powers on and off</li>
                                        <li>All buttons work</li>
                                        <li>All cameras work</li>
                                        <li>Battery has at least 80% health</li>
                                    </ul>',
            ],
            [
                'name' => 'Carrier',
                'slug' => 'carrier',
                'attribute_family_id' => 2,
                'attribute_question' => 'What carrier are you with?',
                'description' => null,
            ],
        ];

        \App\Models\Attribute::insert($Attributes);
    }
}

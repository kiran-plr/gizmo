<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(PermissionUserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(AttributeFamilySeeder::class);
        // $this->call(ProductTableSeeder::class);
        $this->call(AttributeTableSeeder::class);
        $this->call(AttributeValueTableSeeder::class);
        // $this->call(ProductAttributesTableSeeder::class);
        $this->call(UserPayoutMethodSeeder::class);
    }
}

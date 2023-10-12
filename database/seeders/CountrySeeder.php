<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = [
            [
                'name' => 'United States',
                'iso2' => 'US',
                'iso3' => 'USA',
                'phone_code' => '+1',
                'currency' => 'Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'USD',
                'flag' => 'us.png',
            ],
            [
                'name' => 'Canada',
                'iso2' => 'CA',
                'iso3' => 'CAN',
                'phone_code' => '+1',
                'currency' => 'Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'USD',
                'flag' => 'cn.png',
            ],
            [
                'name' => 'United Kingdom',
                'iso2' => 'GB',
                'iso3' => 'GBR',
                'phone_code' => '+44',
                'currency' => 'Pound',
                'currency_symbol' => '£',
                'currency_code' => 'GBP',
                'flag' => 'gb.png',
            ],
            [
                'name' => 'Australia',
                'iso2' => 'AU',
                'iso3' => 'AUS',
                'phone_code' => '+61',
                'currency' => 'Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'AUD',
                'flag' => 'au.png',
            ],
            [
                'name' => 'New Zealand',
                'iso2' => 'NZ',
                'iso3' => 'NZL',
                'phone_code' => '+64',
                'currency' => 'Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'NZD',
                'flag' => 'nz.png',
            ],
            [
                'name' => 'India',
                'iso2' => 'IN',
                'iso3' => 'IND',
                'phone_code' => '+91',
                'currency' => 'Rupee',
                'currency_symbol' => '₹',
                'currency_code' => 'INR',
                'flag' => 'in.png',
            ],
        ];

        \App\Models\Country::insert($countries);
    }
}

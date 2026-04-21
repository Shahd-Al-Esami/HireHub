<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Country::create([
            'name' => 'Syria',
            'code' => 'SY',
            'phone_code' => '+963',
        ]);

        Country::create([
            'name' => 'Netherlands',
            'code' => 'NL',
            'phone_code' => '+31',
        ]);
    }
    }


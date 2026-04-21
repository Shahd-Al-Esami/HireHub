<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $syria = Country::where('code', 'SY')->firstOrFail();
        $nl = Country::where('code', 'NL')->firstOrFail();

        City::create(['name' => 'Damascus', 'country_id' => $syria->id]);
        City::create(['name' => 'Aleppo', 'country_id' => $syria->id]);
        City::create(['name' => 'Amsterdam', 'country_id' => $nl->id]);
    }
}

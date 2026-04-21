<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AttachmentSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\OfferSeeder;
use Database\Seeders\ProfileSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\SkillSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    $this->call([
        CountrySeeder::class,
        CitySeeder::class,
        UserSeeder::class,
        ProfileSeeder::class,
        SkillSeeder::class,
        ProjectSeeder::class,
        TagSeeder::class,
        OfferSeeder::class,
        ReviewSeeder::class,
        AttachmentSeeder::class,
    ]);
}
}

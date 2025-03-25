<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\CityFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create();

        // UserFactory::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        

        $airline = Airline::factory()
            ->hasAttached(
                City::factory()
                ->count(3)
            )
            ->create();

        
    }
}

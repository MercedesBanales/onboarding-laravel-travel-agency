<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Database\Factories\FlightFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create();
        CityFactory::new()->count(10)->create();

        AirlineFactory::new()->count(10)->create();

        FlightFactory::new()
            ->count(20)
            ->state(function(){
                $airline = Airline::inRandomOrder()->first();
                $enabled_cities = $airline->enabled_cities;
                $departure_city = $enabled_cities->random(); 
                $arrival_city = $enabled_cities->reject(fn ($city) => $city->id == $departure_city->id)->random();

                $departure_date = Carbon::now($departure_city->timezone)
                    ->addDays(rand(1, 365))
                    ->setTime(rand(0, 23), rand(0, 59));

                $arrival_date = $departure_date
                    ->copy()
                    ->addHours(rand(1, 12))
                    ->setTimezone($arrival_city->timezone);

                return [
                    'airline_id'=> $airline->id,
                    'departure_city_id' => $departure_city->id,
                    'arrival_city_id' => $arrival_city->id,
                    'departure_date' => $departure_date,
                    'arrival_date' => $arrival_date
                ];
            })
            ->create();
    }    
}

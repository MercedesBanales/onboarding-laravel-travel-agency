<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
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
                $airline = Airline::inRandomOrder()->firstOrFail();
                $enabledCities = $airline->enabledCities;
                $departureCity = $enabledCities->random(); 
                $arrivalCity = $enabledCities->reject(fn ($city) => $city->id == $departureCity->id)->random();

                $departureDate = CarbonImmutable::now($departureCity->timezone)
                    ->addDays(rand(1, 365))
                    ->setTime(rand(0, 23), rand(0, 59));

                $arrivalDate = $departureDate->addHours(rand(1, 12));

                $arrivalDate->setTimezone($arrivalCity->timezone);

                return [
                    'airline_id'=> $airline->id,
                    'departure_city_id' => $departureCity->id,
                    'arrival_city_id' => $arrivalCity->id,
                    'departure_date' => $departureDate,
                    'arrival_date' => $arrivalDate
                ];
            })
            ->create();
    }    
}

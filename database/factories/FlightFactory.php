<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

/**
 * @extends Factory<\Lightit\Shared\App\Flight>
 */
class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        return [];
    }

    
}

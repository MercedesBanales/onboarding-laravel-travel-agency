<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

/**
 * @extends Factory<\Lightit\Backoffice\Flights\Domain\Models\Flight>
 */
class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        return [];
    }

    
}

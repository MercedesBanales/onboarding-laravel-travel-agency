<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;

/**
 * @extends Factory<\Lightit\Shared\App\Airline>
 */
class AirlineFactory extends Factory
{
    protected $model = Airline::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Airlines',
        ];
    }
}

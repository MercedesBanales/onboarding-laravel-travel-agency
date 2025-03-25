<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;

/**
 * @extends Factory<\Lightit\Backoffice\Airlines\Domain\Models\Airline>
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

    public function configure(): self
    {
        return $this->afterCreating(function (Airline $airline) {
            $enabledCities = City::inRandomOrder()->take(3)->pluck('id');
            $airline->enabled_cities()->attach($enabledCities);
        });
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class ValidateActiveFlightsRule implements DataAwareRule, ValidationRule
{
    public const ERROR_MESSAGE = "The airline's current flights are not enabled by the updated cities";

    public const ENABLED_CITIES_IDS = 'enabled_cities_ids';

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    public function __construct(private readonly Airline $airline)
    {
    }
 
    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * @param Closure(string): PotentiallyTranslatedString $fail
     * @param array<int>                                   $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flights = $this->airline->flights;

        foreach ($flights as $flight) {
            /**
             * @var City $arrival_city
             */
            $arrival_city = City::findOrFail($flight->arrival_city_id);
            $arrival_date = $arrival_city->dateToTimezone($flight->arrival_date);
            if ($this->flightIsActive($arrival_date) && ! $this->flightIsEnabledByAirline($flight, $value)) {
                $fail(self::ERROR_MESSAGE);
            }
        }
    }

    private function flightIsActive(Carbon $arrival_date): bool
    {
        return $arrival_date->greaterThan(now());
    }

    /**
     * @param array<int> $value
     */
    private function flightIsEnabledByAirline(Flight $flight, array $value): bool
    {
        return in_array($flight->departure_city_id, $value)
            || in_array($flight->arrival_city_id, $value);
    }
}

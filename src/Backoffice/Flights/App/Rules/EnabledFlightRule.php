<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class EnabledFlightRule implements DataAwareRule, ValidationRule
{
    public const ERROR_MESSAGE = "The flight's departure and arrival city must be enabled by the airline";

    public const AIRLINE_ID = 'airline_id';

    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    public function __construct(private readonly Flight|null $flight = null)
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
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->flightEnabledByAirline()) {
            $fail(self::ERROR_MESSAGE);
        }
    }

    private function flightEnabledByAirline(): bool
    {
        $airline_id = $this->data[self::AIRLINE_ID] ?? null;
        
        /**
         * @var Airline $airline
         */
        $airline = $airline_id ? Airline::findOrFail($airline_id) : $this->flight?->airline;
        $enabled_cities = $airline->enabled_cities->pluck('id');
        
        $departure_city_id = $this->data[self::DEPARTURE_CITY_ID] ?? null;
        $arrival_city_id = $this->data[self::ARRIVAL_CITY_ID] ?? null;

        return ($departure_city_id && $enabled_cities->contains($departure_city_id))
        && ($arrival_city_id && $enabled_cities->contains($arrival_city_id));
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class DifferentCityRule implements DataAwareRule, ValidationRule
{
    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const ERROR_MESSAGE = "The flight's departure and arrival city must be different";

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];
 
    public function __construct(private Flight $flight) {

    }
 
    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (($this->data[self::DEPARTURE_CITY_ID] ?? null) && $value == $this->flight->arrival_city_id
            || ($this->data[self::ARRIVAL_CITY_ID] ?? null) && $value == $this->flight->departure_city_id) {
                $fail(self::ERROR_MESSAGE);
        }
    }



}

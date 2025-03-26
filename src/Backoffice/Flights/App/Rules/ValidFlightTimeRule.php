<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;
use Illuminate\Translation\PotentiallyTranslatedString;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class ValidFlightTimeRule implements DataAwareRule, ValidationRule
{
    public const ERROR_MESSAGE = 'The arrival date and time cannot be before the departure date and time';

    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const DEPARTURE_DATE = 'departure_date';

    public const ARRIVAL_DATE = 'arrival_date';

    /**
    * All of the data under validation.
    *
     * @var array<string, mixed>
    */
    protected array $data = [];

    public function __construct(private readonly ?Flight $flight = null)
    {
    }

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
        if (!$this->checkValidFlightTimes()) {
            $fail(self::ERROR_MESSAGE);
        }
    }

    private function checkValidFlightTimes(): bool
    {
        if (!$this->flight) return false;

        /**
         * @var ?int $departure_city_id
         */
        $departure_city_id = $this->data[self::DEPARTURE_CITY_ID] ?? null;
        /**
         * @var ?int $arrival_city_id
         */
        $arrival_city_id = $this->data[self::ARRIVAL_CITY_ID] ?? null;

        $departure_city = $this->findCity($departure_city_id) ?? $this->flight->departure_city;
        $arrival_city = $this->findCity($arrival_city_id) ?? $this->flight->arrival_city;

        if (!$departure_city || !$arrival_city) return false;

        /**
         * @var string $departure_date
         */
        $departure_date = $this->data[self::DEPARTURE_DATE] ?? $this->flight->departure_date;
        
        /**
         * @var string $arrival_date
         */
        $arrival_date = $this->data[self::ARRIVAL_DATE] ?? $this->flight->arrival_date;

        $departure_date_to_tz = $this->formatDate($departure_date, $departure_city->timezone);
        $arrival_date_to_tz = $this->formatDate($arrival_date, $arrival_city->timezone);

        return $departure_date_to_tz->lessThan($arrival_date_to_tz);
    }

    
    private function findCity(?int $id): ?City
    {
        return City::find($id) ?? null;
    }

    private function formatDate(string $date, string $timezone) : Carbon
    {
        return Carbon::parse($date)->setTimezone($timezone);
    }
}

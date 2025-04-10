<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class UpdateFlightRequest extends FormRequest
{
    public const AIRLINE_ID = 'airline_id';

    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const DEPARTURE_DATE = 'departure_date';

    public const ARRIVAL_DATE = 'arrival_date';

    public const DATE_FORMAT = 'd-m-Y H:i:s';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['bail', Rule::exists(Airline::class, 'id')],
            self::DEPARTURE_CITY_ID => [
                            'bail',
                            Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => [
                            'bail',
                            Rule::exists(City::class, 'id')],
            self::DEPARTURE_DATE => ['bail', Rule::date()->format(self::DATE_FORMAT)],
            self::ARRIVAL_DATE => ['bail', Rule::date()->format(self::DATE_FORMAT)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                /**
                 * @var Flight $flight
                 */
                $flight = $this->route('flight');

                if ($this->sameOriginAndDestination($flight)) {
                    $this->setError(
                        $validator,
                        'arrival_city_id',
                        'The origin and destination cities must be different.'
                    );
                }

                if (! $this->airlineEnablesFlightCities($flight)) {
                    $this->setError(
                        $validator,
                        'airline_id',
                        "The flight's departure and arrival city must be enabled by the airline."
                    );
                }

                if (! $this->validFlightDateTimes($flight)) {
                    $this->setError(
                        $validator,
                        'arrival_date',
                        'The arrival date and time cannot be before the departure date and time.'
                    );
                }
            },
        ];
    }

    private function sameOriginAndDestination(Flight $flight): bool
    {
        $arrivalCityId = $this->input(self::ARRIVAL_CITY_ID) ?? $flight->arrival_city_id;
        $departureCityId = $this->input(self::DEPARTURE_CITY_ID) ?? $flight->departure_city_id;

        return $arrivalCityId == $departureCityId;
    }

    private function airlineEnablesFlightCities(Flight $flight): bool
    {
        $enabledCities = $flight->airline->enabledCities->pluck('id');
        
        $departureCityId = $this->input(self::DEPARTURE_CITY_ID) ?? null;
        $arrivalCityId = $this->input(self::ARRIVAL_CITY_ID) ?? null;

        return ($departureCityId && $enabledCities->contains($departureCityId))
        || ($arrivalCityId && $enabledCities->contains($arrivalCityId));
    }

    private function validFlightDateTimes(Flight $flight): bool
    {
        $departureCityId = $this->input(self::DEPARTURE_CITY_ID);
        $arrivalCityId = $this->input(self::ARRIVAL_CITY_ID);
        $departureDate = $this->string(self::DEPARTURE_DATE)->toString();
        $arrivalDate = $this->string(self::ARRIVAL_DATE)->toString();

        $departureCity = City::query()->find($departureCityId) ?? $flight->departureCity;
        $arrivalCity = City::query()->find($arrivalCityId) ?? $flight->arrivalCity;

        $departureDateToTz = $departureCity->dateToTimezone(
            $departureDate != '' ? $departureDate : $flight->departure_date->toDateTimeString()
        );
        $arrivalDateToTz = $arrivalCity->dateToTimezone(
            $arrivalDate != '' ? $arrivalDate : $flight->arrival_date->toDateTimeString()
        );

        return $departureDateToTz->lessThan($arrivalDateToTz);
    }

    private function setError(Validator $validator, string $field, string $errorMessage): void
    {
        $validator->errors()->add(
            $field,
            $errorMessage
        );
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            airlineId: $this->integer(self::AIRLINE_ID) ?: null,
            departureCityId: $this->integer(self::DEPARTURE_CITY_ID) ?: null,
            arrivalCityId: $this->integer(self::ARRIVAL_CITY_ID) ?: null,
            departureDate: $this->date(self::DEPARTURE_DATE) ?: null,
            arrivalDate: $this->date(self::ARRIVAL_DATE) ?: null
        );
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;

class StoreFlightRequest extends FormRequest
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
            self::AIRLINE_ID => [
                'bail',
                'required',
                Rule::exists(Airline::class, 'id')],
            self::DEPARTURE_CITY_ID => ['bail', 'required', Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => ['bail', 'required', Rule::exists(
                City::class,
                'id'
            ), 'different:' . self::DEPARTURE_CITY_ID],
            self::DEPARTURE_DATE => ['bail', 'required', Rule::date()->format(self::DATE_FORMAT)->after(now())],
            self::ARRIVAL_DATE => ['bail', 'required',
                Rule::date()->format(self::DATE_FORMAT)->after(now())],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! $this->airlineEnablesFlightCities()) {
                    $this->setError(
                        $validator,
                        'airline_id',
                        "The airline's current flights are not enabled by the updated cities."
                    );
                }

                if (! $this->validFlightDatetimes()) {
                    $this->setError(
                        $validator,
                        'arrival_date',
                        'The arrival date and time cannot be before the departure date and time.'
                    );
                }
            },
        ];
    }

    private function setError(Validator $validator, string $field, string $errorMessage): void
    {
        $validator->errors()->add(
            $field,
            $errorMessage
        );
    }

    private function airlineEnablesFlightCities(): bool
    {
        $airline = Airline::findOrFail($this->integer(self::AIRLINE_ID));
        $enabledCities = $airline->enabledCities->pluck('id');
        
        $departureCityId = $this->integer(self::DEPARTURE_CITY_ID);
        $arrivalCityId = $this->integer(self::ARRIVAL_CITY_ID);

        return ($departureCityId && $enabledCities->contains($departureCityId))
        && ($arrivalCityId && $enabledCities->contains($arrivalCityId));
    }

    private function validFlightDateTimes(): bool
    {
        $departureCityId = $this->integer(self::DEPARTURE_CITY_ID);
        $arrivalCityId = $this->integer(self::ARRIVAL_CITY_ID);

        $departureCity = City::findOrFail($departureCityId);
        $arrivalCity = City::findOrFail($arrivalCityId);

        $departureDate = $this->string(self::DEPARTURE_DATE)->toString();
        $arrivalDate = $this->string(self::ARRIVAL_DATE)->toString();

        $departureDateToTz = $departureCity->dateToTimezone($departureDate);
        $arrivalDateToTz = $arrivalCity->dateToTimezone($arrivalDate);

        return $departureDateToTz->lessThan($arrivalDateToTz);
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            airlineId: $this->integer(self::AIRLINE_ID),
            departureCityId: $this->integer(self::DEPARTURE_CITY_ID),
            arrivalCityId: $this->integer(self::ARRIVAL_CITY_ID),
            departureDate: $this->date(self::DEPARTURE_DATE),
            arrivalDate: $this->date(self::ARRIVAL_DATE)
        );
    }
}

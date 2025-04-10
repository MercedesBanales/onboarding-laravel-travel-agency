<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Lightit\Backoffice\Airlines\Domain\DataTransferObjects\AirlineDto;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class UpdateAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const DESCRIPTION = 'description';

    public const ENABLED_CITIES_IDS = 'enabled_cities_ids';

    public const FLIGHT_IDS = 'flight_ids';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::NAME => [Rule::unique(Airline::class)],
            self::ENABLED_CITIES_IDS => ['bail', Rule::exists(City::class, 'id')],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                /**
                     * @var Airline $airline
                */
                $airline = $this->route('airline');
                if (! $this->airlineFlightsEnabledByCities($airline)) {
                    $validator->errors()->add(
                        'enabled_cities_ids',
                        "The airline's current flights are not enabled by the updated cities."
                    );
                }
            },
        ];
    }

    private function airlineFlightsEnabledByCities(Airline $airline): bool
    {
        $flights = $airline->flights;
        /**
         * @var array<int> $updatedEnabledCitiesIds
         */
        $updatedEnabledCitiesIds = $this->input(self::ENABLED_CITIES_IDS);
        $valid = true;

        foreach ($flights as $flight) {
            $arrival_city = City::findOrFail($flight->arrival_city_id);
            $arrival_date = $arrival_city->dateToTimezone($flight->arrival_date->toDateString());
            $valid = $valid && ! ($this->flightIsActive($arrival_date) && ! $this->flightIsEnabledByAirline(
                $flight,
                $updatedEnabledCitiesIds
            ));
        }

        return $valid;
    }

    private function flightIsActive(Carbon $arrival_date): bool
    {
        return $arrival_date->greaterThan(now());
    }

    private function flightIsEnabledByAirline(Flight $flight, array $enabledCities): bool
    {
        return in_array($flight->departure_city_id, $enabledCities)
            && in_array($flight->arrival_city_id, $enabledCities);
    }

    public function toDto(): AirlineDto
    {
        return new AirlineDto(
            name: $this->string(self::NAME)->toString() ?: null,
            description: $this->string(self::DESCRIPTION)->toString() ?: null,
            enabledCitiesIds: $this->array(self::ENABLED_CITIES_IDS) ?: null,
            flightIds: $this->array(self::FLIGHT_IDS) ?: null
        );
    }
}

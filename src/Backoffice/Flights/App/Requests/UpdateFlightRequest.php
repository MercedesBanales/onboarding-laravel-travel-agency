<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\App\Rules\EnabledFlightRule;
use Lightit\Backoffice\Flights\App\Rules\ValidFlightTimeRule;
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
        /**
         * @var Flight $flight
         */
        $flight = $this->route('flight');

        return [
            self::AIRLINE_ID => ['bail', Rule::exists(Airline::class, 'id'), new EnabledFlightRule($flight)],
            self::DEPARTURE_CITY_ID => [
                            'bail',
                            Rule::exists(City::class, 'id'),
                            new EnabledFlightRule($flight)],
            self::ARRIVAL_CITY_ID => [
                            'bail',
                            Rule::exists(City::class, 'id'),
                            new EnabledFlightRule($flight)],
            self::DEPARTURE_DATE => [Rule::date()->format(self::DATE_FORMAT)],
            self::ARRIVAL_DATE => ['bail', Rule::date()->format(self::DATE_FORMAT), new ValidFlightTimeRule($flight)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->sameOriginAndDestination()) {
                    $validator->errors()->add(
                        'arrival_city_id',
                        'The origin and destination cities must be different.'
                    );
                }
            }
        ];
    }

    public function sameOriginAndDestination() : bool {
        return $this->input(self::ARRIVAL_CITY_ID) === $this->input(self::DEPARTURE_CITY_ID);
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            airline_id: $this->integer(self::AIRLINE_ID) ?: null,
            departure_city_id: $this->integer(self::DEPARTURE_CITY_ID) ?: null,
            arrival_city_id: $this->integer(self::ARRIVAL_CITY_ID) ?: null,
            departure_date: $this->date(self::DEPARTURE_DATE) ?: null,
            arrival_date: $this->date(self::ARRIVAL_DATE) ?: null
        );
    }
}

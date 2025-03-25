<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\App\Rules\EnabledFlightRule;
use Lightit\Backoffice\Flights\App\Rules\ValidFlightTimeRule;
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
                'required', 
                Rule::exists(Airline::class, 'id'),
                new EnabledFlightRule()],
            self::DEPARTURE_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => ['required', Rule::exists(
                City::class,
                'id'
            ), 'different:' . self::DEPARTURE_CITY_ID],
            self::DEPARTURE_DATE => ['required', Rule::date()->format(self::DATE_FORMAT)->after(now())],
            self::ARRIVAL_DATE => ['required', Rule::date()->format(self::DATE_FORMAT)->after(now()), new ValidFlightTimeRule()],
        ];
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            airline_id: $this->integer(self::AIRLINE_ID),
            departure_city_id: $this->integer(self::DEPARTURE_CITY_ID),
            arrival_city_id: $this->integer(self::ARRIVAL_CITY_ID),
            departure_date: $this->date(self::DEPARTURE_DATE),
            arrival_date: $this->date(self::ARRIVAL_DATE)
        );
    }
}

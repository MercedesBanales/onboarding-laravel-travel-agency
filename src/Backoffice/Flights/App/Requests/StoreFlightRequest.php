<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Carbon\Exceptions\Exception;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;

class StoreFlightRequest extends FormRequest
{
    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const DEPARTURE_DATE = 'departure_date';

    public const ARRIVAL_DATE = 'arrival_date';

    public const DATE_FORMAT = 'd-m-Y H:i:sP';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::DEPARTURE_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => ['required', Rule::exists(City::class, 'id'), 'different:'.self::DEPARTURE_CITY_ID],
            self::DEPARTURE_DATE => ['required', Rule::date()->format(self::DATE_FORMAT)],
            self::ARRIVAL_DATE => ['required', Rule::date()->format(self::DATE_FORMAT)->after(self::DEPARTURE_DATE)] 
        ];
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            departure_city_id: $this->integer(self::DEPARTURE_CITY_ID),
            arrival_city_id: $this->integer(self::ARRIVAL_CITY_ID),
            departure_date: $this->date(self::DEPARTURE_DATE),
            arrival_date: $this->date(self::ARRIVAL_DATE)
        );
    }
}

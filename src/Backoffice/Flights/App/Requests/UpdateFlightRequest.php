<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;

class UpdateFlightRequest extends FormRequest
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
        $flight = $this->route('flight');
        $departure_city_id = $this->input(self::DEPARTURE_CITY_ID) ?? $flight->departure_city_id;
        $arrival_city_id = $this->input(self::ARRIVAL_CITY_ID) ?? $flight->arrival_city_id;
        $departure_date = $this->input(self::DEPARTURE_DATE) ?? $flight->departure_date;
        $arrival_date = $this->input(self::ARRIVAL_DATE) ?? $flight->arrival_date;

        return [
            self::DEPARTURE_CITY_ID => [
                            Rule::exists(City::class, 'id'),  
                            $this->differentCityRule($arrival_city_id, 'The departure city must be different from the arrival city.')],
            self::ARRIVAL_CITY_ID => [
                            Rule::exists(City::class, 'id'),
                            $this->differentCityRule($departure_city_id, 'The arrival city must be different from the departure city.')],
            self::DEPARTURE_DATE => [Rule::date()->format(self::DATE_FORMAT)->before($arrival_date)],
            self::ARRIVAL_DATE => [Rule::date()->format(self::DATE_FORMAT)->after($departure_date)] 
        ];
    }

    private function differentCityRule($comparisonValue, $errorMessage)
    {
        return function ($attribute, $value, $fail) use ($comparisonValue, $errorMessage) {
            if ($value == $comparisonValue) {
                $fail($errorMessage);
            }
        };
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            departure_city_id: $this->integer(self::DEPARTURE_CITY_ID) ?: null,
            arrival_city_id: $this->integer(self::ARRIVAL_CITY_ID) ?: null,
            departure_date: $this->date(self::DEPARTURE_DATE) ?: null,
            arrival_date: $this->date(self::ARRIVAL_DATE) ?: null
        );
    }
}

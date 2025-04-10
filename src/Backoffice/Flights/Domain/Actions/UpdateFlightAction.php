<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Actions;

use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class UpdateFlightAction
{
    public function execute(Flight $flight, FlightDto $dto): Flight
    {
        $flight->update([
            'airline_id' => $dto->airlineId ?? $flight->airline->id,
            'departure_city_id' => $dto->departureCityId ?? $flight->departure_city_id,
            'arrival_city_id' => $dto->arrivalCityId ?? $flight->arrival_city_id,
            'departure_date' => $dto->departureDate ?? $flight->departure_date,
            'arrival_date' => $dto->arrivalDate ?? $flight->arrival_date,
        ]);

        return $flight;
    }
}

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
            'airline_id' => $dto->airline_id ?? $flight->airline_id,
            'departure_city_id' => $dto->departure_city_id ?? $flight->departure_city_id,
            'arrival_city_id' => $dto->arrival_city_id ?? $flight->arrival_city_id,
            'departure_date' => $dto->departure_date ?? $flight->departure_date,
            'arrival_date' => $dto->arrival_date ?? $flight->arrival_date,
        ]);

        return $flight;
    }
}

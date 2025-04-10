<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Actions;

use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class StoreFlightAction
{
    public function execute(FlightDto $dto): Flight
    {
        return Flight::create([
            'airline_id' => $dto->airlineId,
            'departure_city_id' => $dto->departureCityId,
            'arrival_city_id' => $dto->arrivalCityId,
            'departure_date' => $dto->departureDate,
            'arrival_date' => $dto->arrivalDate,
        ]);
    }
}

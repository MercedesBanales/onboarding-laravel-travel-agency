<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\DataTransferObjects;

use Illuminate\Database\Eloquent\Collection;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

readonly class CityDto
{
    /**
     * @param Collection<int, Flight> $departure_flights
     * @param Collection<int, Flight> $arrival_flights
    */
    public function __construct(
        public string|null $name,
        public string|null $timezone,
        public Collection $departure_flights = new Collection([]),
        public Collection $arrival_flights = new Collection([]),
    ) {
    }
}

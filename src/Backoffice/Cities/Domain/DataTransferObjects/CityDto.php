<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\DataTransferObjects;

use Illuminate\Database\Eloquent\Collection;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

readonly class CityDto
{
    /**
     * @param Collection<int, Flight> $departureFlights
     * @param Collection<int, Flight> $arrivalFlights
    */
    public function __construct(
        public string|null $name,
        public string|null $timezone,
        public Collection $departureFlights = new Collection([]),
        public Collection $arrivalFlights = new Collection([]),
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\DataTransferObjects;

use Carbon\Carbon;

readonly class FlightDto
{
    public function __construct(
        public int|null $airlineId,
        public int|null $departureCityId,
        public int|null $arrivalCityId,
        public Carbon|null $departureDate,
        public Carbon|null $arrivalDate,
    ) {
    }
}

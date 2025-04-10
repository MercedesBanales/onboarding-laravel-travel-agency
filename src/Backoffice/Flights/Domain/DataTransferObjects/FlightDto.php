<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\DataTransferObjects;

use DateTime;

readonly class FlightDto
{
    public function __construct(
        public int|null $airlineId,
        public int|null $departureCityId,
        public int|null $arrivalCityId,
        public DateTime|null $departureDate,
        public DateTime|null $arrivalDate,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\DataTransferObjects;

use DateTime;

readonly class FlightDto
{
    public function __construct(
        public int|null $departure_city_id,
        public int|null $arrival_city_id,
        public DateTime|null $departure_date,
        public DateTime|null $arrival_date
    ) {
    }
}

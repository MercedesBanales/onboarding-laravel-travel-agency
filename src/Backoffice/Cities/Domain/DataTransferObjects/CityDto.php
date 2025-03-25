<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\DataTransferObjects;

use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Collection;

readonly class CityDto
{
    public function __construct(
        public string $name,
        public CarbonTimeZone $timezone,
        public Collection $departure_flights = new Collection([]),
        public Collection $arrival_flights = new Collection([]),
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\DataTransferObjects;

use Illuminate\Database\Eloquent\Collection;

readonly class AirlineDto
{
    public function __construct(
        public string|null $name,
        public array $enabled_cities_ids = [],
        public array $flight_ids = []
    ) {
    }
}

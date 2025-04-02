<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\DataTransferObjects;

readonly class AirlineDto
{
    public function __construct(
        public string|null $name,
        public string|null $description,
        public array $enabled_cities_ids = [],
        public array $flight_ids = [],
    ) {
    }
}

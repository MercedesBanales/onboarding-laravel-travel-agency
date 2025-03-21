<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\DataTransferObjects;

readonly class CityDto
{
    public function __construct(
        public string $name,
    ) {
    }
}

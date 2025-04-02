<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Actions;

use Lightit\Backoffice\Airlines\Domain\DataTransferObjects\AirlineDto;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;

class StoreAirlineAction
{
    public function execute(AirlineDto $dto): Airline
    {
        $airline = Airline::create([
            'name' => $dto->name,
            'description' => $dto->description
        ]);

        $airline->enabled_cities()->attach($dto->enabled_cities_ids);

        return $airline;
    }
}

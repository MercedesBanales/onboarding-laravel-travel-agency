<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Actions;

use Lightit\Backoffice\Airlines\Domain\DataTransferObjects\AirlineDto;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;

class UpdateAirlineAction
{
    public function execute(Airline $airline, AirlineDto $dto): Airline
    {
        $airline->update([
            'name' => $dto->name ?? $airline->name,
            'description' => $dto->description ?? $airline->description
        ]);

        $airline->enabled_cities()->sync($dto->enabled_cities_ids ?? $airline->enabled_cities->pluck('id'));

        return $airline;
    }
}

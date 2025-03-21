<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Actions;

use Lightit\Backoffice\Cities\Domain\DataTransferObjects\CityDto;
use Lightit\Backoffice\Cities\Domain\Models\City;

class UpdateCityAction
{
    public function execute(City $city, CityDto $dto): City
    {
        $city->update([
            'name' => $dto->name ?? $city->name,
        ]);

        return $city;
    }
}

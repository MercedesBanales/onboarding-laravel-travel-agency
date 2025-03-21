<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Controllers;

use Lightit\Backoffice\Cities\Domain\Models\City;

class DeleteCityController
{
    public function __invoke(City $city)
    {
        $city->delete();

        return responder()
            ->success()
            ->respond();
    }
}

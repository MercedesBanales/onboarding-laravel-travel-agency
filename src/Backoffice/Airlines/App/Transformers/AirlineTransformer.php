<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;

class AirlineTransformer extends Transformer
{
    /**
     * Transform the model.
     *
     *
     * @return array
     */
    public function transform(Airline $airline)
    {
        return [
            'id' => $airline->id,
            'name' => $airline->name,
            'enabled_cities' => $airline->enabled_cities,
            'flights' => $airline->flights            
        ];
    }
}

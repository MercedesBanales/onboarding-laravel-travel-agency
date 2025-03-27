<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airlines\App\Rules\ValidateActiveFlightsRule;
use Lightit\Backoffice\Airlines\Domain\DataTransferObjects\AirlineDto;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;

class UpdateAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const ENABLED_CITIES_IDS = 'enabled_cities_ids';

    public const FLIGHT_IDS = 'flight_ids';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /**
         * @var Airline $airline
        */
        $airline = $this->route('airline');

        return [
            self::NAME => [Rule::unique(Airline::class)],
            self::ENABLED_CITIES_IDS => ['bail',
                        Rule::exists(City::class, 'id'),
                        new ValidateActiveFlightsRule($airline)],
        ];
    }

    public function toDto(): AirlineDto
    {
        return new AirlineDto(
            name: $this->string(self::NAME)->toString(),
            enabled_cities_ids: $this->array(self::ENABLED_CITIES_IDS),
            flight_ids: $this->array(self::FLIGHT_IDS)
        );
    }
}

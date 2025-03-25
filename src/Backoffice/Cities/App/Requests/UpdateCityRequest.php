<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Requests;

use Carbon\CarbonTimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Cities\Domain\DataTransferObjects\CityDto;

class UpdateCityRequest extends FormRequest
{
    public const NAME = 'name';

    public const TIMEZONE = 'timezone';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::TIMEZONE => ['timezone:all']
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)?->toString() ?: null,
            timezone: CarbonTimeZone::create($this->string(self::TIMEZONE)) ?: null
        );
    }
}

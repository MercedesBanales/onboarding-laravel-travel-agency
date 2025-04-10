<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Cities\Domain\DataTransferObjects\CityDto;
use Lightit\Backoffice\Cities\Domain\Models\City;

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
            self::NAME => ['sometimes', Rule::unique(City::class)],
            self::TIMEZONE => ['sometimes', 'timezone:all'],
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString() ?: null,
            timezone: $this->string(self::TIMEZONE)->toString() ?: null,
        );
    }
}

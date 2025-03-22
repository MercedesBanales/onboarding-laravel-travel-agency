<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lightit\Backoffice\Cities\Domain\Models\City;

/**
 * 
 *
 * @property int $id
 * @property int $departure_city_id
 * @property int $arrival_city_id
 * @property string $departure_date
 * @property string $arrival_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read City|null $arrivalCity
 * @property-read City|null $departureCity
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereArrivalCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereDepartureCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereUpdatedAt($value)
 * @property-read City|null $arrival_city
 * @property-read City|null $departure_city
 * @mixin \Eloquent
 */
class Flight extends Model
{
    protected $guarded = [
        'id'
    ];
    
    public function departure_city() : BelongsTo
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    public function arrival_city() : BelongsTo
    {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }
}

<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

/**
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $enabledCities
 * @property-read int|null $enabled_cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flights
 * @property-read int|null $flights_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline whereUpdatedAt($value)
 *
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline whereName($value)
 *
 * @property string $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airline whereDescription($value)
 *
 * @mixin \Eloquent
 */
class Airline extends Model
{
    protected $guarded = [ 'id' ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return HasMany<Flight, $this>
    */
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class, 'airline_id');
    }

    /**
     * @return BelongsToMany<City, $this, Pivot>
    */
    public function enabledCities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'airline_city', 'airline_id', 'city_id');
    }
}

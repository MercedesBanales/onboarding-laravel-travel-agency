<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

/**
 * Lightit\Backoffice\Cities\Domain\Models\City
 *
 * @property int                             $id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $arrivalFlights
 * @property-read int|null $arrival_flights_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $departureFlights
 * @property-read int|null $departure_flights_count
 * @property string $timezone
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereTimezone($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Airline> $airlines
 * @property-read int|null $airlines_count
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $hidden = [ 'pivot', 'created_at', 'updated_at' ];

    /**
     * @return HasMany<Flight, $this>
    */
    public function departureFlights(): HasMany
    {
        return $this->hasMany(Flight::class, 'departure_city_id');
    }

    /**
     * @return HasMany<Flight, $this>
    */
    public function arrivalFlights(): HasMany
    {
        return $this->hasMany(Flight::class, 'arrival_city_id');
    }

    /**
     * @return BelongsToMany<Airline, $this>
    */
    public function airlines(): BelongsToMany
    {
        return $this->belongsToMany(Airline::class, 'airline_city', 'airline_id', 'city_id');
    }

    public function dateToTimezone(string $date): Carbon
    {
        return Carbon::parse($date, $this->timezone);
    }
}

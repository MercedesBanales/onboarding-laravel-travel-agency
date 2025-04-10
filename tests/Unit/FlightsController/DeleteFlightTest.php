<?php

declare(strict_types=1);

namespace Tests\Unit\FlightsController;

use Lightit\Backoffice\Flights\Domain\Models\Flight;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\seed;

describe('flights', function () {
    beforeEach(function () {
        seed();
    });

    it('can delete an existing flight successfully', function () {
        $flight = Flight::inRandomOrder()->firstOrFail();

        $response = deleteJson(url("/api/flights/$flight->id"));

        $response
            ->assertSuccessful();
        
        assertDatabaseMissing('flights', [
            'airline_id' => $flight->airline_id,
            'departure_city_id' => $flight->departure_city->id,
            'arrival_city_id' => $flight->arrival_city->id,
            'departure_date' => $flight->departure_date,
            'arrival_date' => $flight->arrival_date,
        ]);
    });


    it('cannot delete a flight that does not exist', function () {
        $flight_id = -1;

        $response = deleteJson(url("/api/flights/$flight_id"));

        $response
            ->assertNotFound();
    });
});

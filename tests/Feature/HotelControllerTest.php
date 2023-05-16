<?php

namespace Tests\Feature;

use App\Models\Hotel;
use Tests\TestCase;

class HotelControllerTest extends TestCase
{
    public function testIndexReturnsAllHotels()
    {
        $hotels = Hotel::factory()->count(2)->create();

        $this->json('GET', 'api/v1/hotels')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $hotels[0]->uuid,
            ])
            ->assertJsonFragment([
                'uuid' => $hotels[1]->uuid,
            ]);
    }

    public function testIndexWithHotelFilterReturnsHotelMatchFilterId()
    {
        $hotels = Hotel::factory()->count(2)->create();

        $this->json('GET', 'api/v1/hotels', [
            'hotels' => $hotels[0]->external_id,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $hotels[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $hotels[1]->uuid,
            ]);
    }

    public function testIndexWithReturnsHotelMatchFilterId()
    {
        $hotels = Hotel::factory()->count(2)->create();

        $this->json('GET', 'api/v1/hotels', [
            'destination' => $hotels[1]->external_destination_id,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $hotels[1]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $hotels[0]->uuid,
            ]);
    }
}

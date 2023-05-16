<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'external_id' => $this->faker->uuid(),
            'external_destination_id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state_code' => $this->faker->word(),
            'postal_code' => $this->faker->postcode(),
            'country_code' => $this->faker->countryCode(),
            'images' => [
                'rooms' => [],
                'sites' => [],
                'amenities' => [],
            ],
            'amenities' => [
                'general' => [],
                'rooms' => [],
            ],
            'booking_conditions' => [
                $this->faker->words(),
            ],
        ];
    }
}

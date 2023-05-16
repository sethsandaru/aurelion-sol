<?php

namespace App\Http\Resources;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Hotel */
class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'external_id' => $this->external_id,
            'external_destination_id' => $this->external_destination_id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'address' => $this->address,
                'city' => $this->city,
                'state_code' => $this->state_code,
                'postal_code' => $this->postal_code,
                'country_code' => $this->country_code,
            ],
            'images' => $this->images,
            'amenities' => $this->amenities,
            'booking_conditions' => $this->booking_conditions,
            'additional_details' => $this->additional_details,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

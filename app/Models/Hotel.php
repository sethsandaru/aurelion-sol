<?php

namespace App\Models;

use App\Services\ETL\RawHotel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'description',
        'external_id',
        'external_destination_id',
        'address',
        'latitude',
        'longitude',
        'city',
        'postal_code',
        'state_code',
        'country_code',
        'images',
        'amenities',
        'booking_conditions',
        'additional_details',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'images' => 'array',
        'amenities' => 'array',
        'booking_conditions' => 'array',
        'additional_details' => 'array',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public static function createFromRawHotel(RawHotel $rawHotel): Hotel
    {
        return Hotel::create([
            'external_id' => $rawHotel->id,
            'external_destination_id' => $rawHotel->destinationId,
            'name' => $rawHotel->name,
            'description' => $rawHotel->description,
            'latitude' => $rawHotel->latitude,
            'longitude' => $rawHotel->longitude,
            'address' => $rawHotel->address,
            'city' => $rawHotel->city,
            'state_code' => $rawHotel->stateCode,
            'postal_code' => $rawHotel->postalCode,
            'country_code' => $rawHotel->countryCode,
            'amenities' => [
                'general' => $rawHotel->generalAmenities ?: [],
                'rooms' => $rawHotel->roomAmenities ?: [],
            ],
            'images' => [
                'rooms' => $rawHotel->roomImages ?: [],
                'sites' => $rawHotel->siteImages ?: [],
                'amenities' => $rawHotel->amenityImages ?: [],
            ],
        ]);
    }
}

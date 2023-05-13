<?php

namespace App\Services\ETL;

/**
 * This RawHotel is compatible with the Hotel model
 *
 * After retrieved the Hotel from services,
 */
class RawHotel
{
    public ?string $id = null;
    public ?string $destinationId = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $stateCode = null;
    public ?string $postalCode = null;
    public ?string $countryCode = null;
    public array $roomImages = [];
    public array $siteImages = [];
    public array $amenityImages = [];
    public array $generalAmenities = [];
    public array $roomAmenities = [];
    public array $bookingConditions = [];
}

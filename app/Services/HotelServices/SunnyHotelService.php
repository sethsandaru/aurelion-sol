<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;

class SunnyHotelService extends AbstractHotelService implements HotelServiceContract
{
    public function getName(): string
    {
        return 'Sunny';
    }

    public function getHotelsEndpoint(): string
    {
        return 'http://www.mocky.io/v2/5ebbea102e000029009f3fff';
    }

    public function transformSingleHotel(array $rawData): RawHotel
    {
        $rawHotel = new RawHotel();
        $rawHotel->id = $this->getDataClean($rawData, 'hotel_id');
        $rawHotel->destinationId = $this->getDataClean($rawData, 'destination_id');
        $rawHotel->name = $this->getDataClean($rawData, 'hotel_name');
        $rawHotel->address = $this->getDataClean($rawData, 'location.address');
        $rawHotel->countryCode = match ($this->getDataClean($rawData, 'location.country')) {
            'Singapore' => 'SG',
            'Vietnam' => 'VN',
            'United States' => 'US',
            'Japan' => 'JP',
        };
        $rawHotel->description = $this->getDataClean($rawData, 'location.details');
        $rawHotel->roomImages = $this->getDataClean($rawData, 'images.rooms') ?: [];
        $rawHotel->generalAmenities = $this->getDataClean($rawData, 'amenities.general') ?: [];
        $rawHotel->roomAmenities = $this->getDataClean($rawData, 'amenities.room') ?: [];
        $rawHotel->siteImages = $this->getDataClean($rawData, 'images.site') ?: [];
        $rawHotel->bookingConditions = $this->getDataClean($rawData, 'booking_conditions') ?: [];

        return $rawHotel;
    }
}

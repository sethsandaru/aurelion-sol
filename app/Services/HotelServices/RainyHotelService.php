<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;

class RainyHotelService extends AbstractHotelService implements HotelServiceContract
{
    public function getName(): string
    {
        return 'Rainy';
    }

    public function getHotelsEndpoint(): string
    {
        return 'http://www.mocky.io/v2/5ebbea002e000054009f3ffc';
    }

    public function transformSingleHotel(array $rawData): RawHotel
    {
        $rawHotel = new RawHotel();
        $rawHotel->id = $this->getDataClean($rawData, 'Id');
        $rawHotel->destinationId = $this->getDataClean($rawData, 'DestinationId');
        $rawHotel->name = $this->getDataClean($rawData, 'Name');
        $rawHotel->latitude = floatval($this->getDataClean($rawData, 'Latitude')) ?: null;
        $rawHotel->longitude = floatval($this->getDataClean($rawData, 'Longitude')) ?: null;
        $rawHotel->address = $this->getDataClean($rawData, 'Address');
        $rawHotel->city = $this->getDataClean($rawData, 'City');
        $rawHotel->postalCode = $this->getDataClean($rawData, 'PostalCode');
        $rawHotel->countryCode = $this->getDataClean($rawData, 'Country');
        $rawHotel->description = $this->getDataClean($rawData, 'Description');
        $rawHotel->generalAmenities = $this->getDataClean($rawData, 'Facilities') ?: [];

        return $rawHotel;
    }
}

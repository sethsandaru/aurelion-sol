<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;
use Illuminate\Support\Str;

class RainyHotelService extends AbstractHotelService implements HotelServiceContract
{
    /**
     * There would be some special texts that automated transformation won't fulfill
     * So we need to define them here thus replace on checking
     */
    protected const SPECIAL_CASES_AMENITIES = [
        'WiFi' => 'wifi',
    ];

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

        // we need to map the values to lower case to make it consistent
        // eg: BusinessCenter => business center
        $rawHotel->generalAmenities = array_map(function (string $value) {
            if (array_key_exists($value, static::SPECIAL_CASES_AMENITIES)) {
                return static::SPECIAL_CASES_AMENITIES[$value];
            }

            return Str::replace(
                '_',
                ' ',
                Str::snake($value)
            );
        }, $this->getDataClean($rawData, 'Facilities') ?: []);

        return $rawHotel;
    }
}

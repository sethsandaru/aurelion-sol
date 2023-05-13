<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;

class WindyHotelService extends AbstractHotelService implements HotelServiceContract
{
    public function getName(): string
    {
        return 'Windy';
    }

    public function getHotelsEndpoint(): string
    {
        return 'http://www.mocky.io/v2/5ebbea1f2e00002b009f4000';
    }

    public function transformSingleHotel(array $rawData): RawHotel
    {
        $rawHotel = new RawHotel();
        $rawHotel->id = $this->getDataClean($rawData, 'id');
        $rawHotel->destinationId = $this->getDataClean($rawData, 'destination');
        $rawHotel->name = $this->getDataClean($rawData, 'name');
        $rawHotel->latitude = $this->getDataClean($rawData, 'lat');
        $rawHotel->longitude = $this->getDataClean($rawData, 'lng');
        $rawHotel->description = $this->getDataClean($rawData, 'info');
        $rawHotel->address = $this->getDataClean($rawData, 'address');
        $rawHotel->generalAmenities = $this->getDataClean($rawData, 'amenities') ?: [];
        $rawHotel->roomImages = $this->mapImages(
            $this->getDataClean($rawData, 'images.rooms') ?: []
        );
        $rawHotel->amenityImages = $this->mapImages(
            $this->getDataClean($rawData, 'images.amenities') ?: []
        );

        return $rawHotel;
    }

    private function mapImages(array $rawImages): array
    {
        return array_map(function (array $image) {
            return [
                'link' => $image['url'],
                'caption' => $image['description'],
            ];
        }, $rawImages);
    }
}

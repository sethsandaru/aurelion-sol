<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;
use App\Services\ETL\RawHotels;

class WindyHotelService implements HotelServiceContract
{
    public function getHotels(): RawHotels
    {
        // TODO: Implement getHotels() method.
    }

    public function transformSingleHotel(array $rawData): RawHotel
    {
        // TODO: Implement transformSingleHotel() method.
    }
}

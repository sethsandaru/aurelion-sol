<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotel;
use App\Services\ETL\RawHotels;

interface HotelServiceContract
{
    /**
     * Readable / Code name
     */
    public function getName(): string;

    /**
     * The contractor must be able to transform the single RawHotel from the raw record
     *
     * @param array $rawData
     * @return RawHotel
     */
    public function transformSingleHotel(array $rawData): RawHotel;

    /**
     * The contractor must implement the `getHotels` and return the valid ETL models
     *
     * @return RawHotels
     */
    public function getHotels(): RawHotels;
}

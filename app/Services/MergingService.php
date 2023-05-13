<?php

namespace App\Services;

use App\Models\Hotel;
use App\Services\ETL\RawHotel;

class MergingService
{
    /**
     * Resolving a RawHotel into an usable Hotel instance
     */
    public function resolve(RawHotel $rawHotel): Hotel
    {
        $hotel = Hotel::where([
            'external_id' => $rawHotel->id,
            'external_destination_id' => $rawHotel->destinationId,
        ])->first();

        if (!$hotel) {
            return Hotel::createFromRawHotel($rawHotel);
        }

        // merging happens now

        $hotel->save();

        return $hotel;
    }
}

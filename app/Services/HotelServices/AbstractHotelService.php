<?php

namespace App\Services\HotelServices;

use App\Services\ETL\RawHotels;
use Illuminate\Support\Facades\Http;

abstract class AbstractHotelService implements HotelServiceContract
{
    abstract public function getHotelsEndpoint(): string;

    public function getHotels(): RawHotels
    {
        $hotelsResponse = Http::get($this->getHotelsEndpoint());
        $hotels = new RawHotels();

        if (!$hotelsResponse->ok()) {
            return $hotels;
        }

        $hotelsResponse
            ->collect()
            ->each(fn (array $record) => $hotels->add($this->transformSingleHotel($record)));

        return $hotels;
    }

    public function getDataClean(array $record, string $key): mixed
    {
        $value = data_get($record, $key);
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return array_map(function ($val) {
                return is_string($val)
                    ? trim($val)
                    : $val;
            }, $value);
        }

        return is_string($value)
            ? trim($value)
            : $value;
    }
}

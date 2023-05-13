<?php

namespace App\Models;

use App\Services\ETL\RawHotel;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
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
        'country_code',
        'images',
        'amenities',
        'additional_details',
    ];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'additional_details' => 'array',
    ];

    public static function createFromRawHotel(RawHotel $rawHotel): Hotel
    {
        return Hotel::create([]);
    }
}

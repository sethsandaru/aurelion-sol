<?php

namespace App\Services;

use App\Models\Hotel;
use App\Services\ETL\RawHotel;
use App\Services\MergeRules\DescriptionMergeRule;
use App\Services\MergeRules\MergeRuleContract;
use App\Services\MergeRules\MergeType;
use App\Services\MergeRules\NullCoalesceMergeRule;
use App\Services\MergeRules\UnionArrayMergeRule;
use App\Services\MergeRules\UniqueArrayMergeRule;

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

        [$nullCoalesceRule, $descriptionRule, $unionArrayRule, $uniqueArrayRule] = [
            $this->getMergeRule(MergeType::NULL_COALESCE),
            $this->getMergeRule(MergeType::DESCRIPTION),
            $this->getMergeRule(MergeType::UNION_ARRAY_MERGE),
            $this->getMergeRule(MergeType::UNIQUE_ARRAY_MERGE),
        ];

        // Merging using NullCoalesce
        $hotel->name = $nullCoalesceRule->merge($hotel->name, $rawHotel->name);
        $hotel->latitude = $nullCoalesceRule->merge($hotel->latitude, $rawHotel->latitude);
        $hotel->longitude = $nullCoalesceRule->merge($hotel->longitude, $rawHotel->longitude);
        $hotel->address = $nullCoalesceRule->merge($hotel->address, $rawHotel->address);
        $hotel->city = $nullCoalesceRule->merge($hotel->city, $rawHotel->city);
        $hotel->state_code = $nullCoalesceRule->merge($hotel->state_code, $rawHotel->stateCode);
        $hotel->postal_code = $nullCoalesceRule->merge($hotel->postal_code, $rawHotel->postalCode);
        $hotel->country_code = $nullCoalesceRule->merge($hotel->country_code, $rawHotel->countryCode);

        // Merging using Description
        $hotel->description = $descriptionRule->merge($hotel->description, $rawHotel->description);

        // Merging using UnionArray
        $hotel->images = [
            'rooms' => $unionArrayRule->merge(
                $hotel->images['rooms'],
                $rawHotel->roomImages
            ),
            'sites' => $unionArrayRule->merge(
                $hotel->images['sites'],
                $rawHotel->siteImages
            ),
            'amenities' => $unionArrayRule->merge(
                $hotel->images['amenities'],
                $rawHotel->amenityImages
            ),
        ];


        // Merging using UniqueArray
        $hotel->amenities = [
             'general' => $uniqueArrayRule->merge(
                 $hotel->amenities['general'],
                 $rawHotel->generalAmenities
             ),
             'rooms' => $uniqueArrayRule->merge(
                 $hotel->amenities['rooms'],
                 $rawHotel->roomAmenities
             ),
        ];
        $hotel->booking_conditions = $uniqueArrayRule->merge(
            $hotel->booking_conditions,
            $rawHotel->bookingConditions
        );

        // persistence
        $hotel->save();

        return $hotel;
    }

    public function getMergeRule(MergeType $mergeType): MergeRuleContract
    {
        return match ($mergeType) {
            MergeType::NULL_COALESCE => app(NullCoalesceMergeRule::class),
            MergeType::DESCRIPTION => app(DescriptionMergeRule::class),
            MergeType::UNION_ARRAY_MERGE => app(UnionArrayMergeRule::class),
            MergeType::UNIQUE_ARRAY_MERGE => app(UniqueArrayMergeRule::class),
        };
    }
}

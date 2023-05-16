<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HotelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $hotels = Hotel::query()
            ->when(
                $request->input('hotels'),
                fn ($q) => $q->whereIn('external_id', Arr::wrap($request->input('hotels')))
            )
            ->when(
                $request->input('destination'),
                fn ($q) => $q->whereIn('external_destination_id', Arr::wrap($request->input('destination')))
            )
            ->get();

        return HotelResource::collection($hotels)->response();
    }
}

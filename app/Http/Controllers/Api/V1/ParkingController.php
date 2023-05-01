<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parking\StartParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;
use Illuminate\Http\Response;

/**
 * @group Parking
 */
class ParkingController extends Controller
{
    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }

    public function start(StartParkingRequest $request) {

        if(Parking::active()->where('vehicle_id', $request->vehicle_id)->exists()) {

            return response()->json([
                'errors' => [
                    'general' => ['can\'t start parking twice using same vehicle. please stop currently active parking.']
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($request->validated());
        $parking->load(['vehicle', 'zone']);

        return ParkingResource::make($parking);
    }

    public function stop(Parking $parking) {

        if($parking->stop_time) {
            return response()->json(['errors' => ['general' => ['Parking already stopped.']], ]
            , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time)
        ]);

        return ParkingResource::make($parking);
    }
}

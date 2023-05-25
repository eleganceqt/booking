<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;
use App\Services\ReservationService;
use App\Http\Requests\ReservationStoreRequest;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $service
    ) {
        //
    }

    public function store(ReservationStoreRequest $request, Room $room): JsonResponse
    {
        $reservation = $this->service->reserve($room, $request->toMakeReservationAttributes());

        return new JsonResponse($reservation->toArray());
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use App\Http\Requests\ReservationSearchRequest;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $service
    ) {
        //
    }

    public function search(ReservationSearchRequest $request): JsonResponse
    {
        $reservations = $this->service->search($request->toReservationSearchAttributes());

        return new JsonResponse($reservations->toArray());
    }
}

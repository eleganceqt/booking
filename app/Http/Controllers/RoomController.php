<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RoomSearchRequest;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $service
    ) {
        //
    }

    public function index(RoomSearchRequest $request): JsonResponse
    {
        $rooms = $this->service->availableRooms($request->toSearchAttributes());

        return new JsonResponse($rooms->toArray());
    }
}

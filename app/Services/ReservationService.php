<?php

namespace App\Services;

use App\Models\Room;
use RuntimeException;
use Carbon\CarbonImmutable;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\DataTransferObjects\MakeReservationAttributes;
use App\DataTransferObjects\ReservationSearchAttributes;

class ReservationService
{
    public function __construct(
        protected RoomService $roomService,
        protected GuestService $guestService,
    ) {
        //
    }

    /**
     * @param \App\Models\Room $room
     * @param \App\DataTransferObjects\MakeReservationAttributes $attributes
     *
     * @return \App\Models\Reservation
     * @throws \Throwable
     */
    public function reserve(Room $room, MakeReservationAttributes $attributes): Reservation
    {
        return DB::transaction(function () use ($room, $attributes): Reservation {

            Room::query()->lockForUpdate()->find($room->getKey());

            if (!$this->roomService->isRoomAvailable($room, $attributes)) {
                throw new RuntimeException('Room cannot be reserved.');
            }

            $guest = $this->guestService->findOrCreate($attributes->guest);

            return Reservation::create([
                'room_id' => $room->getKey(),
                'guest_id' => $guest->getKey(),
                'reserved_at' => now()->toDateTimeString(),
                'checkin_date' => $attributes->checkinDate->toDateString(),
                'checkout_date' => $attributes->checkoutDate->toDateString(),
                'status' => ReservationStatus::PENDING,
            ]);
        });
    }

    /**
     * @param \App\DataTransferObjects\ReservationSearchAttributes $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation>
     */
    public function search(ReservationSearchAttributes $attributes): Collection
    {
        return Reservation::query()
            ->where(fn(Builder $query) => $query
                ->whereBetween('checkin_date', [
                    $attributes->checkinDate->toDateString(),
                    $attributes->checkoutDate->toDateString()
                ])
                ->orWhereBetween('checkout_date', [
                    $attributes->checkinDate->toDateString(),
                    $attributes->checkoutDate->toDateString()
                ])
            )
            ->with('room', 'guest')
            ->get();
    }

    /**
     * @param \Carbon\CarbonImmutable $start
     *
     * @return int
     */
    public function purgePending(CarbonImmutable $start): int
    {
        return Reservation::query()
            ->where('status', ReservationStatus::PENDING)
            ->where('reserved_at', '<=', $start->toDateTimeString())
            ->delete();
    }
}

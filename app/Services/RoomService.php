<?php

namespace App\Services;

use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\DataTransferObjects\RoomSearchAttributes;
use App\DataTransferObjects\MakeReservationAttributes;

class RoomService
{
    /**
     * @param \App\DataTransferObjects\RoomSearchAttributes $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Room>
     */
    public function availableRooms(RoomSearchAttributes $attributes): Collection
    {
        return $this
            ->availableQuery(
                checkinDate: $attributes->checkinDate,
                checkoutDate: $attributes->checkoutDate,
                persons: $attributes->persons
            )
            ->get();
    }

    /**
     * @param \App\Models\Room $room
     * @param \App\DataTransferObjects\MakeReservationAttributes $attributes
     *
     * @return bool
     */
    public function isRoomAvailable(Room $room, MakeReservationAttributes $attributes): bool
    {
        return $this
            ->availableQuery(
                checkinDate: $attributes->checkinDate,
                checkoutDate: $attributes->checkoutDate,
                persons: $attributes->persons
            )
            ->where('rooms.id', $room->getKey())
            ->exists();
    }

    /**
     * @param \Carbon\CarbonImmutable $checkinDate
     * @param \Carbon\CarbonImmutable $checkoutDate
     * @param int $persons
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function availableQuery(CarbonImmutable $checkinDate, CarbonImmutable $checkoutDate, int $persons): Builder
    {
        return Room::query()
            ->whereDoesntHave('reservations', fn(Builder $query) => $query
                ->whereRaw(
                    sql: "daterange(checkin_date, checkout_date, '[)'::text) && daterange(?, ?, '[)'::text)",
                    bindings: [$checkinDate->toDateString(), $checkoutDate->toDateString()]
                )
            )
            ->where('occupancy', '>=', $persons);
    }
}

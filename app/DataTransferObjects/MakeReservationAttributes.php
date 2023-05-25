<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;

final readonly class MakeReservationAttributes implements Arrayable
{
    public CarbonImmutable $checkoutDate;

    public function __construct(
        public CarbonImmutable $checkinDate,
        public int $nights,
        public int $persons,
        public GuestAttributes $guest
    ) {
        $this->checkoutDate = $this->checkinDate->addDays($this->nights);
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}

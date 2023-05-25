<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;

final readonly class RoomSearchAttributes implements Arrayable
{
    public CarbonImmutable $checkoutDate;

    public function __construct(
        public CarbonImmutable $checkinDate,
        public int $nights,
        public int $persons,
    ) {
        $this->checkoutDate = $this->checkinDate->addDays($this->nights);
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}

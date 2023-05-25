<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;

final readonly class ReservationSearchAttributes implements Arrayable
{
    public function __construct(
        public CarbonImmutable $checkinDate,
        public CarbonImmutable $checkoutDate,
    ) {
        //
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}

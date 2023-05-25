<?php

namespace App\Enums;

enum ReservationStatus: int
{
    case PENDING = 0;
    case CONFIRMED = 1;
}

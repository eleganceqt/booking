<?php

namespace App\Observers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmedMail;

class ReservationObserver
{
    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void
    {
        if ($reservation->isDirty('status') && $reservation->isConfirmed()) {

            Mail::to($reservation->guest->email)
                ->send(new ReservationConfirmedMail($reservation));
        }
    }
}

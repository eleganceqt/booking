<?php

namespace App\Services;

use App\Models\Guest;
use App\DataTransferObjects\GuestAttributes;

class GuestService
{
    /**
     * @param \App\DataTransferObjects\GuestAttributes $attributes
     *
     * @return \App\Models\Guest
     */
    public function findOrCreate(GuestAttributes $attributes): Guest
    {
        return Guest::firstOrCreate(
            ['email' => $attributes->email],
            [
                'name' => $attributes->name,
                'phone' => $attributes->phone
            ]
        );
    }
}

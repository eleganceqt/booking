<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;

final readonly class GuestAttributes implements Arrayable
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
    ) {
        //
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}

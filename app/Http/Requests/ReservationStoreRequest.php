<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\GuestAttributes;
use App\DataTransferObjects\MakeReservationAttributes;

class ReservationStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = app(RoomSearchRequest::class)->rules();

        return array_merge($rules, [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|string|max:255',
            'user.phone' => 'required|string|max:255',
        ]);
    }

    public function toMakeReservationAttributes(): MakeReservationAttributes
    {
        return new MakeReservationAttributes(
            checkinDate: $this->date('checkin_date', '!Y-m-d')->toImmutable(),
            nights: $this->integer('nights'),
            persons: $this->integer('persons'),
            guest: new GuestAttributes(
                name: $this->string('user.name'),
                email: $this->string('user.email'),
                phone: $this->string('user.phone'),
            )
        );
    }
}

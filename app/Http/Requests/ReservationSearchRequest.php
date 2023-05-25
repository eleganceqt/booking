<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\ReservationSearchAttributes;

class ReservationSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'checkin_date' => 'required|date-format:Y-m-d',
            'checkout_date' => 'required|date-format:Y-m-d',
        ];
    }

    public function toReservationSearchAttributes(): ReservationSearchAttributes
    {
        return new ReservationSearchAttributes(
            checkinDate: $this->date('checkin_date', '!Y-m-d')->toImmutable(),
            checkoutDate: $this->date('checkout_date', '!Y-m-d')->toImmutable(),
        );
    }
}

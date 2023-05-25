<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\RoomSearchAttributes;

class RoomSearchRequest extends FormRequest
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
            'nights' => 'required|integer|min:1',
            'persons' => 'required|integer|between:1,4',
        ];
    }

    public function toSearchAttributes(): RoomSearchAttributes
    {
        return new RoomSearchAttributes(
            checkinDate: $this->date('checkin_date', '!Y-m-d')->toImmutable(),
            nights: $this->integer('nights'),
            persons: $this->integer('persons')
        );
    }
}

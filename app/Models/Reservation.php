<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use App\Query\ReservationQueryBuider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * \App\Models\Reservation
 *
 * @property int $id
 * @property int $room_id
 * @property int $guest_id
 * @property string $reserved_at
 * @property string $checkin_date
 * @property string $checkout_date
 * @property ReservationStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Guest $guest
 * @property-read \App\Models\Room $room
 * @method static \Database\Factories\ReservationFactory factory($count = null, $state = [])
 * @method static Builder|Reservation newModelQuery()
 * @method static Builder|Reservation newQuery()
 * @method static Builder|Reservation query()
 * @method static Builder|Reservation whereCheckinDate($value)
 * @method static Builder|Reservation whereCheckoutDate($value)
 * @method static Builder|Reservation whereCreatedAt($value)
 * @method static Builder|Reservation whereGuestId($value)
 * @method static Builder|Reservation whereId($value)
 * @method static Builder|Reservation whereReservedAt($value)
 * @method static Builder|Reservation whereRoomId($value)
 * @method static Builder|Reservation whereStatus($value)
 * @method static Builder|Reservation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'guest_id', 'reserved_at',
        'checkin_date', 'checkout_date',
        'status'

    ];

    protected $casts = [
        'status' => ReservationStatus::class,
    ];

    public function isPending(): bool
    {
        return $this->status === ReservationStatus::PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === ReservationStatus::CONFIRMED;
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}

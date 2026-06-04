<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['client_id', 'stylist_id', 'service_id', 'start_time', 'end_time', 'status', 'notes', 'cancellation_reason'])]
class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'status' => AppointmentStatus::class,
        ];
    }

    /**
     * Get the client who booked this appointment.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id')->withTrashed();
    }

    /**
     * Get the stylist assigned to this appointment.
     */
    public function stylist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'stylist_id')->withTrashed();
    }

    /**
     * Get the service booked for this appointment.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }

    /**
     * Enforce strict backend prevention of overlapping slots or double-bookings for stylists.
     * Returns true if the slot is available, false otherwise.
     *
     * @param int|string $stylistId
     * @param string|\DateTimeInterface $startTime
     * @param string|\DateTimeInterface $endTime
     * @param int|string|null $excludeAppointmentId
     * @return bool
     */
    public static function isSlotAvailable($stylistId, $startTime, $endTime, $excludeAppointmentId = null): bool
    {
        $query = self::where('stylist_id', $stylistId)
            ->where('status', '!=', AppointmentStatus::CANCELLED->value)
            ->where(function ($q) use ($startTime, $endTime) {
                // Interval intersection: another appointment starts before our end time
                // AND ends after our start time.
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        // Return true if NO overlapping appointments are found
        return !$query->exists();
    }
}

<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\Service;
use Exception;

class AppointmentObserver
{
    /**
     * Handle the Appointment "creating" event.
     *
     * @param Appointment $appointment
     * @throws Exception
     */
    public function creating(Appointment $appointment): void
    {
        // 1. Calculate end_time if it's not set
        if (!$appointment->end_time && $appointment->start_time && $appointment->service_id) {
            $service = Service::find($appointment->service_id);
            if ($service) {
                $appointment->end_time = (clone $appointment->start_time)->addMinutes($service->duration_minutes);
            }
        }

        // 2. Strict double-booking prevention (only if times are set)
        if ($appointment->start_time && $appointment->end_time) {
            if (!Appointment::isSlotAvailable($appointment->stylist_id, $appointment->start_time, $appointment->end_time)) {
                throw new Exception("This time slot is no longer available. The stylist is already booked.");
            }
        }
    }

    /**
     * Handle the Appointment "updating" event.
     *
     * @param Appointment $appointment
     * @throws Exception
     */
    public function updating(Appointment $appointment): void
    {
        // Recalculate end_time if start_time or service_id changes
        if ($appointment->isDirty(['start_time', 'service_id']) && $appointment->start_time && $appointment->service_id) {
            $service = Service::find($appointment->service_id);
            if ($service) {
                $appointment->end_time = (clone $appointment->start_time)->addMinutes($service->duration_minutes);
            }
        }

        // Check availability if times or stylist change
        if ($appointment->isDirty(['start_time', 'end_time', 'stylist_id', 'status']) && $appointment->start_time && $appointment->end_time) {
            // Only validate if not transitioning to cancelled status
            if ($appointment->status->value !== \App\Enums\AppointmentStatus::CANCELLED->value) {
                if (!Appointment::isSlotAvailable(
                    $appointment->stylist_id,
                    $appointment->start_time,
                    $appointment->end_time,
                    $appointment->id
                )) {
                    throw new Exception("This time slot is no longer available. The stylist is already booked.");
                }
            }
        }
    }
}

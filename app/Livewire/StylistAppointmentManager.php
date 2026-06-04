<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StylistAppointmentManager extends Component
{
    public $activeTab = 'pending'; // pending, upcoming, past
    
    // For assigning time
    public $assigningAppointmentId = null;
    public $selectedTimeSlot = null;

    public function getPendingAppointmentsProperty()
    {
        return Appointment::with(['client', 'service'])
            ->where('stylist_id', Auth::id())
            ->where('status', AppointmentStatus::PENDING->value)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getUpcomingAppointmentsProperty()
    {
        return Appointment::with(['client', 'service'])
            ->where('stylist_id', Auth::id())
            ->where('status', AppointmentStatus::CONFIRMED->value)
            ->where('start_time', '>=', now()->startOfDay())
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function getPastAppointmentsProperty()
    {
        return Appointment::with(['client', 'service'])
            ->where('stylist_id', Auth::id())
            ->where(function ($query) {
                $query->where('start_time', '<', now()->startOfDay())
                      ->orWhereIn('status', [
                          AppointmentStatus::COMPLETED->value, 
                          AppointmentStatus::CANCELLED->value, 
                          AppointmentStatus::NO_SHOW->value
                      ]);
            })
            ->orderBy('start_time', 'desc')
            ->get();
    }

    public function startAssigningTime($appointmentId)
    {
        $this->assigningAppointmentId = $appointmentId;
        $this->selectedTimeSlot = null;
    }

    public function cancelAssigning()
    {
        $this->assigningAppointmentId = null;
        $this->selectedTimeSlot = null;
    }

    public function getAvailableTimeSlotsFor($appointmentId)
    {
        $appointment = Appointment::with('service')->find($appointmentId);
        if (!$appointment || !$appointment->notes) return [];

        // Parse date from "Preferred Date: 2026-06-05"
        preg_match('/Preferred Date: (\d{4}-\d{2}-\d{2})/', $appointment->notes, $matches);
        if (empty($matches[1])) return [];
        $date = $matches[1];

        $service = $appointment->service;
        $dateObj = Carbon::parse($date);
        $dayOfWeek = $dateObj->dayOfWeek; // 0 (Sunday) - 6 (Saturday)

        $availabilities = Availability::where('stylist_id', Auth::id())
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        $slots = [];
        $intervalMinutes = 30;

        foreach ($availabilities as $avail) {
            $start = Carbon::parse($date . ' ' . $avail->start_time);
            $end = Carbon::parse($date . ' ' . $avail->end_time);

            while ($start->copy()->addMinutes($service->duration_minutes)->lte($end)) {
                $slotStart = $start->copy();
                $slotEnd = $start->copy()->addMinutes($service->duration_minutes);

                // Check if slot is available
                if (Appointment::isSlotAvailable(Auth::id(), $slotStart, $slotEnd, $appointment->id)) {
                    $slots[] = $slotStart->format('H:i');
                }

                $start->addMinutes($intervalMinutes);
            }
        }

        return $slots;
    }

    public function confirmTimeSlot()
    {
        $this->validate([
            'selectedTimeSlot' => 'required',
        ]);

        $appointment = Appointment::with('service')->find($this->assigningAppointmentId);
        if (!$appointment || !$appointment->notes) return;

        preg_match('/Preferred Date: (\d{4}-\d{2}-\d{2})/', $appointment->notes, $matches);
        if (empty($matches[1])) return;
        $date = $matches[1];

        $startTime = Carbon::parse($date . ' ' . $this->selectedTimeSlot);
        $endTime = $startTime->copy()->addMinutes($appointment->service->duration_minutes);

        $appointment->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => AppointmentStatus::CONFIRMED->value,
            'notes' => null, // Clear out the preferred date string if desired, or keep it. Let's clear it.
        ]);

        $this->assigningAppointmentId = null;
        $this->selectedTimeSlot = null;
    }

    public function render()
    {
        return view('livewire.stylist-appointment-manager');
    }
}

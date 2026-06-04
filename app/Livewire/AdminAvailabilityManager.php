<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Models\Availability;
use App\Models\User;
use Livewire\Component;

class AdminAvailabilityManager extends Component
{
    public $stylistId = null;
    public $availabilities = [];

    // The days of the week we manage
    public $days = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    public function getStylistsProperty()
    {
        return User::where('role', UserRole::STYLIST->value)->orderBy('name')->get();
    }

    public function updatedStylistId()
    {
        $this->loadAvailabilities();
    }

    public function loadAvailabilities()
    {
        if (!$this->stylistId) {
            $this->availabilities = [];
            return;
        }

        $existing = Availability::where('stylist_id', $this->stylistId)
            ->get()
            ->keyBy('day_of_week')
            ->toArray();

        $this->availabilities = [];
        foreach ($this->days as $index => $name) {
            if (isset($existing[$index])) {
                $this->availabilities[$index] = [
                    'id' => $existing[$index]['id'],
                    'start_time' => substr($existing[$index]['start_time'], 0, 5), // "09:00:00" -> "09:00"
                    'end_time' => substr($existing[$index]['end_time'], 0, 5),
                    'is_active' => (bool) $existing[$index]['is_active'],
                ];
            } else {
                $this->availabilities[$index] = [
                    'id' => null,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'is_active' => false, // Default to off
                ];
            }
        }
    }

    public function saveSchedule()
    {
        $this->validate([
            'stylistId' => 'required|exists:users,id',
            'availabilities.*.start_time' => 'required',
            'availabilities.*.end_time' => 'required',
            'availabilities.*.is_active' => 'boolean',
        ]);

        foreach ($this->availabilities as $dayOfWeek => $data) {
            Availability::updateOrCreate(
                [
                    'stylist_id' => $this->stylistId,
                    'day_of_week' => $dayOfWeek,
                ],
                [
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'is_active' => $data['is_active'],
                ]
            );
        }

        session()->flash('message', 'Stylist schedule updated successfully.');
        $this->loadAvailabilities();
    }

    public function render()
    {
        return view('livewire.admin-availability-manager');
    }
}

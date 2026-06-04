<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingWizard extends Component
{
    public int $currentStep = 1;

    // Booking State
    public ?int $serviceId = null;
    public ?int $stylistId = null;
    public ?string $date = null;
    public ?string $timeSlot = null;
    
    // Guest State
    public string $guestName = '';
    public string $guestEmail = '';
    public string $guestPhone = '';

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->guestName = $user->name;
            $this->guestEmail = $user->email;
            $this->guestPhone = $user->phone ?? '';
        }
        $this->date = now()->toDateString();
    }

    public function getSelectedServiceProperty()
    {
        return $this->serviceId ? Service::find($this->serviceId) : null;
    }

    public function getSelectedStylistProperty()
    {
        return $this->stylistId ? User::find($this->stylistId) : null;
    }

    // Removing isHairService check since all services now require time slots.
    // public function getIsHairServiceProperty() ...

    public function selectService($id)
    {
        $this->serviceId = $id;
        $this->stylistId = null;
        $this->timeSlot = null;
        $this->nextStep();
    }

    public function selectStylist($id)
    {
        $this->stylistId = $id;
        $this->timeSlot = null;
        $this->nextStep();
    }

    public function nextStep()
    {
        if ($this->currentStep === 3) {
            $this->validateStep3();
        }
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    private function validateStep3()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'timeSlot' => 'required',
        ]);
    }

    public function getAvailableTimeSlotsProperty()
    {
        if (!$this->stylistId || !$this->date) {
            return [];
        }

        $service = $this->selectedService;
        if (!$service) return [];

        $dateObj = Carbon::parse($this->date);
        $dayOfWeek = $dateObj->dayOfWeek; // 0 (Sunday) - 6 (Saturday)

        $availabilities = Availability::where('stylist_id', $this->stylistId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        $slots = [];
        $intervalMinutes = 30; // 30 min slots as requested

        foreach ($availabilities as $avail) {
            $start = Carbon::parse($this->date . ' ' . $avail->start_time);
            $end = Carbon::parse($this->date . ' ' . $avail->end_time);

            while ($start->copy()->addMinutes($service->duration_minutes)->lte($end)) {
                $slotStart = $start->copy();
                $slotEnd = $start->copy()->addMinutes($service->duration_minutes);

                // Check if slot is available
                if (Appointment::isSlotAvailable($this->stylistId, $slotStart, $slotEnd)) {
                    $slots[] = $slotStart->format('H:i');
                }

                $start->addMinutes($intervalMinutes);
            }
        }

        return $slots;
    }

    public function confirmBooking()
    {
        if (!Auth::check()) {
            $this->validate([
                'guestName' => 'required|string|max:255',
                'guestEmail' => 'required|email|max:255',
                'guestPhone' => 'required|string|max:20',
            ]);
            
            $client = User::firstOrCreate(
                ['email' => $this->guestEmail],
                [
                    'name' => $this->guestName,
                    'phone' => $this->guestPhone,
                    'role' => \App\Enums\UserRole::CLIENT->value,
                    'password' => Hash::make(Str::random(16)),
                ]
            );
        } else {
            $client = Auth::user();
        }

        $service = $this->selectedService;

        $status = AppointmentStatus::PENDING->value;
        $startTime = null;
        $endTime = null;

        // All services now require a time slot picked by the customer
        if ($this->timeSlot) {
            $startTime = Carbon::parse($this->date . ' ' . $this->timeSlot);
            $endTime = $startTime->copy()->addMinutes($service->duration_minutes);
            $status = AppointmentStatus::PENDING->value;
            $notes = null; // Time is locked in
        }

        // Verify the slot is still available (prevent double booking)
        if ($startTime && $endTime) {
            if (!Appointment::isSlotAvailable($this->stylistId, $startTime, $endTime)) {
                $this->addError('timeSlot', 'This time slot has just been booked by someone else. Please choose another.');
                $this->currentStep = 3; // Send them back to time slot selection
                return;
            }
        }

        $appointment = Appointment::create([
            'client_id' => $client->id,
            'stylist_id' => $this->stylistId,
            'service_id' => $this->serviceId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
            'notes' => $notes,
        ]);

        return redirect()->route('booking.confirmation', ['id' => $appointment->id]);
    }

    public function render()
    {
        return view('livewire.booking-wizard', [
            'servicesGrouped' => Service::where('is_active', true)->orderBy('sort_order')->get()->groupBy(fn($s) => $s->category->value),
            'stylists' => $this->serviceId ? $this->selectedService->stylists : [],
        ]);
    }
}

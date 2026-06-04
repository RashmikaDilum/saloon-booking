<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AdminOverview extends Component
{
    public $filter = 'all'; // today, week, month, all

    public function getMetricsProperty()
    {
        $query = Appointment::query();

        // Apply date filter for metrics
        if ($this->filter === 'today') {
            $query->whereDate('start_time', Carbon::today());
        } elseif ($this->filter === 'week') {
            $query->whereBetween('start_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->filter === 'month') {
            $query->whereMonth('start_time', Carbon::now()->month)
                  ->whereYear('start_time', Carbon::now()->year);
        }

        $appointments = clone $query;
        $totalAppointments = $appointments->count();
        
        $confirmedAppointments = clone $query;
        $confirmedCount = $confirmedAppointments->where('status', AppointmentStatus::CONFIRMED->value)->count();

        // Calculate Revenue (Sum of service prices for confirmed/completed appointments)
        // We need to join services or load them
        $revenueQuery = clone $query;
        $revenue = $revenueQuery->whereIn('status', [AppointmentStatus::CONFIRMED->value, AppointmentStatus::COMPLETED->value])
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        // Pending requests don't necessarily have a start_time (null or placeholder). 
        // We'll just count ALL pending globally regardless of the date filter, because they need attention.
        $totalPending = Appointment::where('status', AppointmentStatus::PENDING->value)->count();

        return [
            'total_appointments' => $totalAppointments,
            'confirmed_count' => $confirmedCount,
            'revenue' => $revenue,
            'total_pending' => $totalPending,
        ];
    }

    public function getAppointmentsProperty()
    {
        $query = Appointment::with(['client', 'stylist', 'service']);

        if ($this->filter === 'today') {
            $query->where(function($q) {
                $q->whereDate('start_time', Carbon::today())
                  ->orWhere('status', AppointmentStatus::PENDING->value); // Always show pending
            });
        } elseif ($this->filter === 'week') {
            $query->where(function($q) {
                $q->whereBetween('start_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                  ->orWhere('status', AppointmentStatus::PENDING->value);
            });
        } elseif ($this->filter === 'month') {
            $query->where(function($q) {
                $q->whereMonth('start_time', Carbon::now()->month)
                  ->whereYear('start_time', Carbon::now()->year)
                  ->orWhere('status', AppointmentStatus::PENDING->value);
            });
        }

        return $query->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function approve($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->status = AppointmentStatus::CONFIRMED->value;
            $appointment->save();
        }
    }

    public function deny($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->status = AppointmentStatus::CANCELLED->value;
            $appointment->save();
        }
    }

    public function render()
    {
        return view('livewire.admin-overview', [
            'metrics' => $this->metrics,
            'appointments' => $this->appointments,
        ]);
    }
}

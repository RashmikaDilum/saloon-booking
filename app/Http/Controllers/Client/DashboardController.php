<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $pendingAppointments = $user->clientAppointments()
            ->with(['stylist', 'service'])
            ->where('status', \App\Enums\AppointmentStatus::PENDING->value)
            ->orderBy('created_at', 'desc')
            ->get();

        $upcomingAppointments = $user->clientAppointments()
            ->with(['stylist', 'service'])
            ->where('status', \App\Enums\AppointmentStatus::CONFIRMED->value)
            ->where('start_time', '>=', now()->startOfDay())
            ->orderBy('start_time', 'asc')
            ->get();

        $pastAppointments = $user->clientAppointments()
            ->with(['stylist', 'service'])
            ->where(function ($query) {
                $query->where('start_time', '<', now()->startOfDay())
                      ->orWhereIn('status', [
                          \App\Enums\AppointmentStatus::COMPLETED->value, 
                          \App\Enums\AppointmentStatus::CANCELLED->value, 
                          \App\Enums\AppointmentStatus::NO_SHOW->value
                      ]);
            })
            ->orderBy('start_time', 'desc')
            ->get();

        return view('client.dashboard', compact('pendingAppointments', 'upcomingAppointments', 'pastAppointments'));
    }
}

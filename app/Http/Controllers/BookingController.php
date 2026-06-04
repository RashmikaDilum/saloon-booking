<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function store(Request $request)
    {
        // Placeholder for booking submission
        return redirect()->route('booking.confirmation', ['appointment' => 1]);
    }

    public function confirmation(int $id)
    {
        return view('booking.confirmation', compact('id'));
    }
}

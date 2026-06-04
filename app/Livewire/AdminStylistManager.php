<?php

namespace App\Livewire;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminStylistManager extends Component
{
    public $name;
    public $email;
    public $phone;
    public $bio;
    public $password;
    public $selectedServices = [];

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'password' => 'required|min:8',
            'selectedServices' => 'array',
        ]);

        $stylist = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'password' => Hash::make($this->password),
            'role' => UserRole::STYLIST->value,
        ]);

        if (!empty($this->selectedServices)) {
            $stylist->services()->sync($this->selectedServices);
        }

        // Create default availability (Mon-Fri, 9am - 5pm)
        for ($day = 1; $day <= 5; $day++) {
            \App\Models\Availability::create([
                'stylist_id' => $stylist->id,
                'day_of_week' => $day,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'is_active' => true,
            ]);
        }

        $this->reset(['name', 'email', 'phone', 'bio', 'password', 'selectedServices']);
    }

    public function delete($id)
    {
        $stylist = User::find($id);
        if ($stylist && $stylist->role === UserRole::STYLIST) {
            // Soft delete to preserve historical appointments
            $stylist->delete();
        }
    }

    public function render()
    {
        return view('livewire.admin-stylist-manager', [
            'stylists' => User::where('role', UserRole::STYLIST->value)->get(),
            'services' => \App\Models\Service::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}

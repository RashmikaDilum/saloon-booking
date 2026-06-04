<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'email', 'password', 'role', 'phone', 'avatar', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Get the appointments booked by this user as a client.
     */
    public function clientAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    /**
     * Get the appointments assigned to this user as a stylist.
     */
    public function stylistAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'stylist_id');
    }

    /**
     * Get the availabilities for this user as a stylist.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class, 'stylist_id');
    }

    /**
     * Get the services that this stylist is qualified to perform.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'stylist_service', 'stylist_id', 'service_id');
    }

    /**
     * Role checking helpers
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isStylist(): bool
    {
        return $this->role === UserRole::STYLIST;
    }

    public function isClient(): bool
    {
        return $this->role === UserRole::CLIENT;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['stylist_id', 'day_of_week', 'start_time', 'end_time', 'is_active'])]
class Availability extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the stylist who owns this availability record.
     */
    public function stylist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}

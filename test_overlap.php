<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$slotStart = \Carbon\Carbon::parse('2026-06-02 13:30:00');
$slotEnd = \Carbon\Carbon::parse('2026-06-02 14:00:00');

// Assuming stylist ID is 1 or something else? Let's see stylist ID for Appointment 2.
$a = \App\Models\Appointment::find(2);
echo "Stylist ID: " . $a->stylist_id . "\n";

$isAvailable = \App\Models\Appointment::isSlotAvailable($a->stylist_id, $slotStart, $slotEnd);
echo "Is slot available? " . ($isAvailable ? 'Yes' : 'No') . "\n";

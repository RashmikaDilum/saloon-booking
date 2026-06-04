<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$stylistId = 1;
$startTime = \Carbon\Carbon::parse('2026-06-05 09:00:00');
$endTime = \Carbon\Carbon::parse('2026-06-05 09:30:00');

$query = \App\Models\Appointment::where('stylist_id', $stylistId)
    ->where('status', '!=', 'cancelled')
    ->where(function ($q) use ($startTime, $endTime) {
        $q->where('start_time', '<', $endTime)
          ->where('end_time', '>', $startTime);
    });

echo $query->toSql() . "\n";
print_r($query->getBindings());

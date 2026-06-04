<div>
    <!-- Metrics Section -->
    <div class="mb-8 flex justify-between items-center">
        <h3 class="font-serif text-2xl text-charcoal-900">Salon Performance</h3>
        <select wire:model.live="filter" class="border-cream-200 focus:border-charcoal-900 focus:ring-0 text-sm bg-cream-100 p-2">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="all">All Time</option>
        </select>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Revenue -->
        <div class="bg-cream-100 border border-cream-200 p-6 shadow-sm">
            <h4 class="text-xs tracking-widest uppercase text-charcoal-700 mb-2">Est. Revenue</h4>
            <p class="font-serif text-3xl text-charcoal-900">${{ number_format($metrics['revenue'], 2) }}</p>
        </div>
        
        <!-- Total Appointments -->
        <div class="bg-cream-100 border border-cream-200 p-6 shadow-sm">
            <h4 class="text-xs tracking-widest uppercase text-charcoal-700 mb-2">Appointments</h4>
            <p class="font-serif text-3xl text-charcoal-900">{{ $metrics['total_appointments'] }}</p>
        </div>

        <!-- Confirmed -->
        <div class="bg-cream-100 border border-cream-200 p-6 shadow-sm">
            <h4 class="text-xs tracking-widest uppercase text-charcoal-700 mb-2">Confirmed</h4>
            <p class="font-serif text-3xl text-green-700">{{ $metrics['confirmed_count'] }}</p>
        </div>

        <!-- Action Required -->
        <div class="bg-cream-100 border border-cream-200 p-6 shadow-sm {{ $metrics['total_pending'] > 0 ? 'border-l-4 border-l-red-500' : '' }}">
            <h4 class="text-xs tracking-widest uppercase text-charcoal-700 mb-2">Pending Requests</h4>
            <p class="font-serif text-3xl {{ $metrics['total_pending'] > 0 ? 'text-red-600' : 'text-charcoal-900' }}">{{ $metrics['total_pending'] }}</p>
        </div>
    </div>

    <!-- Master Appointment List -->
    <h3 class="font-serif text-2xl text-charcoal-900 mb-6 border-b border-cream-200 pb-2">Master Schedule</h3>
    
    <div class="bg-cream-100 border border-cream-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left text-sm text-charcoal-900">
            <thead class="bg-cream-50 text-xs tracking-widest uppercase text-charcoal-700 border-b border-cream-200">
                <tr>
                    <th class="px-6 py-4 font-medium">Date & Time</th>
                    <th class="px-6 py-4 font-medium">Client</th>
                    <th class="px-6 py-4 font-medium">Service</th>
                    <th class="px-6 py-4 font-medium">Stylist</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream-200">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-cream-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($appointment->start_time)
                                <span class="block font-medium">{{ $appointment->start_time->format('M j, Y') }}</span>
                                <span class="text-xs text-charcoal-700">{{ $appointment->start_time->format('g:i A') }}</span>
                            @else
                                <span class="italic text-charcoal-700">TBD</span>
                                @if($appointment->notes)
                                    <span class="block text-xs text-charcoal-700">{{ $appointment->notes }}</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="block font-medium">{{ $appointment->client->name }}</span>
                            <span class="text-xs text-charcoal-700">{{ $appointment->client->phone ?? $appointment->client->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $appointment->service->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $appointment->stylist->name }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClass = match($appointment->status->value) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-cream-100 text-cream-900'
                                };
                            @endphp
                            <span class="inline-block px-2 py-1 {{ $statusClass }} text-xs tracking-wider uppercase font-medium rounded-full">
                                {{ ucfirst($appointment->status->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($appointment->status->value === 'pending')
                                <div class="flex gap-2">
                                    <button wire:click="approve({{ $appointment->id }})" class="px-3 py-1 bg-green-700 text-white text-xs tracking-wider uppercase hover:bg-green-600 transition-colors">
                                        Accept
                                    </button>
                                    <button wire:click="deny({{ $appointment->id }})" class="px-3 py-1 bg-red-600 text-white text-xs tracking-wider uppercase hover:bg-red-500 transition-colors">
                                        Denied
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-charcoal-700">
                            No appointments found for this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div>
    <!-- Tabs -->
    <div class="border-b border-cream-200 mb-8 flex space-x-8">
        <button wire:click="$set('activeTab', 'pending')" class="pb-4 font-serif text-lg transition-colors {{ $activeTab === 'pending' ? 'text-charcoal-900 border-b-2 border-charcoal-900' : 'text-charcoal-700 hover:text-charcoal-900 border-transparent' }}">
            Pending Requests <span class="ml-2 text-xs bg-charcoal-900 text-cream-50 rounded-full px-2 py-0.5">{{ count($this->pendingAppointments) }}</span>
        </button>
        <button wire:click="$set('activeTab', 'upcoming')" class="pb-4 font-serif text-lg transition-colors {{ $activeTab === 'upcoming' ? 'text-charcoal-900 border-b-2 border-charcoal-900' : 'text-charcoal-700 hover:text-charcoal-900 border-transparent' }}">
            Upcoming Schedule
        </button>
        <button wire:click="$set('activeTab', 'past')" class="pb-4 font-serif text-lg transition-colors {{ $activeTab === 'past' ? 'text-charcoal-900 border-b-2 border-charcoal-900' : 'text-charcoal-700 hover:text-charcoal-900 border-transparent' }}">
            Past Appointments
        </button>
    </div>

    <!-- Tab Content -->
    <div>
        @if($activeTab === 'pending')
            <div class="space-y-6">
                @forelse($this->pendingAppointments as $appointment)
                    <div class="bg-cream-100 border border-cream-200 p-6 flex flex-col md:flex-row md:items-center justify-between shadow-sm">
                        <div class="mb-4 md:mb-0">
                            <h4 class="font-serif text-xl text-charcoal-900">{{ $appointment->service->name }}</h4>
                            <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-charcoal-900">Client:</span> {{ $appointment->client->name }} ({{ $appointment->client->phone ?? $appointment->client->email }})</p>
                            @if($appointment->notes)
                                <p class="text-sm text-charcoal-700 mt-1 italic">{{ $appointment->notes }}</p>
                            @endif
                        </div>
                        
                        <div>
                            @if($assigningAppointmentId === $appointment->id)
                                <div class="bg-cream-50 p-4 border border-cream-200 rounded-sm">
                                    <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-2">Assign Time Slot</label>
                                    @php
                                        $slots = $this->getAvailableTimeSlotsFor($appointment->id);
                                    @endphp
                                    
                                    @if(empty($slots))
                                        <p class="text-sm text-red-500 mb-4">No availability on the requested date.</p>
                                    @else
                                        <select wire:model="selectedTimeSlot" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-100 mb-4">
                                            <option value="">Select Time...</option>
                                            @foreach($slots as $slot)
                                                <option value="{{ $slot }}">{{ date('g:i A', strtotime($slot)) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    
                                    <div class="flex space-x-2">
                                        <button wire:click="confirmTimeSlot" class="px-4 py-2 bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 text-xs tracking-widest uppercase transition-colors" @if(empty($slots)) disabled @endif>
                                            Confirm
                                        </button>
                                        <button wire:click="cancelAssigning" class="px-4 py-2 border border-charcoal-900 text-charcoal-900 hover:bg-cream-100 text-xs tracking-widest uppercase transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button wire:click="startAssigningTime({{ $appointment->id }})" class="px-6 py-2 border border-charcoal-900 text-charcoal-900 hover:bg-charcoal-900 hover:text-cream-50 transition-colors uppercase tracking-widest text-sm font-medium">
                                    Assign Time
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-charcoal-700">
                        No pending appointment requests.
                    </div>
                @endforelse
            </div>
        @endif

        @if($activeTab === 'upcoming')
            <div class="space-y-6">
                @forelse($this->upcomingAppointments as $appointment)
                    <div class="bg-cream-100 border border-cream-200 p-6 flex flex-col md:flex-row justify-between shadow-sm">
                        <div>
                            <div class="text-sm font-medium tracking-widest uppercase text-charcoal-700 mb-2">
                                {{ $appointment->start_time->format('F j, Y') }} &bull; {{ $appointment->start_time->format('g:i A') }} - {{ $appointment->end_time->format('g:i A') }}
                            </div>
                            <h4 class="font-serif text-xl text-charcoal-900">{{ $appointment->service->name }}</h4>
                            <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-charcoal-900">Client:</span> {{ $appointment->client->name }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 self-start">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs tracking-widest uppercase font-medium rounded-full">
                                {{ ucfirst($appointment->status->value) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-charcoal-700">
                        No upcoming appointments scheduled.
                    </div>
                @endforelse
            </div>
        @endif

        @if($activeTab === 'past')
            <div class="space-y-6">
                @forelse($this->pastAppointments as $appointment)
                    <div class="bg-cream-50 border border-cream-200 p-6 flex flex-col md:flex-row justify-between opacity-75 shadow-sm">
                        <div>
                            <div class="text-sm font-medium tracking-widest uppercase text-charcoal-700 mb-2">
                                @if($appointment->start_time)
                                    {{ $appointment->start_time->format('F j, Y') }} &bull; {{ $appointment->start_time->format('g:i A') }}
                                @else
                                    Unknown Date
                                @endif
                            </div>
                            <h4 class="font-serif text-xl text-charcoal-900">{{ $appointment->service->name }}</h4>
                            <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-charcoal-900">Client:</span> {{ $appointment->client->name }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 self-start">
                            <span class="inline-block px-3 py-1 bg-gray-200 text-gray-800 text-xs tracking-widest uppercase font-medium rounded-full">
                                {{ ucfirst($appointment->status->value) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-charcoal-700">
                        No past appointments.
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>

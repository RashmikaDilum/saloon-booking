<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-cream-900 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cream-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Pending Appointments -->
            @if($pendingAppointments->count() > 0)
                <section>
                    <h3 class="font-serif text-2xl text-cream-900 mb-6 border-b border-cream-200 pb-2">Pending Requests</h3>
                    <div class="space-y-4">
                        @foreach($pendingAppointments as $appointment)
                            <div class="bg-cream-100 border border-cream-200 p-6 flex flex-col md:flex-row justify-between shadow-sm border-l-4 border-l-charcoal-900">
                                <div>
                                    <h4 class="font-serif text-xl text-cream-900">{{ $appointment->service->name }}</h4>
                                    <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-cream-900">Stylist:</span> {{ $appointment->stylist->name }}</p>
                                    @if($appointment->notes)
                                        <p class="text-sm text-charcoal-700 mt-1 italic">{{ $appointment->notes }}</p>
                                    @endif
                                </div>
                                <div class="mt-4 md:mt-0 self-start text-right">
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs tracking-widest uppercase font-medium rounded-full mb-2">
                                        Pending
                                    </span>
                                    <p class="text-xs text-charcoal-700">Awaiting Stylist Confirmation</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Upcoming Appointments -->
            <section>
                <h3 class="font-serif text-2xl text-cream-900 mb-6 border-b border-cream-200 pb-2">Upcoming Appointments</h3>
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="bg-cream-100 border border-cream-200 p-6 flex flex-col md:flex-row justify-between shadow-sm border-l-4 border-l-green-600">
                                <div>
                                    <div class="text-sm font-medium tracking-widest uppercase text-charcoal-700 mb-2">
                                        {{ $appointment->start_time->format('F j, Y') }} &bull; {{ $appointment->start_time->format('g:i A') }}
                                    </div>
                                    <h4 class="font-serif text-xl text-cream-900">{{ $appointment->service->name }}</h4>
                                    <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-cream-900">Stylist:</span> {{ $appointment->stylist->name }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 self-start">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs tracking-widest uppercase font-medium rounded-full">
                                        Confirmed
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-cream-100 p-8 text-center text-charcoal-700">
                        You have no upcoming appointments. <br>
                        <a href="{{ route('booking.index') }}" class="inline-block mt-4 text-cream-900 font-medium underline underline-offset-4 hover:text-charcoal-700">Book a new appointment</a>
                    </div>
                @endif
            </section>

            <!-- Past Appointments -->
            @if($pastAppointments->count() > 0)
                <section>
                    <h3 class="font-serif text-2xl text-cream-900 mb-6 border-b border-cream-200 pb-2">Past Appointments</h3>
                    <div class="space-y-4">
                        @foreach($pastAppointments as $appointment)
                            <div class="bg-cream-50 border border-cream-200 p-6 flex flex-col md:flex-row justify-between shadow-sm opacity-75">
                                <div>
                                    <div class="text-sm font-medium tracking-widest uppercase text-charcoal-700 mb-2">
                                        {{ $appointment->start_time ? $appointment->start_time->format('F j, Y') : 'Unknown Date' }}
                                    </div>
                                    <h4 class="font-serif text-xl text-cream-900">{{ $appointment->service->name }}</h4>
                                    <p class="text-sm text-charcoal-700 mt-1"><span class="font-medium text-cream-900">Stylist:</span> {{ $appointment->stylist->name }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 self-start">
                                    <span class="inline-block px-3 py-1 bg-gray-200 text-gray-800 text-xs tracking-widest uppercase font-medium rounded-full">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </div>
</x-app-layout>

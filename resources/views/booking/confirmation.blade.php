<x-layout>
    <x-slot name="title">Booking Confirmed — Saloon Saheli</x-slot>

    @php
        $appointment = \App\Models\Appointment::with(['service', 'stylist'])->findOrFail($id);
    @endphp

    <div class="bg-cream-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full bg-cream-100 p-8 md:p-12 shadow-sm border border-cream-200 text-center">
            <div class="w-16 h-16 mx-auto bg-charcoal-900 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-3xl font-serif text-charcoal-900 mb-4">
                @if($appointment->status->value === 'pending')
                    Request Submitted
                @else
                    Booking Confirmed
                @endif
            </h1>
            
            <p class="text-charcoal-700 font-light mb-8">
                @if($appointment->status->value === 'pending')
                    Thank you for your request! Your stylist will review it and assign a time slot shortly. You will be notified once it is confirmed.
                @else
                    Thank you for choosing Saloon Saheli. Your appointment has been successfully scheduled. We look forward to seeing you.
                @endif
            </p>

            <div class="bg-cream-50 p-6 border border-cream-200 text-left mb-8">
                <div class="grid grid-cols-2 gap-y-4 text-charcoal-900">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-charcoal-700 block mb-1">Service</span>
                        <span class="font-serif text-lg">{{ $appointment->service->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs uppercase tracking-widest text-charcoal-700 block mb-1">Stylist</span>
                        <span class="font-serif text-lg">{{ $appointment->stylist->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs uppercase tracking-widest text-charcoal-700 block mb-1">Date</span>
                        <span class="font-serif text-lg">
                            {{ $appointment->start_time ? $appointment->start_time->format('F j, Y') : 'Pending Assignment' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs uppercase tracking-widest text-charcoal-700 block mb-1">Time</span>
                        <span class="font-serif text-lg">
                            {{ $appointment->start_time ? $appointment->start_time->format('g:i A') : 'Pending Assignment' }}
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="inline-block px-8 py-4 border border-charcoal-900 text-charcoal-900 hover:bg-charcoal-900 hover:text-cream-50 transition-colors duration-300 tracking-widest text-sm font-medium uppercase">
                Return to Home
            </a>
        </div>
    </div>
</x-layout>

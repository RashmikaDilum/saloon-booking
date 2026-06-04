<div class="max-w-5xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
    <!-- Premium Progress Indicator -->
    <div class="mb-16">
        <div class="flex justify-between items-center relative">
            <!-- Progress Line Background -->
            <div class="absolute left-0 top-1/2 w-full h-px bg-cream-200 -z-10"></div>
            
            <!-- Active Progress Line -->
            <div class="absolute left-0 top-1/2 h-px bg-charcoal-900 -z-10 transition-all duration-500 shadow-[0_0_8px_rgba(212,175,55,0.5)]" 
                 style="width: {{ ($currentStep - 1) * 33.33 }}%;"></div>
            
            @foreach([1 => 'Service', 2 => 'Stylist', 3 => 'Date & Time', 4 => 'Details'] as $step => $label)
                <div class="flex flex-col items-center bg-cream-50 px-4 relative">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-500 
                        {{ $currentStep === $step ? 'bg-charcoal-900 text-cream-50 shadow-[0_0_15px_rgba(212,175,55,0.6)] scale-110' : 
                          ($currentStep > $step ? 'bg-charcoal-900 text-cream-50 border border-charcoal-900' : 'bg-cream-100 text-charcoal-700 border border-cream-200') }}">
                        @if($currentStep > $step)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $step }}
                        @endif
                    </div>
                    <span class="absolute -bottom-8 text-xs font-medium tracking-widest uppercase whitespace-nowrap {{ $currentStep >= $step ? 'text-charcoal-900' : 'text-charcoal-700' }}">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Main Glassmorphism Container -->
    <div class="bg-cream-100/90 backdrop-blur-md p-8 md:p-14 shadow-2xl border border-cream-200 rounded-2xl relative overflow-hidden">
        <!-- Subtle ambient glow -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-charcoal-900/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Step 1: Select Service -->
        @if($currentStep === 1)
            <div class="animate-fade-in relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-serif text-charcoal-900 mb-3">Our Services</h2>
                    <p class="text-sm tracking-widest uppercase text-charcoal-700">Select an experience</p>
                </div>
                
                @foreach($servicesGrouped as $category => $services)
                    <div class="mb-12">
                        <div class="flex items-center gap-4 mb-8">
                            <h3 class="text-sm font-semibold tracking-widest uppercase text-charcoal-900">{{ ucfirst($category) }}</h3>
                            <div class="flex-grow h-px bg-gradient-to-r from-charcoal-900/50 to-transparent"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($services as $service)
                                <div wire:click="selectService({{ $service->id }})" 
                                     class="cursor-pointer border border-cream-200 bg-cream-50 rounded-xl p-6 hover:border-charcoal-900 hover:shadow-[0_0_20px_rgba(212,175,55,0.15)] hover:-translate-y-1 transition-all duration-300 group flex justify-between items-center relative overflow-hidden">
                                     <!-- Hover gradient sweep -->
                                     <div class="absolute inset-0 bg-gradient-to-r from-charcoal-900/0 via-charcoal-900/5 to-charcoal-900/0 opacity-0 group-hover:opacity-100 group-hover:translate-x-full duration-1000 transition-all pointer-events-none -translate-x-full"></div>
                                     
                                    <div class="pr-4 z-10">
                                        <h4 class="font-serif text-2xl text-cream-900 group-hover:text-charcoal-900 transition-colors">{{ $service->name }}</h4>
                                        <div class="flex items-center gap-3 mt-3">
                                            <span class="px-3 py-1 bg-cream-100 text-charcoal-900 text-xs tracking-widest uppercase rounded-full">{{ $service->duration_minutes }} min</span>
                                            <span class="text-lg text-charcoal-900 font-medium">LKR {{ number_format($service->price, 2) }}</span>
                                        </div>
                                        @if($service->description)
                                            <p class="text-sm text-charcoal-700 mt-3 font-light leading-relaxed">{{ $service->description }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="shrink-0 w-8 h-8 rounded-full border-2 border-cream-200 flex items-center justify-center group-hover:border-charcoal-900 transition-colors z-10">
                                        <div class="w-3 h-3 rounded-full bg-transparent group-hover:bg-charcoal-900 transition-colors"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Step 2: Select Stylist -->
        @if($currentStep === 2)
            <div class="animate-fade-in relative z-10">
                <div class="flex justify-between items-center mb-10">
                    <button type="button" wire:click="previousStep" class="text-xs tracking-widest uppercase text-charcoal-700 hover:text-charcoal-900 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </button>
                    <div class="text-center">
                        <h2 class="text-3xl font-serif text-charcoal-900">Choose a Stylist</h2>
                        @if($this->selectedService)
                            <p class="text-sm tracking-widest uppercase text-charcoal-700 mt-2">For {{ $this->selectedService->name }}</p>
                        @endif
                    </div>
                    <div class="w-20"></div> <!-- spacer -->
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($stylists as $stylist)
                        <div wire:click="selectStylist({{ $stylist->id }})" 
                             class="cursor-pointer border border-cream-200 bg-cream-50 rounded-xl p-8 text-center hover:border-charcoal-900 hover:shadow-[0_0_20px_rgba(212,175,55,0.15)] hover:-translate-y-1 transition-all duration-300 group">
                            
                            <div class="w-28 h-28 mx-auto bg-cream-200 rounded-full mb-6 p-1 border-2 border-transparent group-hover:border-charcoal-900 transition-colors duration-300">
                                <div class="w-full h-full rounded-full overflow-hidden">
                                    @if($stylist->avatar)
                                        <img src="{{ Storage::url($stylist->avatar) }}" alt="{{ $stylist->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-charcoal-700 bg-cream-100 font-serif text-3xl">
                                            {{ substr($stylist->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <h4 class="font-serif text-2xl text-cream-900 group-hover:text-charcoal-900 transition-colors">{{ $stylist->name }}</h4>
                            @if($stylist->bio)
                                <p class="text-sm text-charcoal-700 mt-3 font-light line-clamp-2 leading-relaxed">{{ $stylist->bio }}</p>
                            @endif
                            
                            <div class="mt-6 inline-block px-6 py-2 border border-cream-200 rounded-full group-hover:bg-charcoal-900 group-hover:text-cream-50 group-hover:border-charcoal-900 text-xs tracking-widest uppercase transition-all duration-300">
                                Select
                            </div>
                        </div>
                    @endforeach
                    
                    @if(count($stylists) === 0)
                        <div class="col-span-full text-center py-16 px-4 border border-cream-200 rounded-xl bg-cream-50">
                            <p class="text-charcoal-700 font-serif text-xl">No stylists are currently available for this service.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Step 3: Select Date & Time -->
        @if($currentStep === 3)
            <div class="animate-fade-in relative z-10">
                <div class="flex justify-between items-center mb-10">
                    <button type="button" wire:click="previousStep" class="text-xs tracking-widest uppercase text-charcoal-700 hover:text-charcoal-900 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </button>
                    <h2 class="text-3xl font-serif text-charcoal-900">Date & Time</h2>
                    <div class="w-20"></div> <!-- spacer -->
                </div>

                <div class="max-w-2xl mx-auto">
                    <div class="mb-10">
                        <label class="block text-xs font-semibold tracking-widest uppercase text-charcoal-900 mb-3">Preferred Date</label>
                        <div class="relative" x-data x-init="flatpickr($refs.datePicker, { minDate: 'today', dateFormat: 'Y-m-d', defaultDate: '{{ $date }}', onChange: function(selectedDates, dateStr) { $wire.set('date', dateStr) } })">
                            <input type="text" x-ref="datePicker" 
                                   class="w-full border border-cream-200 rounded-xl focus:border-charcoal-900 focus:ring-1 focus:ring-charcoal-900 p-4 font-sans text-lg text-cream-900 bg-cream-50 transition-all shadow-sm cursor-pointer"
                                   placeholder="Select a date" readonly>
                        </div>
                        @error('date') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-10">
                        <label class="block text-xs font-semibold tracking-widest uppercase text-charcoal-900 mb-4 flex items-center gap-2">
                            Available Time Slots
                            <span wire:loading wire:target="date" class="inline-block w-4 h-4 border-2 border-charcoal-900 border-t-transparent rounded-full animate-spin"></span>
                        </label>
                        
                        @if(empty($this->availableTimeSlots))
                            <div class="bg-cream-50 p-8 rounded-xl text-center border border-cream-200">
                                <p class="text-charcoal-700 font-serif text-lg">No available slots on this date.</p>
                                <p class="text-sm text-charcoal-700 mt-2">Please select another date from the calendar above.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                                @foreach($this->availableTimeSlots as $slot)
                                    <button type="button" wire:click="$set('timeSlot', '{{ $slot }}')" 
                                            class="py-3 px-2 rounded-lg border transition-all duration-300 text-sm font-medium 
                                            {{ $timeSlot === $slot ? 'bg-charcoal-900 text-cream-50 border-charcoal-900 shadow-[0_4px_10px_rgba(212,175,55,0.3)] -translate-y-0.5' : 'bg-cream-50 text-cream-900 border-cream-200 hover:border-charcoal-900 hover:text-charcoal-900' }}">
                                        {{ date('g:i A', strtotime($slot)) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('timeSlot') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        @endif
                    </div>

                    <div class="mt-12">
                        <button type="button" wire:click="nextStep" class="w-full py-4 rounded-xl bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 transition-all duration-300 shadow-[0_4px_15px_rgba(212,175,55,0.2)] hover:shadow-[0_6px_20px_rgba(212,175,55,0.4)] uppercase tracking-widest text-sm font-bold flex items-center justify-center gap-2">
                            Continue to Details
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 4: Details & Confirm -->
        @if($currentStep === 4)
            <div class="animate-fade-in relative z-10">
                <div class="flex justify-between items-center mb-10">
                    <button type="button" wire:click="previousStep" class="text-xs tracking-widest uppercase text-charcoal-700 hover:text-charcoal-900 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </button>
                    <h2 class="text-3xl font-serif text-charcoal-900">Final Confirmation</h2>
                    <div class="w-20"></div> <!-- spacer -->
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
                    
                    <!-- Guest Details Form -->
                    <div class="lg:col-span-3 order-2 lg:order-1">
                        <div class="bg-cream-50 p-8 rounded-2xl border border-cream-200">
                            <h3 class="flex items-center gap-3 text-sm font-semibold tracking-widest uppercase text-charcoal-900 mb-8">
                                <svg class="w-5 h-5 text-charcoal-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Your Information
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-charcoal-700 mb-2">Full Name</label>
                                    <input type="text" wire:model="guestName" class="w-full border-cream-200 rounded-lg focus:border-charcoal-900 focus:ring-1 focus:ring-charcoal-900 p-3 bg-white" @if(Auth::check()) readonly @endif>
                                    @error('guestName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-charcoal-700 mb-2">Email Address</label>
                                    <input type="email" wire:model="guestEmail" class="w-full border-cream-200 rounded-lg focus:border-charcoal-900 focus:ring-1 focus:ring-charcoal-900 p-3 bg-white" @if(Auth::check()) readonly @endif>
                                    @error('guestEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-charcoal-700 mb-2">Phone Number</label>
                                    <input type="tel" wire:model="guestPhone" class="w-full border-cream-200 rounded-lg focus:border-charcoal-900 focus:ring-1 focus:ring-charcoal-900 p-3 bg-white" placeholder="+1 (555) 000-0000">
                                    @error('guestPhone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Summary Card -->
                    <div class="lg:col-span-2 order-1 lg:order-2">
                        <div class="bg-charcoal-900 text-cream-50 p-8 rounded-2xl shadow-xl relative overflow-hidden">
                            <!-- Background pattern/glow -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-cream-50/10 rounded-full blur-2xl"></div>
                            
                            <h3 class="text-sm font-semibold tracking-widest uppercase text-cream-900 mb-6 border-b border-cream-50/20 pb-4 relative z-10">Booking Summary</h3>
                            
                            <div class="space-y-5 relative z-10">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-xs uppercase tracking-widest text-cream-900/70 block mb-1">Service</span>
                                        <span class="font-serif text-xl">{{ $this->selectedService->name ?? '' }}</span>
                                    </div>
                                    <span class="text-lg font-medium">LKR {{ number_format($this->selectedService->price ?? 0, 2) }}</span>
                                </div>
                                
                                <div>
                                    <span class="text-xs uppercase tracking-widest text-cream-900/70 block mb-1">Stylist</span>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-cream-50/20 overflow-hidden flex-shrink-0">
                                            @if($this->selectedStylist && $this->selectedStylist->avatar)
                                                <img src="{{ Storage::url($this->selectedStylist->avatar) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <span class="font-serif text-lg">{{ $this->selectedStylist->name ?? '' }}</span>
                                    </div>
                                </div>
                                
                                <div class="pt-2">
                                    <span class="text-xs uppercase tracking-widest text-cream-900/70 block mb-1">Date & Time</span>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-cream-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-serif text-lg">{{ date('M j, Y', strtotime($date)) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-cream-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @if($timeSlot)
                                            <span class="font-serif text-lg">{{ date('g:i A', strtotime($timeSlot)) }}</span>
                                        @else
                                            <span class="text-sm italic text-cream-900/80">Pending assignment</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="pt-6 border-t border-cream-50/20 mt-4 flex justify-between items-end">
                                    <span class="text-xs uppercase tracking-widest text-cream-900 block mb-1">Total Due Today</span>
                                    <span class="font-serif text-3xl font-bold text-charcoal-900 bg-clip-text text-transparent bg-gradient-to-r from-cream-900 to-cream-50">LKR {{ number_format($this->selectedService->price ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="button" wire:click="confirmBooking" class="w-full py-4 rounded-xl bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 border-2 border-charcoal-900 hover:border-charcoal-800 transition-all duration-300 shadow-[0_4px_15px_rgba(212,175,55,0.3)] hover:shadow-[0_8px_25px_rgba(212,175,55,0.5)] uppercase tracking-widest text-sm font-bold flex justify-center items-center gap-2" wire:loading.attr="disabled">
                                <span wire:loading.remove>Confirm Booking</span>
                                <span wire:loading>Processing...</span>
                                <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

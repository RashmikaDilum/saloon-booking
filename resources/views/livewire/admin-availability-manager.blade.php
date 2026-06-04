<div class="max-w-4xl mx-auto">
    <div class="bg-cream-100 border border-cream-200 p-8 shadow-sm">
        
        <div class="mb-8 border-b border-cream-200 pb-6">
            <label class="block text-sm font-medium tracking-widest uppercase text-charcoal-700 mb-2">Select a Stylist</label>
            <select wire:model.live="stylistId" class="w-full md:w-1/2 border-cream-200 focus:border-charcoal-900 focus:ring-0 p-3 text-lg bg-cream-50 font-serif">
                <option value="">-- Choose Stylist --</option>
                @foreach($this->stylists as $stylist)
                    <option value="{{ $stylist->id }}">{{ $stylist->name }}</option>
                @endforeach
            </select>
        </div>

        @if($stylistId)
            <div>
                <div class="flex justify-between items-end mb-6">
                    <h3 class="font-serif text-2xl text-charcoal-900">Weekly Schedule</h3>
                    @if (session()->has('message'))
                        <span class="text-green-600 text-sm font-medium">{{ session('message') }}</span>
                    @endif
                </div>
                
                <form wire:submit.prevent="saveSchedule">
                    <div class="space-y-4">
                        @foreach($days as $index => $dayName)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 {{ $availabilities[$index]['is_active'] ? 'bg-cream-50 border border-charcoal-900' : 'bg-gray-50 border border-cream-200 opacity-60' }} transition-colors">
                                
                                <div class="flex items-center mb-4 sm:mb-0 w-1/3">
                                    <input type="checkbox" id="day_{{ $index }}" wire:model.live="availabilities.{{ $index }}.is_active" class="w-5 h-5 border-cream-300 text-charcoal-900 focus:ring-charcoal-900 rounded-sm">
                                    <label for="day_{{ $index }}" class="ml-3 font-serif text-lg text-charcoal-900">{{ $dayName }}</label>
                                </div>

                                <div class="flex items-center space-x-4 w-full sm:w-2/3 justify-end">
                                    <div class="flex flex-col">
                                        <label class="text-xs uppercase tracking-widest text-charcoal-700 mb-1">Start Time</label>
                                        <input type="time" wire:model="availabilities.{{ $index }}.start_time" class="border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-100 w-32" {{ !$availabilities[$index]['is_active'] ? 'disabled' : '' }}>
                                    </div>
                                    <span class="mt-5 text-charcoal-500 font-serif">to</span>
                                    <div class="flex flex-col">
                                        <label class="text-xs uppercase tracking-widest text-charcoal-700 mb-1">End Time</label>
                                        <input type="time" wire:model="availabilities.{{ $index }}.end_time" class="border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-100 w-32" {{ !$availabilities[$index]['is_active'] ? 'disabled' : '' }}>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-right">
                        <button type="submit" class="px-8 py-3 bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 uppercase tracking-widest text-sm font-medium transition-colors">
                            Save Schedule
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center py-12 text-charcoal-700">
                Please select a stylist above to view and edit their schedule.
            </div>
        @endif

    </div>
</div>

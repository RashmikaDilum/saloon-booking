<x-layout>
    <x-slot:title>Services Menu — Saheli</x-slot:title>

    <!-- Header Section -->
    <section class="max-w-7xl mx-auto px-6 sm:px-8 pt-20 pb-12 border-b border-cream-200">
        <span class="text-xs tracking-[0.3em] uppercase text-cream-900 font-light block mb-4">The Selection</span>
        <h1 class="font-serif text-5xl sm:text-6xl text-cream-900 uppercase font-light tracking-wide">
            Curated Services
        </h1>
        <p class="mt-6 text-sm text-cream-900 max-w-xl font-light leading-relaxed">
            We focus on clean, precise methods and high-quality, clinical-grade botanical formulations. Explore our menu of bespoke treatments designed to enhance your natural beauty.
        </p>
    </section>

    <!-- Categorized Menu -->
    <section class="max-w-7xl mx-auto px-6 sm:px-8 py-20">
        <div class="space-y-24">
            @php
                // Group services by category value
                $grouped = $services->groupBy(fn($s) => $s->category->value);
                
                $categories = [
                    'hair' => 'Hair Styling & Sculpting',
                    'nails' => 'Minimalist Nail Artistry',
                    'skin' => 'Advanced Dermal Facials',
                    'brows' => 'Brow & Lash Definition',
                    'other' => 'Additional Offerings'
                ];
            @endphp

            @foreach($categories as $key => $title)
                @if(isset($grouped[$key]))
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 border-t border-cream-200 pt-12 first:border-t-0 first:pt-0">
                        
                        <!-- Category Header -->
                        <div>
                            <h2 class="font-serif text-3xl text-cream-900 uppercase font-light tracking-wide sticky top-28">
                                {{ $title }}
                            </h2>
                        </div>

                        <!-- Services List -->
                        <div class="lg:col-span-2 space-y-12">
                            @foreach($grouped[$key] as $service)
                                <div class="group flex flex-col justify-between border-b border-cream-200 pb-8 last:border-b-0 last:pb-0">
                                    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4">
                                        <h3 class="font-serif text-2xl text-cream-900 group-hover:text-charcoal-900 transition-colors duration-200">
                                            {{ $service->name }}
                                        </h3>
                                        <div class="flex items-center space-x-4 text-xs tracking-wider text-cream-900 uppercase font-light">
                                            <span>{{ $service->duration_minutes }} Mins</span>
                                            <span class="w-1.5 h-1.5 rounded-full bg-cream-900/40"></span>
                                            <span class="font-medium text-cream-900">LKR {{ number_format($service->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-xs text-cream-900 font-light leading-relaxed max-w-xl">
                                        {{ $service->description }}
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('booking.index') }}?service={{ $service->slug }}" class="inline-flex items-center text-[10px] tracking-[0.2em] uppercase font-light text-cream-900 hover:text-charcoal-900 transition-colors duration-200">
                                            Book This Treatment <span class="ml-2 font-sans text-xs transition-transform duration-200 group-hover:translate-x-1">→</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Bottom Call-To-Action -->
    <section class="bg-cream-100 border-t border-cream-200 py-24 text-center">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="font-serif text-4xl text-cream-900 uppercase font-light tracking-wide mb-6">
                Begin Your Experience
            </h2>
            <p class="text-xs text-cream-900 tracking-wider uppercase font-light mb-8 max-w-md mx-auto leading-relaxed">
                Connect with our artisans. Reserve a curated treatment space online.
            </p>
            <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-charcoal-900 text-xs tracking-[0.2em] uppercase font-light bg-charcoal-900 text-cream-100 hover:bg-transparent hover:text-charcoal-900 transition-all duration-300">
                Book An Appointment
            </a>
        </div>
    </section>
</x-layout>

<x-layout>
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-24 pb-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-cream-50">
        <!-- Background subtle accent -->
        <div class="absolute inset-0 z-0 bg-cream-100"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-charcoal-900/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-charcoal-800/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <span class="block uppercase tracking-widest text-xs font-semibold text-charcoal-700 mb-6 tracking-[0.3em]">Welcome to Saloon Saheli</span>
            <h1 class="text-5xl md:text-7xl font-serif text-charcoal-900 mb-8 leading-tight drop-shadow-lg">
                Refined Beauty, <br class="hidden md:block" /> Effortless Elegance
            </h1>
            <p class="text-lg md:text-xl font-light text-charcoal-900/80 mb-12 max-w-2xl mx-auto">
                A luxury sanctuary for editorial hair styling, bespoke nail art, and targeted clinical facials.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('booking.index') }}" class="w-full sm:w-auto px-8 py-4 bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 transition-all duration-300 shadow-[0_0_20px_rgba(212,175,55,0.3)] hover:shadow-[0_0_30px_rgba(212,175,55,0.5)] tracking-wider text-sm font-medium uppercase">
                    Book an Appointment
                </a>
                <a href="{{ route('services.index') }}" class="w-full sm:w-auto px-8 py-4 border border-charcoal-900 text-charcoal-900 hover:bg-charcoal-900 hover:text-cream-50 transition-colors duration-300 tracking-wider text-sm font-medium uppercase">
                    Explore Services
                </a>
            </div>
        </div>
    </section>

    <!-- Highlighted Services Section -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 bg-cream-100">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-serif text-charcoal-900 mb-4">Our Expertise</h2>
                <div class="w-16 h-px bg-charcoal-900 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Service 1 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-cream-200 mb-6 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&q=80&w=600" alt="Hair Styling" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700 ease-out" />
                        <div class="absolute inset-0 bg-charcoal-900/10 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <h3 class="text-xl font-serif text-charcoal-900 mb-2">Editorial Hair Styling</h3>
                    <p class="text-sm text-charcoal-700 font-light leading-relaxed">Modern, lived-in color and effortless cuts tailored to your natural texture.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-cream-200 mb-6 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&q=80&w=600" alt="Nail Art" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700 ease-out" />
                        <div class="absolute inset-0 bg-charcoal-900/10 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <h3 class="text-xl font-serif text-charcoal-900 mb-2">Minimalist Gel Art</h3>
                    <p class="text-sm text-charcoal-700 font-light leading-relaxed">Precision cuticle care and understated nail art using premium, non-toxic gels.</p>
                </div>

                <!-- Service 3 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-cream-200 mb-6 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?auto=format&fit=crop&q=80&w=600" alt="Facials" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700 ease-out" />
                        <div class="absolute inset-0 bg-charcoal-900/10 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <h3 class="text-xl font-serif text-charcoal-900 mb-2">Clinical Facials</h3>
                    <p class="text-sm text-charcoal-700 font-light leading-relaxed">Targeted treatments designed to restore radiance and optimize skin health.</p>
                </div>
            </div>
            
            <div class="text-center mt-16">
                <a href="{{ route('services.index') }}" class="inline-flex items-center text-sm font-medium tracking-widest uppercase text-charcoal-900 hover:text-charcoal-700 transition-colors">
                    View All Services
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Brand Philosophy -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 bg-cream-100">
        <div class="max-w-4xl mx-auto text-center">
            <span class="block uppercase tracking-widest text-xs font-semibold text-charcoal-700 mb-6">Our Philosophy</span>
            <h2 class="text-3xl md:text-4xl font-serif text-charcoal-900 mb-8 leading-relaxed">
                "We believe in enhancing your natural beauty, rather than masking it. Our approach is grounded in simplicity, precision, and an unwavering attention to detail."
            </h2>
            <div class="w-16 h-px bg-charcoal-900 mx-auto"></div>
        </div>
    </section>
</x-layout>

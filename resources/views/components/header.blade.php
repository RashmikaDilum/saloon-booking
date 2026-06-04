<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-cream-50/80 backdrop-blur-md border-b border-cream-200/60 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 h-20 flex items-center justify-between relative">
        
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/logo.jpg') }}" alt="Saheli Logo" class="h-12 w-auto object-contain rounded-md shadow-sm" style="height: 3rem; max-width: 100%;">
            <span class="font-serif text-2xl tracking-[0.25em] text-charcoal-900 uppercase font-light hidden sm:block">Saheli</span>
        </a>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-10 text-xs tracking-[0.2em] uppercase font-light text-charcoal-700">
            <a href="{{ route('home') }}" class="hover:text-charcoal-900 transition-colors duration-200">Home</a>
            <a href="{{ route('services.index') }}" class="hover:text-charcoal-900 transition-colors duration-200">Services</a>
            <a href="{{ route('gallery') }}" class="hover:text-charcoal-900 transition-colors duration-200">Gallery</a>
            <a href="/#about" class="hover:text-charcoal-900 transition-colors duration-200">About</a>
            <a href="/#stylists" class="hover:text-charcoal-900 transition-colors duration-200">Stylists</a>
        </nav>

        <!-- CTAs & Auth -->
        <div class="flex items-center space-x-6">
            @auth
                <a href="{{ route('dashboard') }}" class="text-xs tracking-[0.2em] uppercase font-light text-charcoal-700 hover:text-charcoal-900 transition-colors duration-200">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs tracking-[0.2em] uppercase font-light text-charcoal-700 hover:text-charcoal-900 transition-colors duration-200">
                        Logout
                    </button>
                </form>
            @else
                <!-- Sign In intentionally hidden for public users -->
            @endauth
            
            <a href="{{ route('booking.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 border border-charcoal-900 text-xs tracking-[0.2em] uppercase font-light bg-charcoal-900 text-cream-50 hover:bg-transparent hover:text-charcoal-900 transition-all duration-300">
                Book Now
            </a>
            
            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-charcoal-900 hover:text-charcoal-700 focus:outline-none">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden absolute top-20 left-0 w-full bg-cream-50 border-b border-cream-200 shadow-xl"
         @click.away="mobileMenuOpen = false">
        <nav class="flex flex-col py-4 px-6 space-y-4 text-xs tracking-[0.2em] uppercase font-light text-charcoal-900">
            <a href="{{ route('home') }}" class="py-2 border-b border-cream-200/50 hover:text-charcoal-700">Home</a>
            <a href="{{ route('services.index') }}" class="py-2 border-b border-cream-200/50 hover:text-charcoal-700">Services</a>
            <a href="{{ route('gallery') }}" class="py-2 border-b border-cream-200/50 hover:text-charcoal-700">Gallery</a>
            <a href="/#about" class="py-2 border-b border-cream-200/50 hover:text-charcoal-700">About</a>
            <a href="/#stylists" class="py-2 border-b border-cream-200/50 hover:text-charcoal-700">Stylists</a>
            
            <a href="{{ route('booking.index') }}" class="mt-4 block text-center py-3 border border-charcoal-900 bg-charcoal-900 text-cream-50 hover:bg-transparent hover:text-charcoal-900 transition-all duration-300">
                Book Now
            </a>
        </nav>
    </div>
</header>

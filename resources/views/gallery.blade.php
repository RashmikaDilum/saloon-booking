<x-layout>
    <x-slot:title>Gallery — Saloon Saheli</x-slot:title>

    <div class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 bg-cream-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-serif text-charcoal-900 mb-4">Our Gallery</h1>
                <div class="w-16 h-px bg-charcoal-900 mx-auto mb-6"></div>
                <p class="text-lg text-charcoal-700 font-light max-w-2xl mx-auto">
                    A curated collection of our finest work.
                </p>
            </div>

            @if($images->isEmpty())
                <div class="text-center py-20">
                    <p class="text-charcoal-700 font-light text-lg">Our gallery is currently being updated. Check back soon for inspiring looks.</p>
                </div>
            @else
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach($images as $image)
                        <div class="break-inside-avoid overflow-hidden shadow-sm group">
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->title }}" class="w-full object-cover hover:scale-105 transition-transform duration-700 ease-out">
                            @if($image->title)
                                <div class="mt-2 mb-4 text-center">
                                    <span class="text-sm font-medium text-charcoal-900 tracking-wider uppercase">{{ $image->title }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layout>

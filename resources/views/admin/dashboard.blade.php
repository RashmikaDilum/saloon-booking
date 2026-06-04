<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-cream-900 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cream-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:admin-overview />
        </div>
    </div>
</x-app-layout>

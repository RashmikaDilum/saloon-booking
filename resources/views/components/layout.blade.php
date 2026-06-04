<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Saheli — High-End Minimalist Salon' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Saloon Saheli offers modern editorial hair styling, minimalist gel nail art, and targeted clinical facials in a serene, luxury environment.' }}">

    <!-- Google Fonts: Cormorant Garamond (Serif) & Inter (Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Flatpickr (Calendar Date Picker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-cream-50 text-charcoal-900 font-sans antialiased min-h-screen flex flex-col selection:bg-charcoal-900 selection:text-cream-50">

    <!-- Header Navigation -->
    <x-header />

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>

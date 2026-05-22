@php($isRtl = app()->getLocale() === 'ar')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo
            :title="$seoTitle ?? null"
            :description="$seoDescription ?? null"
            :canonical="$seoCanonical ?? null"
            :og-type="$seoOgType ?? 'website'"
            :og-image="$seoOgImage ?? null"
            :json-ld="$seoJsonLd ?? null"
        />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased {{ $isRtl ? 'rtl' : '' }}">
        <div class="min-h-screen bg-slate-50">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white/80 backdrop-blur-md border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-100 bg-white/50 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p class="text-center text-sm text-gray-400">&copy; {{ date('Y') }} EventFlow. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>

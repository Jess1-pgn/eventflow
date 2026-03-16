<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo :title="$seoTitle ?? null" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left: Branding panel -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="400" cy="400" r="300" stroke="white" stroke-width="0.5" fill="none" />
                        <circle cx="400" cy="400" r="200" stroke="white" stroke-width="0.5" fill="none" />
                        <circle cx="400" cy="400" r="100" stroke="white" stroke-width="0.5" fill="none" />
                    </svg>
                </div>
                <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-white">EventFlow</span>
                    </div>
                    <h2 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-6">
                        Create unforgettable<br>experiences
                    </h2>
                    <p class="text-indigo-100 text-lg leading-relaxed max-w-md">
                        Manage events, sell tickets, and connect with your audience — all in one modern platform.
                    </p>
                </div>
            </div>

            <!-- Right: Form panel -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 sm:px-12 bg-slate-50">
                <div class="w-full max-w-md">
                    <div class="lg:hidden flex justify-center mb-8">
                        <x-application-logo />
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                        {{ $slot }}
                    </div>
                    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} EventFlow</p>
                </div>
            </div>
        </div>
    </body>
</html>

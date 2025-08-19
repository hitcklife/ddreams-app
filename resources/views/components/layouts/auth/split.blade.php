<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
                <!-- Trucking Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-emerald-900"></div>
                <div class="absolute inset-0 opacity-20 bg-cover bg-center bg-no-repeat" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik01MCAyMDBIMzUwTTUwIDIwMEw3MCAyMDBNNzAgMjAwSDMzME0zMzAgMjAwTDM1MCAyMDBNNTAgMjAwVjE4ME01MCAyMDBWMjIwTTM1MCAyMDBWMTgwTTM1MCAyMDBWMjIwTTcwIDIwMFYxODBNNzAgMjAwVjIyME0zMzAgMjAwVjE4ME0zMzAgMjAwVjIyMCIgc3Ryb2tlPSIjRkY3MDQzIiBzdHJva2Utd2lkdGg9IjQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L3N2Zz4K')"></div>
                
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-xl font-bold" wire:navigate>
                    DDreams
                </a>

                <!-- Trucking Content -->
                <div class="relative z-20 mt-auto">
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M5 11V9a4 4 0 014-4h6a4 4 0 014 4v2"></path>
                                </svg>
                            </div>
                        </div>
                        <blockquote class="space-y-4">
                            <h2 class="text-3xl font-bold text-white">Your Journey Starts Here</h2>
                            <p class="text-xl text-gray-200 leading-relaxed">
                                Join thousands of drivers and businesses who trust DDreams for reliable, efficient trucking solutions across the nation.
                            </p>
                            <div class="flex flex-col space-y-3 mt-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                    <span class="text-gray-300">Professional fleet management</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                    <span class="text-gray-300">Real-time tracking & logistics</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                    <span class="text-gray-300">Nationwide shipping network</span>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="w-full lg:p-12">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[500px] lg:w-[600px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="text-xl font-bold text-black dark:text-white">DDreams</span>
                        <span class="sr-only">DDreams</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>

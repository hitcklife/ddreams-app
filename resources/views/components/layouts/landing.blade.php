
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Ddreams - Professional Trucking Services' }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out 0.3s both;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .nav-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
<!-- Enhanced Navigation -->
<nav class="bg-white/80 nav-blur shadow-lg border-b border-gray-100/50 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Enhanced Logo -->
            <div class="flex items-center group">
                <a href="/" class="flex items-center space-x-3 transform hover:scale-105 transition-all duration-300">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent">
                        Ddreams
                    </div>
                </a>
            </div>

            <!-- Enhanced Navigation Links -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="#home" class="relative px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-all duration-300 group">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-700 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#services" class="relative px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-all duration-300 group">
                    Services
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-700 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#about" class="relative px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-all duration-300 group">
                    About
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-700 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="relative px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-all duration-300 group">
                    Contact
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-700 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Enhanced Auth Links -->
            <div class="hidden md:flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group relative bg-gradient-to-r from-emerald-500 to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg overflow-hidden">
                            <span class="relative z-10">Dashboard</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-600 font-medium px-4 py-2 rounded-lg transition-all duration-300 hover:bg-emerald-50">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group relative bg-gradient-to-r from-emerald-500 to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg overflow-hidden">
                                <span class="relative z-10">Get Started</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Enhanced Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="p-2 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-300" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-4 pt-2 pb-4 space-y-1 bg-white/95 nav-blur border-t border-gray-100">
            <a href="#home" class="block px-4 py-3 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-300 font-medium">Home</a>
            <a href="#services" class="block px-4 py-3 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-300 font-medium">Services</a>
            <a href="#about" class="block px-4 py-3 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-300 font-medium">About</a>
            <a href="#contact" class="block px-4 py-3 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-300 font-medium">Contact</a>

            @if (Route::has('login'))
                <div class="pt-4 border-t border-gray-100 space-y-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block bg-gradient-to-r from-emerald-500 to-emerald-700 text-white px-4 py-3 rounded-lg text-center font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 px-4 py-3 rounded-lg font-medium">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-gradient-to-r from-emerald-500 to-emerald-700 text-white px-4 py-3 rounded-lg text-center font-semibold">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Main Content -->
<main>
    {{ $slot }}
</main>

<!-- Enhanced Footer -->
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-emerald-900 text-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-24 h-24 bg-emerald-500 rounded-full opacity-10 animate-pulse"></div>
    <div class="absolute bottom-40 right-20 w-16 h-16 bg-white rounded-full opacity-5 animate-bounce"></div>
    <div class="absolute top-40 right-10 w-20 h-20 bg-emerald-400 rounded-full opacity-10 animate-float"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Enhanced Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-6 group">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black bg-gradient-to-r from-emerald-300 to-emerald-500 bg-clip-text text-transparent">
                        Ddreams
                    </h3>
                </div>
                <p class="text-gray-300 text-lg leading-relaxed mb-8 max-w-md">
                    Your trusted partner for professional trucking and logistics services. We deliver excellence across the nation with reliability, innovation, and care.
                </p>

                <!-- Enhanced Social Links -->
                <div class="flex space-x-4">
                    <a href="#" class="group bg-white/10 backdrop-blur-sm p-3 rounded-xl text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/20 transition-all duration-300 transform hover:scale-110 border border-white/10">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>
                    <a href="#" class="group bg-white/10 backdrop-blur-sm p-3 rounded-xl text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/20 transition-all duration-300 transform hover:scale-110 border border-white/10">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.224.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.174.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="#" class="group bg-white/10 backdrop-blur-sm p-3 rounded-xl text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/20 transition-all duration-300 transform hover:scale-110 border border-white/10">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" class="group bg-white/10 backdrop-blur-sm p-3 rounded-xl text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/20 transition-all duration-300 transform hover:scale-110 border border-white/10">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.224.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.174.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Enhanced Services -->
            <div class="space-y-6">
                <h4 class="text-xl font-bold text-emerald-300 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                    Our Services
                </h4>
                <ul class="space-y-4">
                    <li>
                        <a href="#" class="group flex items-center text-gray-400 hover:text-emerald-300 transition-all duration-300">
                            <svg class="w-4 h-4 mr-3 text-emerald-500 group-hover:text-emerald-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Long Haul Transport
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-400 hover:text-emerald-300 transition-all duration-300">
                            <svg class="w-4 h-4 mr-3 text-emerald-500 group-hover:text-emerald-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Express Delivery
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-400 hover:text-emerald-300 transition-all duration-300">
                            <svg class="w-4 h-4 mr-3 text-emerald-500 group-hover:text-emerald-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Freight Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-400 hover:text-emerald-300 transition-all duration-300">
                            <svg class="w-4 h-4 mr-3 text-emerald-500 group-hover:text-emerald-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Warehousing Solutions
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Enhanced Contact Info -->
            <div class="space-y-6">
                <h4 class="text-xl font-bold text-emerald-300 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                    Contact Us
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center group hover:transform hover:scale-105 transition-all duration-300">
                        <div class="bg-emerald-500/20 p-2 rounded-lg mr-4 group-hover:bg-emerald-500/30 transition-colors">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-300 font-medium">info@ddreams.com</p>
                            <p class="text-gray-500 text-sm">24/7 Support</p>
                        </div>
                    </div>

                    <div class="flex items-center group hover:transform hover:scale-105 transition-all duration-300">
                        <div class="bg-emerald-500/20 p-2 rounded-lg mr-4 group-hover:bg-emerald-500/30 transition-colors">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-300 font-medium">(555) 123-4567</p>
                            <p class="text-gray-500 text-sm">Emergency Line</p>
                        </div>
                    </div>

                    <div class="flex items-start group hover:transform hover:scale-105 transition-all duration-300">
                        <div class="bg-emerald-500/20 p-2 rounded-lg mr-4 group-hover:bg-emerald-500/30 transition-colors">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-300 font-medium">123 Logistics Ave</p>
                            <p class="text-gray-500 text-sm">Transport City, TC 12345</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Newsletter Section -->
        <div class="bg-gradient-to-r from-emerald-500/20 to-emerald-700/20 backdrop-blur-sm rounded-2xl p-8 mb-12 border border-emerald-500/30">
            <div class="text-center mb-6">
                <h4 class="text-2xl font-bold text-emerald-300 mb-2">Stay Updated</h4>
                <p class="text-gray-300">Get the latest news and updates from Ddreams</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py

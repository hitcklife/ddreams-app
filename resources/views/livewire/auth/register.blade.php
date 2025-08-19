<div>
    <!-- Header Section -->
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-emerald-500 to-emerald-700 rounded-full mb-6 shadow-xl">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M5 11V9a4 4 0 014-4h6a4 4 0 014 4v2"></path>
        </svg>
    </div>
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Join Our Fleet</h1>
    <p class="text-lg text-gray-600 dark:text-gray-400">Start your trucking journey with DDreams</p>
</div>

<!-- Registration Card -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10 max-w-2xl mx-auto">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form wire:submit="register" class="space-y-8">
                <!-- Name Fields Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div class="space-y-3">
                        <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>First Name</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="first_name"
                                id="first_name"
                                type="text"
                                required
                                autofocus
                                autocomplete="given-name"
                                placeholder="Enter your first name"
                                class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg"
                            />
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-3">
                        <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Last Name</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="last_name"
                                id="last_name"
                                type="text"
                                required
                                autocomplete="family-name"
                                placeholder="Enter your last name"
                                class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="space-y-3">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M5 11V9a4 4 0 014-4h6a4 4 0 014 4v2"></path>
                            </svg>
                            <span>I am joining as a</span>
                        </div>
                    </label>
                    <div class="relative">
                        <select
                            wire:model="role"
                            id="role"
                            required
                            class="w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 appearance-none text-lg"
                        >
                            <option value="customer" class="py-3">🏢 Customer - Need Shipping Services</option>
                            <option value="driver" class="py-3">🚛 Driver - Ready to Haul</option>
                            <option value="staff" class="py-3">👨‍💼 Staff Member - Company Employee</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="space-y-3">
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            <span>Email Address</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            required
                            autocomplete="email"
                            placeholder="your.email@company.com"
                            class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg"
                        />
                    </div>
                </div>

                <!-- Password Fields Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-3">
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Password</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="password"
                                id="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Create a strong password"
                                class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg"
                            />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-3">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Confirm Password</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="password_confirmation"
                                id="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                                class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-bold py-5 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-xl text-lg"
                >
                    <div class="flex items-center justify-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M5 11V9a4 4 0 014-4h6a4 4 0 014 4v2"></path>
                        </svg>
                        <span>Join DDreams Fleet</span>
                    </div>
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-10 text-center">
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                By creating an account, you agree to our 
                <a href="{{ route('terms.conditions') }}" class="text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 font-medium">Terms & Conditions</a> 
                and 
                <a href="{{ route('privacy.policy') }}" class="text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 font-medium">Privacy Policy</a>
            </p>
        </div>
</div>
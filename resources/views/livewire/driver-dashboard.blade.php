<div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Driver Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back, {{ Auth::user()->full_name }}!</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-sm text-gray-600 dark:text-gray-400">Profile Completion</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $completionPercentage }}%</p>
            </div>
            <div class="w-16 h-16">
                <svg class="transform -rotate-90 w-16 h-16">
                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-gray-200 dark:text-gray-700"/>
                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" 
                            stroke-dasharray="{{ 2 * 3.14159 * 28 }}" 
                            stroke-dashoffset="{{ 2 * 3.14159 * 28 - ($completionPercentage / 100) * 2 * 3.14159 * 28 }}"
                            class="text-blue-600 dark:text-blue-400 transition-all duration-300"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Status -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Status</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        @if($isProfileComplete)
                            <span class="text-green-600 dark:text-green-400">✓ Complete</span>
                        @else
                            <span class="text-yellow-600 dark:text-yellow-400">⚠ Incomplete</span>
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('driver.profile') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                    {{ $isProfileComplete ? 'Update Profile' : 'Complete Profile' }} →
                </a>
            </div>
        </div>

        <!-- Application Status -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Application Status</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <span class="capitalize text-yellow-600 dark:text-yellow-400">{{ $driver->status }}</span>
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @if($driver->status === 'pending')
                    <p class="text-sm text-gray-600 dark:text-gray-400">Your application is under review</p>
                @elseif($driver->status === 'approved')
                    <p class="text-sm text-green-600 dark:text-green-400">You're approved to drive!</p>
                @endif
            </div>
        </div>

        <!-- Availability -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Availability</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        @if($driver->available_for_work)
                            <span class="text-green-600 dark:text-green-400">Available</span>
                        @else
                            <span class="text-red-600 dark:text-red-400">Unavailable</span>
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <button class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                    Toggle Availability →
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('driver.profile') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Update Profile</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Edit your information</p>
                </div>
            </a>

            <div class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">View Jobs</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Available assignments</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Earnings</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Track your income</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <svg class="w-8 h-8 text-orange-600 dark:text-orange-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Support</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Get help</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Information -->
    @if(!$isProfileComplete)
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h4 class="font-medium text-yellow-800 dark:text-yellow-200">Complete Your Profile</h4>
                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                    Please complete your driver profile to start receiving job assignments. You're {{ $completionPercentage }}% complete.
                </p>
                <a href="{{ route('driver.profile') }}" class="inline-block mt-2 text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:underline">
                    Complete Profile Now →
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity / Next Steps -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Next Steps</h3>
        <div class="space-y-3">
            @if(!$isProfileComplete)
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                    <span class="text-gray-600 dark:text-gray-400">Complete your driver profile</span>
                </div>
            @endif
            
            @if($driver->status === 'pending')
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                    <span class="text-gray-600 dark:text-gray-400">Wait for application approval</span>
                </div>
            @endif

            @if($driver->status === 'approved')
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                    <span class="text-gray-600 dark:text-gray-400">You can now accept job assignments</span>
                </div>
            @endif

            @if(!$driver->medical_cert_expiry || $driver->medical_cert_expiry->isPast())
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-red-400 rounded-full mr-3"></div>
                    <span class="text-gray-600 dark:text-gray-400">Update your medical certificate</span>
                </div>
            @endif

            @if(!$driver->license_expiry_date || $driver->license_expiry_date->diffInDays(now()) < 30)
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-red-400 rounded-full mr-3"></div>
                    <span class="text-gray-600 dark:text-gray-400">Renew your driver's license</span>
                </div>
            @endif
        </div>
    </div>
</div>
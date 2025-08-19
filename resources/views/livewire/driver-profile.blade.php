<div class="max-w-4xl mx-auto">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Driver Profile</h1>
            <span class="text-sm text-gray-600 dark:text-gray-400">Step {{ $currentStep }} of {{ $totalSteps }}</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="bg-blue-600 dark:bg-blue-400 h-2 rounded-full transition-all duration-300" 
                 style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            
            @if($currentStep === 1)
                <!-- Step 1: Personal Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date of Birth *
                            </label>
                            <input type="date" id="date_of_birth" wire:model="date_of_birth" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number *
                            </label>
                            <input type="tel" id="phone_number" wire:model="phone_number" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="(555) 123-4567">
                            @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                By providing your phone number, you consent to receive SMS updates. See our 
                                <a href="{{ route('privacy.policy') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 underline" target="_blank">Privacy Policy</a> 
                                and 
                                <a href="{{ route('terms.conditions') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 underline" target="_blank">Terms & Conditions</a> 
                                for details.
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Street Address *
                        </label>
                        <input type="text" id="address" wire:model="address" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="123 Main Street">
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                City *
                            </label>
                            <input type="text" id="city" wire:model="city" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                State *
                            </label>
                            <input type="text" id="state" wire:model="state" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ZIP Code *
                            </label>
                            <input type="text" id="zip_code" wire:model="zip_code" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('zip_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Emergency Contact Name
                            </label>
                            <input type="text" id="emergency_contact_name" wire:model="emergency_contact_name" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('emergency_contact_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Emergency Contact Phone
                            </label>
                            <input type="tel" id="emergency_contact_phone" wire:model="emergency_contact_phone" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('emergency_contact_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            @elseif($currentStep === 2)
                <!-- Step 2: License Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">License Information</h2>
                    
                    <!-- AI Scan vs Manual Toggle -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-medium text-blue-900 dark:text-blue-100">Smart CDL Scanner</h3>
                                <p class="text-sm text-blue-800 dark:text-blue-200">Upload your CDL image and let AI extract the information automatically</p>
                            </div>
                            <button type="button" wire:click="toggleInputMethod" 
                                    class="px-4 py-2 text-sm font-medium {{ $useAiScan ? 'text-blue-600 bg-white' : 'text-gray-600 bg-gray-100' }} border border-blue-300 rounded-md hover:bg-blue-50">
                                {{ $useAiScan ? 'Switch to Manual' : 'Use AI Scanner' }}
                            </button>
                        </div>

                        @if($useAiScan && !$showManualForm)
                            <!-- CDL Image Upload -->
                            <div class="space-y-4">
                                @if(!$cdlImage && empty($scanResults))
                                    <div class="border-2 border-dashed border-blue-300 dark:border-blue-600 rounded-lg p-6 text-center">
                                        <svg class="mx-auto h-12 w-12 text-blue-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-4">
                                            <label for="cdl-upload" class="cursor-pointer">
                                                <span class="mt-2 block text-sm font-medium text-blue-600 dark:text-blue-400">
                                                    Upload your CDL image
                                                </span>
                                                <input id="cdl-upload" type="file" wire:model="cdlImage" accept="image/*" class="sr-only">
                                            </label>
                                            <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 10MB</p>
                                        </div>
                                    </div>
                                    @error('cdlImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                @endif

                                @if($cdlImage && !$scanInProgress && empty($scanResults))
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">CDL image uploaded</p>
                                                <p class="text-xs text-gray-500">Ready to scan</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" wire:click="processCdlImage" 
                                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                Scan CDL
                                            </button>
                                            <button type="button" wire:click="clearCdlImage" 
                                                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if($scanInProgress)
                                    <div class="flex items-center justify-center p-8 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <div class="text-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Processing CDL image...</p>
                                            <p class="text-xs text-gray-500">This may take a few seconds</p>
                                        </div>
                                    </div>
                                @endif

                                @if($scanError)
                                    <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <div class="flex">
                                            <svg class="w-5 h-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Scan Error</h3>
                                                <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ $scanError }}</p>
                                                <button type="button" wire:click="rejectExtractedData" 
                                                        class="mt-2 text-sm font-medium text-red-800 dark:text-red-200 hover:underline">
                                                    Switch to manual entry
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($scanResults) && $scanResults['success'])
                                    <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div class="ml-3 flex-1">
                                                <h3 class="text-sm font-medium text-green-800 dark:text-green-200">CDL Scanned Successfully!</h3>
                                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                                    Confidence: {{ $scanResults['confidence'] ?? 0 }}% | 
                                                    Found {{ count($extractedData) }} pieces of information
                                                </p>
                                                
                                                @if(!empty($extractedData))
                                                    <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded border">
                                                        <h4 class="text-xs font-medium text-gray-900 dark:text-white mb-2">Extracted Information:</h4>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                                                            @foreach($extractedData as $key => $value)
                                                                @if(!empty($value))
                                                                    <div>
                                                                        <span class="font-medium text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                                        <span class="text-gray-900 dark:text-white">
                                                                            @if(is_array($value))
                                                                                {{ implode(', ', $value) }}
                                                                            @else
                                                                                {{ $value }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="mt-4 flex space-x-3">
                                                    <button type="button" wire:click="acceptExtractedData" 
                                                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                                        Accept & Continue
                                                    </button>
                                                    <button type="button" wire:click="rejectExtractedData" 
                                                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                                                        Edit Manually
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($showManualForm || !$useAiScan)
                        <!-- Manual License Information Form -->
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="license_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                License Number *
                            </label>
                            <input type="text" id="license_number" wire:model="license_number" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('license_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="license_class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                License Class *
                            </label>
                            <select id="license_class" wire:model="license_class" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select License Class</option>
                                <option value="CDL Class A">CDL Class A</option>
                                <option value="CDL Class B">CDL Class B</option>
                                <option value="CDL Class C">CDL Class C</option>
                                <option value="Regular License">Regular License</option>
                            </select>
                            @error('license_class') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="license_expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            License Expiry Date *
                        </label>
                        <input type="date" id="license_expiry_date" wire:model="license_expiry_date" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('license_expiry_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="medical_cert_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Medical Certificate Number
                            </label>
                            <input type="text" id="medical_cert_number" wire:model="medical_cert_number" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('medical_cert_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="medical_cert_expiry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Medical Certificate Expiry
                            </label>
                            <input type="date" id="medical_cert_expiry" wire:model="medical_cert_expiry" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('medical_cert_expiry') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="hazmat_certified" wire:model="hazmat_certified" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="hazmat_certified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                HAZMAT Certified
                            </label>
                        </div>

                        @if($hazmat_certified)
                        <div>
                            <label for="hazmat_expiry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                HAZMAT Expiry Date
                            </label>
                            <input type="date" id="hazmat_expiry" wire:model="hazmat_expiry" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('hazmat_expiry') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif
                    @endif
                </div>

            @elseif($currentStep === 3)
                <!-- Step 3: Experience & Qualifications -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Experience & Qualifications</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="years_experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Years of Driving Experience
                            </label>
                            <input type="number" id="years_experience" wire:model="years_experience" min="0" max="50"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('years_experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="preferred_vehicle_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Preferred Vehicle Type
                            </label>
                            <select id="preferred_vehicle_type" wire:model="preferred_vehicle_type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Vehicle Type</option>
                                <option value="Semi-Truck">Semi-Truck</option>
                                <option value="Box Truck">Box Truck</option>
                                <option value="Delivery Van">Delivery Van</option>
                                <option value="Flatbed">Flatbed</option>
                                <option value="Tanker">Tanker</option>
                                <option value="Refrigerated">Refrigerated</option>
                            </select>
                            @error('preferred_vehicle_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="previous_employers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Previous Employers (Optional)
                        </label>
                        <textarea id="previous_employers" wire:model="previous_employers" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="List your previous driving employers, including company names and dates of employment..."></textarea>
                        @error('previous_employers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

            @elseif($currentStep === 4)
                <!-- Step 4: Vehicle & Insurance Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Vehicle & Insurance Information</h2>
                    
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="owns_vehicle" wire:model.live="owns_vehicle" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="owns_vehicle" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            I own my own vehicle
                        </label>
                    </div>

                    @if($owns_vehicle)
                    <div class="space-y-6 border-l-4 border-blue-500 pl-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Vehicle Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="vehicle_make" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Vehicle Make
                                </label>
                                <input type="text" id="vehicle_make" wire:model="vehicle_make" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('vehicle_make') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="vehicle_model" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Vehicle Model
                                </label>
                                <input type="text" id="vehicle_model" wire:model="vehicle_model" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('vehicle_model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="vehicle_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Vehicle Year
                                </label>
                                <input type="number" id="vehicle_year" wire:model="vehicle_year" min="1900" max="{{ date('Y') + 1 }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('vehicle_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="vehicle_vin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    VIN Number
                                </label>
                                <input type="text" id="vehicle_vin" wire:model="vehicle_vin" maxlength="17"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('vehicle_vin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="vehicle_license_plate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    License Plate
                                </label>
                                <input type="text" id="vehicle_license_plate" wire:model="vehicle_license_plate" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('vehicle_license_plate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Insurance Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="insurance_company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Insurance Company
                                </label>
                                <input type="text" id="insurance_company" wire:model="insurance_company" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('insurance_company') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="insurance_policy_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Policy Number
                                </label>
                                <input type="text" id="insurance_policy_number" wire:model="insurance_policy_number" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('insurance_policy_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="insurance_expiry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Insurance Expiry Date
                            </label>
                            <input type="date" id="insurance_expiry" wire:model="insurance_expiry" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('insurance_expiry') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>

            @elseif($currentStep === 5)
                <!-- Step 5: Additional Information -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Additional Information</h2>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Additional Notes (Optional)
                        </label>
                        <textarea id="notes" wire:model="notes" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Any additional information you'd like to share..."></textarea>
                        @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h3 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Review Your Information</h3>
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            Please review all the information you've entered before submitting. You can go back to previous steps to make any changes.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="button" wire:click="previousStep" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $currentStep === 1 ? 'invisible' : '' }}">
                    Previous
                </button>

                <div class="flex space-x-3">
                    @if($currentStep < $totalSteps)
                        <button type="button" wire:click="nextStep" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Next Step
                        </button>
                    @else
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Save Profile
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
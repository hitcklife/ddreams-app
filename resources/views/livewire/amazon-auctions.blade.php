<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm">
        <!-- Header with Filter Button -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Amazon Live Auctions</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                        {{ count($auctions) }} auctions found
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button 
                        wire:click="loadAuctions" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
                        wire:loading.attr="disabled"
                    >
                        <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Refresh
                    </button>
                    <button 
                        wire:click="toggleFilters" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Panel -->
        @if($showFilters)
        <div class="border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg">
            <div class="p-8">
                <form wire:submit="applyFilters" class="space-y-8">
                    <!-- Search Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">Search Filters</h3>
                        </div>
                        
                        <!-- Type & Equipment Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Location Type -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Location Type
                                    <button type="button" class="text-zinc-400 hover:text-zinc-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 0a8 8 0 108 8 8 8 0 00-8-8zm0 14a1 1 0 111-1 1 1 0 01-1 1zm0-3.78a1 1 0 110-2A2.11 2.11 0 106 5.4a1 1 0 01-1.89-.67A4.11 4.11 0 118 10.22z"/>
                                        </svg>
                                    </button>
                                </label>
                                <div class="relative">
                                    <select wire:model="locationType" class="appearance-none block w-full px-4 py-3 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200">
                                        <option value="Node to Node">Node to Node</option>
                                        <option value="Door to Door">Door to Door</option>
                                        <option value="Door to Node">Door to Node</option>
                                        <option value="Node to Door">Node to Door</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipment Type -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Equipment Type
                                </label>
                                <div class="relative">
                                    <div class="block w-full px-4 py-3 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-600 text-zinc-900 dark:text-white shadow-sm">
                                        53' Trailer
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Selection -->
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-6 space-y-6">
                            <h4 class="text-lg font-medium text-zinc-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Route Selection
                            </h4>
                            
                            <!-- Origin -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <div class="lg:col-span-2 space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Origin City</label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            id="origin-search"
                                            wire:model="originCity"
                                            placeholder="Search city, state..."
                                            class="block w-full px-4 py-3 pl-10 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                        >
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Radius</label>
                                    <div class="relative">
                                        <select wire:model="originRadius" class="appearance-none block w-full px-4 py-3 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200">
                                            <option value="50">50 miles</option>
                                            <option value="100">100 miles</option>
                                            <option value="150">150 miles</option>
                                            <option value="200">200 miles</option>
                                            <option value="250">250 miles</option>
                                            <option value="300">300 miles</option>
                                            <option value="500">500 miles</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Destination -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <div class="lg:col-span-2 space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Destination City</label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            id="destination-search"
                                            wire:model="destinationCity"
                                            placeholder="Search city, state or type 'Anywhere'"
                                            class="block w-full px-4 py-3 pl-10 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                        >
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Radius</label>
                                    <div class="relative">
                                        <select wire:model="destinationRadius" class="appearance-none block w-full px-4 py-3 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" {{ $destinationCity === 'Anywhere' ? 'disabled' : '' }}>
                                            <option value="">Select radius</option>
                                            <option value="50">50 miles</option>
                                            <option value="100">100 miles</option>
                                            <option value="150">150 miles</option>
                                            <option value="200">200 miles</option>
                                            <option value="250">250 miles</option>
                                            <option value="300">300 miles</option>
                                            <option value="500">500 miles</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contract Date Range -->
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-6 space-y-4">
                            <h4 class="text-lg font-medium text-zinc-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Contract Period
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Start Date</label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            wire:model="contractStartDate"
                                            class="block w-full px-4 py-3 pr-10 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                        >
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">End Date</label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            wire:model="contractEndDate"
                                            class="block w-full px-4 py-3 pr-10 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                        >
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Show Bid Auctions Toggle -->
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Show contracts I have bid on</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="showBidAuctions" class="sr-only peer">
                                    <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-zinc-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-500 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-zinc-200 dark:border-zinc-600">
                        <button type="button" wire:click="resetFilters" class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3 bg-white dark:bg-zinc-700 border-2 border-zinc-300 dark:border-zinc-600 rounded-lg font-semibold text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-800 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Clear Filters
                        </button>
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-blue-700 hover:to-blue-800 active:from-blue-800 active:to-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Content Area -->
        <div class="p-6">
            @if($error)
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="text-red-800 dark:text-red-200">
                        {{ $error }}
                    </div>
                </div>
            @endif

            @if($loading)
                <div class="text-center py-12">
                    <svg class="animate-spin h-8 w-8 mx-auto text-blue-600 mb-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-zinc-600 dark:text-zinc-400">Loading auctions...</p>
                </div>
            @elseif(empty($auctions) && !$error)
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H8"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">No auctions found</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">Try adjusting your filters to see more results.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($auctions as $index => $auction)
                    @php
                        $auctionView = $auction['auctionView'];
                        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
                        $origin = $stops[0] ?? null;
                        $destination = $stops[1] ?? null;
                        $reservePrice = $auctionView['reservePrice'] ?? null;
                        $leadingBid = $auction['leadingBidPrice'] ?? null;
                        $eligibility = $auction['auctionEligibility'] ?? null;
                        $closingTime = $auctionView['closingTime'] ?? null;
                        $isEligible = $eligibility['isEligible'] ?? false;
                        $equipment = $auctionView['item']['supplyList'][0]['loadDetails']['equipmentType'] ?? 'N/A';
                        
                        // Check if user has bid on this auction
                        $userBid = $auction['biddersBid'] ?? null;
                        $hasUserBid = $userBid !== null;
                        $userBidAmount = $hasUserBid ? $userBid['bidAmount']['amount'] : null;
                        $isWinning = $hasUserBid && $leadingBid && $userBidAmount <= $leadingBid['amount'];
                        $leadingBidsCount = $auction['leadingBidsCount'] ?? 0;
                    @endphp
                    
                    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-zinc-700 dark:to-zinc-600 p-6 border-b border-zinc-200 dark:border-zinc-600">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                        Auction ID: {{ substr($auctionView['id'], 0, 8) }}...
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $auctionView['state'] === 'OPEN' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $auctionView['state'] }}
                                </span>
                            </div>
                            
                            <!-- Route Information -->
                            <div class="flex items-center gap-3 text-sm">
                                <div class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $origin['address']['city'] ?? 'N/A' }}, {{ $origin['address']['state'] ?? '' }}</span>
                                </div>
                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                <div class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $destination['address']['city'] ?? 'N/A' }}, {{ $destination['address']['state'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-4">
                            <!-- Price Information -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Reserve Price</p>
                                        <p class="text-2xl font-bold text-green-600">
                                            ${{ number_format($reservePrice['amount'] ?? 0) }}
                                            <span class="text-sm font-normal text-zinc-500">{{ $reservePrice['type'] ?? '' }}</span>
                                        </p>
                                    </div>
                                    @if($leadingBid && $leadingBid['amount'])
                                    <div class="text-right">
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Leading Bid
                                            @if($leadingBidsCount > 1)
                                                <span class="text-xs">({{ $leadingBidsCount }} bids)</span>
                                            @endif
                                        </p>
                                        <p class="text-xl font-semibold text-blue-600">
                                            ${{ number_format($leadingBid['amount']) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- User Bid Status -->
                                @if($hasUserBid)
                                <div class="bg-{{ $isWinning ? 'green' : 'red' }}-50 dark:bg-{{ $isWinning ? 'green' : 'red' }}-900/20 border border-{{ $isWinning ? 'green' : 'red' }}-200 dark:border-{{ $isWinning ? 'green' : 'red' }}-800 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-{{ $isWinning ? 'green' : 'red' }}-800 dark:text-{{ $isWinning ? 'green' : 'red' }}-200">
                                                @if($isWinning)
                                                    🏆 You're winning!
                                                @else
                                                    ⚠️ You're being outbid
                                                @endif
                                            </p>
                                            <p class="text-xs text-{{ $isWinning ? 'green' : 'red' }}-600 dark:text-{{ $isWinning ? 'green' : 'red' }}-400">
                                                Your bid: ${{ number_format($userBidAmount) }}
                                            </p>
                                        </div>
                                        @if(!$isWinning)
                                        <div class="text-right">
                                            <p class="text-xs text-red-600 dark:text-red-400">Need to bid lower than</p>
                                            <p class="text-sm font-semibold text-red-800 dark:text-red-200">${{ number_format($leadingBid['amount']) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Auction Details -->
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-zinc-600 dark:text-zinc-400">Equipment</p>
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $equipment === 'FIFTY_THREE_FOOT_TRUCK' ? '53\' Truck' : $equipment }}</p>
                                </div>
                                <div>
                                    <p class="text-zinc-600 dark:text-zinc-400">Closing Time</p>
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ $closingTime ? \Carbon\Carbon::createFromTimestamp($closingTime)->setTimezone(config('app.timezone'))->format('M j, g:i A') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-zinc-600 dark:text-zinc-400">Load Count</p>
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ $auctionView['item']['supplyList'][0]['loadDetails']['count'] ?? 'N/A' }} loads
                                    </p>
                                </div>
                                <div>
                                    <p class="text-zinc-600 dark:text-zinc-400">Program</p>
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ str_replace('_', ' ', $auctionView['item']['programEnum'] ?? 'N/A') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Eligibility Status -->
                            @if(!$isEligible)
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-red-800 dark:text-red-200">
                                        {{ str_replace('_', ' ', $eligibility['ineligibleReason'] ?? 'Not Eligible') }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Card Footer - Action Buttons -->
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 px-6 py-4 border-t border-zinc-200 dark:border-zinc-600">
                            <div class="flex gap-2">
                                <button 
                                    wire:click="openBidModal({{ $index }})"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ !$isEligible ? 'disabled' : '' }}
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    Bid
                                </button>
                                <button 
                                    wire:click="openAutoBidModal({{ $index }})"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ !$isEligible ? 'disabled' : '' }}
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Auto Bid
                                </button>
                                <button 
                                    wire:click="showDetails({{ $index }})"
                                    class="px-4 py-2 bg-zinc-100 dark:bg-zinc-600 border border-zinc-300 dark:border-zinc-500 rounded-lg font-semibold text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-500 transition-all duration-200"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Auction Details Modal -->
    @if($showDetailsModal && $selectedAuction)
    @php
        $auctionView = $selectedAuction['auctionView'];
        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
        $origin = $stops[0] ?? null;
        $destination = $stops[1] ?? null;
        $reservePrice = $auctionView['reservePrice'] ?? null;
        $leadingBid = $selectedAuction['leadingBidPrice'] ?? null;
        $eligibility = $selectedAuction['auctionEligibility'] ?? null;
        $isEligible = $eligibility['isEligible'] ?? false;
        $closingTime = $auctionView['closingTime'] ?? null;
        $equipment = $auctionView['item']['supplyList'][0]['loadDetails']['equipmentType'] ?? 'N/A';
        $loadCount = $auctionView['item']['supplyList'][0]['loadDetails']['count'] ?? 0;
        $programEnum = $auctionView['item']['programEnum'] ?? 'N/A';
        $contractStart = $auctionView['item']['contractPeriod']['start'] ?? null;
        $contractEnd = $auctionView['item']['contractPeriod']['end'] ?? null;
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeDetailsModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                    Auction Details
                                </h3>
                                <button 
                                    wire:click="closeDetailsModal"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Left Column -->
                                <div class="space-y-6">
                                    <!-- Auction ID and Status -->
                                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Auction Information</h4>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Auction ID:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $auctionView['id'] }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $auctionView['state'] === 'OPEN' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $auctionView['state'] }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Closing Time:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $closingTime ? \Carbon\Carbon::createFromTimestamp($closingTime)->setTimezone(config('app.timezone'))->format('M j, Y g:i A') : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Route Information -->
                                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Route Details</h4>
                                        <div class="space-y-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Origin</span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 ml-6">
                                                    {{ $origin['address']['street'] ?? '' }}<br>
                                                    {{ $origin['address']['city'] ?? 'N/A' }}, {{ $origin['address']['state'] ?? '' }} {{ $origin['address']['zip'] ?? '' }}
                                                </p>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Destination</span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 ml-6">
                                                    {{ $destination['address']['street'] ?? '' }}<br>
                                                    {{ $destination['address']['city'] ?? 'N/A' }}, {{ $destination['address']['state'] ?? '' }} {{ $destination['address']['zip'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="space-y-6">
                                    <!-- Pricing Information -->
                                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Pricing</h4>
                                        <div class="space-y-3">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Reserve Price:</span>
                                                <span class="text-xl font-bold text-green-600">
                                                    ${{ number_format($reservePrice['amount'] ?? 0) }}
                                                    <span class="text-sm font-normal text-gray-500">{{ $reservePrice['type'] ?? '' }}</span>
                                                </span>
                                            </div>
                                            @if($leadingBid && $leadingBid['amount'])
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Leading Bid:</span>
                                                <span class="text-lg font-semibold text-blue-600">
                                                    ${{ number_format($leadingBid['amount']) }}
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Load Details -->
                                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Load Information</h4>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Equipment Type:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $equipment === 'FIFTY_THREE_FOOT_TRUCK' ? '53\' Truck' : $equipment }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Load Count:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $loadCount }} loads</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Program:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ str_replace('_', ' ', $programEnum) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contract Period -->
                                    @if($contractStart || $contractEnd)
                                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Contract Period</h4>
                                        <div class="space-y-2">
                                            @if($contractStart)
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Start Date:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::createFromTimestamp($contractStart)->setTimezone(config('app.timezone'))->format('M j, Y') }}
                                                </span>
                                            </div>
                                            @endif
                                            @if($contractEnd)
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">End Date:</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::createFromTimestamp($contractEnd)->setTimezone(config('app.timezone'))->format('M j, Y') }}
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6">
                    <!-- Eligibility Warning -->
                    @if(!$isEligible)
                    <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="text-sm font-medium text-red-800 dark:text-red-200">
                                {{ str_replace('_', ' ', $eligibility['ineligibleReason'] ?? 'Not Eligible') }}
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button 
                            wire:click="openBidModal({{ $selectedAuctionIndex }})"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$isEligible ? 'disabled' : '' }}
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Place Bid
                        </button>
                        <button 
                            wire:click="openAutoBidModal({{ $selectedAuctionIndex }})"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$isEligible ? 'disabled' : '' }}
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Auto Bid
                        </button>
                        <button 
                            wire:click="closeDetailsModal"
                            type="button" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Bid Modal -->
    @if($showBidModal && $selectedAuction)
    @php
        $auctionView = $selectedAuction['auctionView'];
        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
        $origin = $stops[0] ?? null;
        $destination = $stops[1] ?? null;
        $reservePrice = $auctionView['reservePrice'] ?? null;
        $leadingBid = $selectedAuction['leadingBidPrice'] ?? null;
        $eligibility = $selectedAuction['auctionEligibility'] ?? null;
        $isEligible = $eligibility['isEligible'] ?? false;
        $closingTime = $auctionView['closingTime'] ?? null;
        
        // Calculate distance for per-mile display
        $originLat = $origin['address']['latitude'] ?? 0;
        $originLng = $origin['address']['longitude'] ?? 0;
        $destLat = $destination['address']['latitude'] ?? 0;
        $destLng = $destination['address']['longitude'] ?? 0;
        $distance = 0;
        
        if ($originLat && $originLng && $destLat && $destLng) {
            $earthRadius = 3959; // miles
            $dLat = deg2rad($destLat - $originLat);
            $dLon = deg2rad($destLng - $originLng);
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($originLat)) * cos(deg2rad($destLat)) * sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = round($earthRadius * $c);
        }
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="bid-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeBidModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit="submitBid">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl leading-6 font-bold text-gray-900 dark:text-white" id="bid-modal-title">
                                        Place Your Bid
                                    </h3>
                                    <button 
                                        type="button"
                                        wire:click="closeBidModal"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                    >
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Route Summary -->
                                <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4 mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Route Summary</h4>
                                        @if($distance > 0)
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($distance) }} miles</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $origin['address']['city'] ?? 'N/A' }}, {{ $origin['address']['state'] ?? '' }}</span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $destination['address']['city'] ?? 'N/A' }}, {{ $destination['address']['state'] ?? '' }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Pricing Context -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 space-y-3">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Reserve Price:</span>
                                                <span class="font-semibold text-green-600 ml-2">
                                                    ${{ number_format($reservePrice['amount'] ?? 0) }}
                                                </span>
                                            </div>
                                            @if($leadingBid && $leadingBid['amount'])
                                            <div>
                                                <span class="text-gray-600 dark:text-gray-400">Current Winning Bid:</span>
                                                <span class="font-semibold text-blue-600 ml-2">
                                                    ${{ number_format($leadingBid['amount']) }}
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <!-- User's current bid status if exists -->
                                        @php
                                            $selectedUserBid = $selectedAuction['biddersBid'] ?? null;
                                            $hasSelectedUserBid = $selectedUserBid !== null;
                                            $selectedUserBidAmount = $hasSelectedUserBid ? $selectedUserBid['bidAmount']['amount'] : null;
                                            $selectedIsWinning = $hasSelectedUserBid && $leadingBid && $selectedUserBidAmount <= $leadingBid['amount'];
                                        @endphp
                                        
                                        @if($hasSelectedUserBid)
                                        <div class="bg-{{ $selectedIsWinning ? 'green' : 'yellow' }}-50 dark:bg-{{ $selectedIsWinning ? 'green' : 'yellow' }}-900/20 border border-{{ $selectedIsWinning ? 'green' : 'yellow' }}-200 dark:border-{{ $selectedIsWinning ? 'green' : 'yellow' }}-800 rounded-lg p-3">
                                            <p class="text-sm font-medium text-{{ $selectedIsWinning ? 'green' : 'yellow' }}-800 dark:text-{{ $selectedIsWinning ? 'green' : 'yellow' }}-200">
                                                @if($selectedIsWinning)
                                                    🏆 Your current bid of ${{ number_format($selectedUserBidAmount) }} is winning!
                                                @else
                                                    ⚠️ Your current bid of ${{ number_format($selectedUserBidAmount) }} is being outbid
                                                @endif
                                            </p>
                                        </div>
                                        @endif
                                        
                                        <!-- Bidding info -->
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                                💡 <strong>Reverse Auction:</strong> Lower bids win! To win this auction, bid lower than ${{ number_format($leadingBid['amount'] ?? $reservePrice['amount'] ?? 0) }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bid Input -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="bid-amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Your Bid Amount
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-lg">$</span>
                                            </div>
                                            <input 
                                                type="number" 
                                                id="bid-amount"
                                                wire:model.live="bidAmount"
                                                step="0.01"
                                                min="0"
                                                placeholder="0.00"
                                                class="block w-full pl-8 pr-12 py-4 text-xl border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                            >
                                        </div>
                                    </div>
                                    
                                    <!-- Real-time Calculations -->
                                    @if($bidAmount && is_numeric($bidAmount) && $bidAmount > 0)
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @if($distance > 0 && $calculatedPerMile > 0)
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                    ${{ number_format($calculatedPerMile, 2) }}
                                                </div>
                                                <div class="text-sm text-blue-800 dark:text-blue-300">per mile</div>
                                            </div>
                                            @endif
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                    ${{ number_format($bidAmount) }}
                                                </div>
                                                <div class="text-sm text-green-800 dark:text-green-300">total bid</div>
                                            </div>
                                        </div>
                                        
                                        @if($distance > 0 && $bidAmount > 0)
                                        <div class="mt-4 pt-3 border-t border-blue-200 dark:border-blue-700">
                                            <div class="text-center text-sm text-blue-700 dark:text-blue-300">
                                                <strong>Calculation:</strong> ${{ number_format($bidAmount) }} (bid) ÷ {{ number_format($distance) }} (miles) = ${{ number_format($calculatedPerMile, 2) }} per mile
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Bidding warnings -->
                                        <div class="mt-3 text-center space-y-2">
                                            @if($reservePrice && $bidAmount > $reservePrice['amount'])
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                ❌ Above reserve price of ${{ number_format($reservePrice['amount']) }} - This bid won't be accepted
                                            </span>
                                            @endif
                                            
                                            @if($leadingBid && $bidAmount >= $leadingBid['amount'])
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                ⚠️ Higher than winning bid of ${{ number_format($leadingBid['amount']) }} - You need to bid lower to win
                                            </span>
                                            @endif
                                            
                                            @if($leadingBid && $bidAmount < $leadingBid['amount'] && (!$reservePrice || $bidAmount <= $reservePrice['amount']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                ✅ This bid would win the auction!
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$bidAmount || !is_numeric($bidAmount) || $bidAmount <= 0 ? 'disabled' : '' }}
                        >
                            Submit Bid
                        </button>
                        <button 
                            type="button"
                            wire:click="closeBidModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-zinc-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Auto-Bid Modal -->
    @if($showAutoBidModal && $selectedAuction)
    @php
        $auctionView = $selectedAuction['auctionView'];
        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
        $origin = $stops[0] ?? null;
        $destination = $stops[1] ?? null;
        $reservePrice = $auctionView['reservePrice'] ?? null;
        $leadingBid = $selectedAuction['leadingBidPrice'] ?? null;
        $eligibility = $selectedAuction['auctionEligibility'] ?? null;
        $isEligible = $eligibility['isEligible'] ?? false;
        $closingTime = $auctionView['closingTime'] ?? null;
        
        // Calculate distance for per-mile display
        $originLat = $origin['address']['latitude'] ?? 0;
        $originLng = $origin['address']['longitude'] ?? 0;
        $destLat = $destination['address']['latitude'] ?? 0;
        $destLng = $destination['address']['longitude'] ?? 0;
        $distance = 0;
        
        if ($originLat && $originLng && $destLat && $destLng) {
            $earthRadius = 3959; // miles
            $dLat = deg2rad($destLat - $originLat);
            $dLon = deg2rad($destLng - $originLng);
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($originLat)) * cos(deg2rad($destLat)) * sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = round($earthRadius * $c);
        }
        
        // User's current bid info
        $selectedUserBid = $selectedAuction['biddersBid'] ?? null;
        $hasSelectedUserBid = $selectedUserBid !== null;
        $selectedUserBidAmount = $hasSelectedUserBid ? $selectedUserBid['bidAmount']['amount'] : null;
        $selectedIsWinning = $hasSelectedUserBid && $leadingBid && $selectedUserBidAmount <= $leadingBid['amount'];
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="auto-bid-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeAutoBidModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit="setupAutoBid">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl leading-6 font-bold text-gray-900 dark:text-white" id="auto-bid-modal-title">
                                        ⚡ Setup Auto-Bid
                                    </h3>
                                    <button 
                                        type="button"
                                        wire:click="closeAutoBidModal"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                    >
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Route Summary -->
                                <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4 mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Auction Summary</h4>
                                        @if($distance > 0)
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($distance) }} miles</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 text-sm mb-4">
                                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $origin['address']['city'] ?? 'N/A' }}, {{ $origin['address']['state'] ?? '' }}</span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $destination['address']['city'] ?? 'N/A' }}, {{ $destination['address']['state'] ?? '' }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Current Auction Status -->
                                    <div class="grid grid-cols-2 gap-4 text-sm border-t border-gray-200 dark:border-gray-600 pt-3">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Reserve Price:</span>
                                            <span class="font-semibold text-green-600 ml-2">
                                                ${{ number_format($reservePrice['amount'] ?? 0) }}
                                            </span>
                                        </div>
                                        @if($leadingBid && $leadingBid['amount'])
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Current Winning Bid:</span>
                                            <span class="font-semibold text-blue-600 ml-2">
                                                ${{ number_format($leadingBid['amount']) }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    @if($hasSelectedUserBid)
                                    <div class="mt-3 bg-{{ $selectedIsWinning ? 'green' : 'yellow' }}-50 dark:bg-{{ $selectedIsWinning ? 'green' : 'yellow' }}-900/20 border border-{{ $selectedIsWinning ? 'green' : 'yellow' }}-200 dark:border-{{ $selectedIsWinning ? 'green' : 'yellow' }}-800 rounded-lg p-2">
                                        <p class="text-xs text-{{ $selectedIsWinning ? 'green' : 'yellow' }}-800 dark:text-{{ $selectedIsWinning ? 'green' : 'yellow' }}-200">
                                            @if($selectedIsWinning)
                                                🏆 Your current bid of ${{ number_format($selectedUserBidAmount) }} is winning
                                            @else
                                                ⚠️ Your current bid of ${{ number_format($selectedUserBidAmount) }} is being outbid
                                            @endif
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Auto-Bid Configuration -->
                                <div class="space-y-4">
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">⚡ How Auto-Bid Works</h4>
                                        <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                            <li>• Automatically outbids other bidders to keep you winning</li>
                                            <li>• Only bids when necessary (when someone outbids you)</li>
                                            <li>• Stops when it reaches your minimum price limit</li>
                                            <li>• Works 24/7 until auction ends</li>
                                        </ul>
                                    </div>
                                    
                                    <div>
                                        <label for="auto-bid-min-price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Your Minimum Bid Price (Lowest you're willing to go)
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-lg">$</span>
                                            </div>
                                            <input 
                                                type="number" 
                                                id="auto-bid-min-price"
                                                wire:model.live="autoBidMinPrice"
                                                step="0.01"
                                                min="0"
                                                placeholder="Enter minimum price"
                                                class="block w-full pl-8 pr-12 py-4 text-xl border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                            >
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            This is the lowest price you're willing to accept. Auto-bid will stop here.
                                        </p>
                                    </div>
                                    
                                    <!-- Real-time Calculations -->
                                    @if($autoBidMinPrice && is_numeric($autoBidMinPrice) && $autoBidMinPrice > 0)
                                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @if($distance > 0 && $autoBidCalculatedPerMile > 0)
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                    ${{ number_format($autoBidCalculatedPerMile, 2) }}
                                                </div>
                                                <div class="text-sm text-green-800 dark:text-green-300">per mile minimum</div>
                                            </div>
                                            @endif
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                    ${{ number_format($autoBidMinPrice) }}
                                                </div>
                                                <div class="text-sm text-blue-800 dark:text-blue-300">minimum total</div>
                                            </div>
                                        </div>
                                        
                                        @if($distance > 0 && $autoBidMinPrice > 0)
                                        <div class="mt-4 pt-3 border-t border-green-200 dark:border-green-700">
                                            <div class="text-center text-sm text-green-700 dark:text-green-300">
                                                <strong>Calculation:</strong> ${{ number_format($autoBidMinPrice) }} (min bid) ÷ {{ number_format($distance) }} (miles) = ${{ number_format($autoBidCalculatedPerMile, 2) }} per mile
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($leadingBid && $autoBidMinPrice >= $leadingBid['amount'])
                                        <div class="mt-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                ⚠️ Your minimum is higher than current winning bid - Auto-bid may not activate immediately
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$autoBidMinPrice || !is_numeric($autoBidMinPrice) || $autoBidMinPrice <= 0 ? 'disabled' : '' }}
                        >
                            ⚡ Activate Auto-Bid
                        </button>
                        <button 
                            type="button"
                            wire:click="closeAutoBidModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-zinc-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtersPanel = document.querySelector('[wire\\:show="showFilters"]');
    if (filtersPanel && !filtersPanel.hasAttribute('style')) {
        initializeAutocomplete();
    }
});

// Listen for Livewire event when filters are shown
document.addEventListener('livewire:init', () => {
    Livewire.on('filters-shown', () => {
        setTimeout(initializeAutocomplete, 100);
    });
});

// Also use MutationObserver as fallback to detect when filter inputs appear
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'childList') {
            const originInput = document.getElementById('origin-search');
            const destinationInput = document.getElementById('destination-search');
            
            if ((originInput || destinationInput) && !originInput?.hasAttribute('data-autocomplete-setup')) {
                setTimeout(initializeAutocomplete, 100);
            }
        }
    });
});

// Start observing
observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Re-initialize after Livewire updates (but only if filters are visible)
document.addEventListener('livewire:navigated', function() {
    setTimeout(() => {
        const filtersPanel = document.querySelector('[wire\\:show="showFilters"]');
        if (filtersPanel && !filtersPanel.hasAttribute('style')) {
            initializeAutocomplete();
        }
    }, 100);
});

let debounceTimers = {};
const MAPBOX_TOKEN = '{{ config("services.mapbox.access_token") }}';

function initializeAutocomplete() {
    const originInput = document.getElementById('origin-search');
    const destinationInput = document.getElementById('destination-search');
    
    if (originInput) {
        setupLocationAutocomplete(originInput, 'origin');
    }
    
    if (destinationInput) {
        setupLocationAutocomplete(destinationInput, 'destination');
    }
}

function setupLocationAutocomplete(input, type) {
    // Check if already setup
    if (input.hasAttribute('data-autocomplete-setup')) {
        return;
    }
    
    // Clear any existing event listeners by cloning the element
    const newInput = input.cloneNode(true);
    input.parentNode.replaceChild(newInput, input);
    
    // Mark as setup
    newInput.setAttribute('data-autocomplete-setup', 'true');
    
    // Add input event listener
    newInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        // Clear previous timer
        if (debounceTimers[type]) {
            clearTimeout(debounceTimers[type]);
        }
        
        // Remove existing suggestions
        hideLocationSuggestions(type);
        
        if (query.length < 2) {
            return;
        }
        
        // Debounce the search
        debounceTimers[type] = setTimeout(() => {
            searchMapboxLocations(query, newInput, type);
        }, 500);
    });
    
    // Add focus event listener
    newInput.addEventListener('focus', function(e) {
        const query = e.target.value.trim();
        if (query.length >= 2) {
            searchMapboxLocations(query, newInput, type);
        }
    });
}

function searchMapboxLocations(query, input, type) {
    if (!MAPBOX_TOKEN) {
        return;
    }
    
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${MAPBOX_TOKEN}&country=us&types=place,locality,address&limit=5`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.features && data.features.length > 0) {
                displayLocationSuggestions(input, data.features, type);
            }
        })
        .catch(error => {
            // Silently handle errors
        });
}

function displayLocationSuggestions(input, features, type) {
    // Remove any existing suggestions
    hideLocationSuggestions(type);
    
    const container = input.parentNode;
    container.style.position = 'relative';
    
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.id = `${type}-suggestions`;
    suggestionsDiv.className = 'absolute z-50 w-full bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto';
    
    features.forEach((feature, index) => {
        const item = document.createElement('div');
        item.className = 'px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 cursor-pointer text-sm text-zinc-900 dark:text-white border-b border-zinc-200 dark:border-zinc-600 last:border-b-0';
        item.textContent = feature.place_name;
        
        item.addEventListener('click', function() {
            input.value = feature.place_name;
            
            const [lng, lat] = feature.center;
            
            // Update Livewire component
            if (type === 'origin') {
                window.Livewire.find(input.closest('[wire\\:id]').getAttribute('wire:id')).call('updateOriginLocation', feature.id, feature.place_name, lat, lng);
            } else {
                window.Livewire.find(input.closest('[wire\\:id]').getAttribute('wire:id')).call('updateDestinationLocation', feature.id, feature.place_name, lat, lng);
            }
            
            hideLocationSuggestions(type);
        });
        
        suggestionsDiv.appendChild(item);
    });
    
    container.appendChild(suggestionsDiv);
    
    // Close suggestions when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeSuggestions(e) {
            if (!container.contains(e.target)) {
                hideLocationSuggestions(type);
                document.removeEventListener('click', closeSuggestions);
            }
        });
    }, 100);
}

function hideLocationSuggestions(type) {
    const suggestions = document.getElementById(`${type}-suggestions`);
    if (suggestions) {
        suggestions.remove();
    }
}
</script>

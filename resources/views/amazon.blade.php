<x-layouts.app :title="__('Amazon')">
    <div class="flex h-full w-full flex-1 flex-col rounded-xl bg-white dark:bg-white">
        @php
            $settings = auth()->user()->amazonSetting;
            $hasAllSettings = $settings && $settings->hasAllSettings();
        @endphp
        
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Amazon</h1>
                <p class="text-gray-600">Manage your Amazon integration</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hasAllSettings ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $hasAllSettings ? 'Connected' : 'Not Connected' }}
                    </span>
                </div>
                <a 
                    href="{{ route('amazon.settings') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                    wire:navigate
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
            </div>
        </div>

        <div class="flex-1 p-6">
            @if($hasAllSettings)
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Amazon Integration Active</h3>
                    <p class="text-gray-600 mb-6">Your Amazon settings are configured and ready to use.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-md mx-auto">
                        <a 
                            href="{{ route('amazon.auctions') }}" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                            wire:navigate
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            View Live Auctions
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Setup Required</h3>
                    <p class="text-gray-600 mb-4">Configure your Amazon settings to start using the integration.</p>
                    <a 
                        href="{{ route('amazon.settings') }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                        wire:navigate
                    >
                        Configure Settings
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
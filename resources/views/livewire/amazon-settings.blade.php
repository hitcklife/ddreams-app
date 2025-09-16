<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm">
        <div class="border-b border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Amazon Settings</h2>
                @php
                    $settings = auth()->user()->amazonSetting;
                    $hasAllSettings = $settings && $settings->hasAllSettings();
                @endphp
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hasAllSettings ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        {{ $hasAllSettings ? 'Connected' : 'Not Connected' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="text-green-800 dark:text-green-200">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Amazon Login Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Amazon Login Credentials</h3>
                <form wire:submit="loginToAmazon" class="space-y-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Amazon Email
                            </label>
                            <input
                                type="email"
                                wire:model="amazon_email"
                                placeholder="Enter your Amazon email"
                                class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            />
                            @error('amazon_email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Amazon Password
                            </label>
                            <input
                                type="password"
                                wire:model="amazon_password"
                                placeholder="Enter your Amazon password"
                                class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            />
                            @error('amazon_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Login & Get Credentials
                        </button>
                    </div>
                </form>
            </div>

            <!-- Manual Settings Section -->
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Manual API Settings</h3>
                <form wire:submit="save" class="space-y-6">
                    <div class="grid gap-6">
                        <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Anti-CSRF Token A2Z
                        </label>
                        <textarea 
                            wire:model="anti_csrf_token_a2z" 
                            placeholder="Enter your anti-csrf-token-a2z value" 
                            rows="3"
                            class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>
                        @error('anti_csrf_token_a2z') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Cookie
                        </label>
                        <textarea 
                            wire:model="cookie" 
                            placeholder="Enter your cookie value" 
                            rows="4"
                            class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>
                        @error('cookie') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            X-CSRF Token
                        </label>
                        <textarea 
                            wire:model="x_csrf_token" 
                            placeholder="Enter your x-csrf-token value" 
                            rows="3"
                            class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>
                        @error('x_csrf_token') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

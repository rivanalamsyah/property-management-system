<div class="space-y-6">
    
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Account Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your public profile, password, preferences, and sessions.</p>
    </div>

    <!-- Edit Profile Card -->
    <x-card title="Profile Information" description="Update your account name, email address, and profile picture.">
        <form wire:submit="updateProfile" class="space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <!-- Avatar Upload Preview -->
                <div class="relative">
                    <img class="h-20 w-20 rounded-2xl object-cover bg-slate-100 border border-slate-200" 
                         src="{{ $avatar ? $avatar->temporaryUrl() : auth()->user()->avatar_url }}" 
                         alt="{{ $name }}">
                    
                    <label for="avatar_upload" class="absolute -bottom-1.5 -right-1.5 p-1.5 bg-indigo-600 text-white rounded-xl shadow-lg border border-white cursor-pointer hover:bg-indigo-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                    <input type="file" id="avatar_upload" class="hidden" wire:model="avatar" accept="image/*">
                </div>
                
                <div class="flex-1 space-y-1">
                    <h4 class="text-sm font-semibold text-slate-800">Profile Photo</h4>
                    <p class="text-xs text-slate-500">JPG, PNG, or WEBP. Max size of 2MB.</p>
                    @error('avatar')
                        <span class="text-xs text-rose-500 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                <div>
                    <label for="profile_name" class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                    <input wire:model="name" id="profile_name" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    @error('name')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="profile_email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                    <input wire:model="email" id="profile_email" type="email" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    @error('email')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-button type="submit" variant="primary" size="sm" loading="updateProfile">Save Changes</x-button>
            </div>
        </form>
    </x-card>

    <!-- Preferences Card -->
    <x-card title="Account Preferences" description="Customize settings like timezone, language, and date format.">
        <form wire:submit="updatePreferences" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="pref_timezone" class="block text-sm font-medium text-slate-700 mb-1.5">Timezone</label>
                    <select wire:model="timezone" id="pref_timezone"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="UTC">UTC</option>
                        <option value="Asia/Jakarta">Asia/Jakarta (GMT+7)</option>
                        <option value="Asia/Singapore">Asia/Singapore (GMT+8)</option>
                        <option value="America/New_York">America/New_York (EST/EDT)</option>
                        <option value="Europe/London">Europe/London (GMT/BST)</option>
                    </select>
                </div>

                <div>
                    <label for="pref_locale" class="block text-sm font-medium text-slate-700 mb-1.5">Language</label>
                    <select wire:model="locale" id="pref_locale"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="en">English</option>
                        <option value="id">Bahasa Indonesia</option>
                    </select>
                </div>

                <div>
                    <label for="pref_date_format" class="block text-sm font-medium text-slate-700 mb-1.5">Date Format</label>
                    <select wire:model="date_format" id="pref_date_format"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="Y-m-d">YYYY-MM-DD (2026-07-16)</option>
                        <option value="d/m/Y">DD/MM/YYYY (16/07/2026)</option>
                        <option value="m/d/Y">MM/DD/YYYY (07/16/2026)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-button type="submit" variant="primary" size="sm" loading="updatePreferences">Save Preferences</x-button>
            </div>
        </form>
    </x-card>

    <!-- Change Password Card -->
    <x-card title="Change Password" description="Ensure your account is using a long, random password to stay secure.">
        <form wire:submit="updatePassword" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="pwd_current" class="block text-sm font-medium text-slate-700 mb-1.5">Current Password</label>
                    <input wire:model="current_password" id="pwd_current" type="password" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="••••••••">
                    @error('current_password')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="pwd_new" class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                    <input wire:model="new_password" id="pwd_new" type="password" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="••••••••">
                    @error('new_password')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="pwd_confirm" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
                    <input wire:model="new_password_confirmation" id="pwd_confirm" type="password" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="••••••••">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-button type="submit" variant="primary" size="sm" loading="updatePassword">Change Password</x-button>
            </div>
        </form>
    </x-card>

    <!-- Active Sessions / Logout Other Devices Card -->
    <x-card title="Browser Sessions" description="Manage and log out of active sessions on other browsers and devices.">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive.
            </p>

            <div class="space-y-3">
                @foreach($sessions as $sessionItem)
                    <div class="flex items-center gap-3 p-3 border border-slate-100 rounded-xl">
                        <!-- Device Icon -->
                        <div class="text-slate-400 flex-shrink-0">
                            @if(preg_match('/(iPhone|Android|Mobile)/i', $sessionItem->user_agent))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-700 truncate">
                                {{ preg_match('/Macintosh/i', $sessionItem->user_agent) ? 'Mac OS' : (preg_match('/Windows/i', $sessionItem->user_agent) ? 'Windows' : (preg_match('/Linux/i', $sessionItem->user_agent) ? 'Linux' : 'Unknown OS')) }} 
                                - 
                                {{ preg_match('/Chrome/i', $sessionItem->user_agent) ? 'Google Chrome' : (preg_match('/Firefox/i', $sessionItem->user_agent) ? 'Mozilla Firefox' : (preg_match('/Safari/i', $sessionItem->user_agent) ? 'Safari' : 'Web Browser')) }}
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $sessionItem->ip_address }} - 
                                @if($sessionItem->id === session()->getId())
                                    <span class="text-indigo-600 font-semibold">This device</span>
                                @else
                                    Last active {{ \Carbon\Carbon::createFromTimestamp($sessionItem->last_activity)->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action -->
            <div class="pt-4 border-t border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex-1 max-w-lg">
                    <label for="logout_pass" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password to Terminate Other Sessions</label>
                    <input wire:model="current_password" id="logout_pass" type="password"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="••••••••">
                    @error('current_password')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-shrink-0 self-end md:self-center">
                    <x-button variant="danger" size="sm" wire:click="logoutOtherSessions" loading="logoutOtherSessions">
                        Log Out Other Browser Sessions
                    </x-button>
                </div>
            </div>
        </div>
    </x-card>
</div>

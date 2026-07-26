<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- LEFT: Settings Sidebar Categories Navigation -->
    <div class="space-y-4">
        <!-- Search -->
        <div class="bg-white border border-slate-100 rounded-3xl p-4 shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Search Configs</span>
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <x-input type="text" wire:model.live.debounce.250ms="search" placeholder="Search settings..." class="w-full pl-9 text-xs" />
            </div>
        </div>

        <!-- Sticky Tab selectors -->
        <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-3">Categories</span>
            
            @php
                $tabs = [
                    'general' => 'General Settings',
                    'localization' => 'Localization',
                    'email' => 'Mail Server (SMTP)',
                    'notifications' => 'Notifications',
                    'payments' => 'Payment Gateways',
                    'storage' => 'Storage & Limits',
                    'security' => 'Security & Auth',
                    'cache' => 'Cache & Tuning',
                    'scheduler' => 'Job Scheduler',
                    'integrations' => 'APIs & Integrations',
                    'diagnostics' => 'System Specs',
                    'audits' => 'Change Audits',
                ];
            @endphp

            @foreach($tabs as $key => $label)
                @if(empty($search) || str_contains(strtolower($label), strtolower($search)))
                    <button wire:click="$set('activeTab', '{{ $key }}')" class="w-full text-left px-3 py-2 text-xs font-semibold rounded-xl transition cursor-pointer flex items-center gap-2
                        {{ $activeTab === $key ? 'bg-indigo-50 text-indigo-650' : 'text-slate-600 hover:bg-slate-50' }}
                    ">
                        {{ $label }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- RIGHT: Form categories editor details -->
    <div class="lg:col-span-3 space-y-6">
        
        <!-- GENERAL SETTINGS TAB -->
        @if($activeTab === 'general')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">General platform settings</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Configure primary naming, logos, and address information.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="platform_name">Platform Label</x-label>
                        <x-input id="platform_name" type="text" wire:model="settingsData.platform_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="app_name">Application System Name</x-label>
                        <x-input id="app_name" type="text" wire:model="settingsData.app_name" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="company_name">Holding Corporate Name</x-label>
                        <x-input id="company_name" type="text" wire:model="settingsData.company_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="country">Origin Country</x-label>
                        <x-input id="country" type="text" wire:model="settingsData.country" placeholder="Indonesia" class="w-full mt-1.5" />
                    </div>
                </div>

                <div>
                    <x-label for="business_address">Holding Office Address</x-label>
                    <textarea id="business_address" wire:model="settingsData.business_address" rows="3" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save General Info
                    </button>
                </div>
            </div>
        @endif

        <!-- LOCALIZATION TAB -->
        @if($activeTab === 'localization')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Localization parameters</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Control system timezones, supported currencies, and formatted dates.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="default_language">Platform Language</x-label>
                        <select id="default_language" wire:model="settingsData.default_language" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="en">English (US)</option>
                            <option value="id">Bahasa Indonesia</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="default_timezone">Default System Timezone</x-label>
                        <x-input id="default_timezone" type="text" wire:model="settingsData.default_timezone" placeholder="Asia/Jakarta" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="currency">Billing Active Currency</x-label>
                        <x-input id="currency" type="text" wire:model="settingsData.currency" placeholder="IDR" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="date_format">Canonical Date Format</x-label>
                        <select id="date_format" wire:model="settingsData.date_format" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="Y-m-d">YYYY-MM-DD</option>
                            <option value="d/m/Y">DD/MM/YYYY</option>
                            <option value="F j, Y">Month DD, YYYY</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Localization
                    </button>
                </div>
            </div>
        @endif

        <!-- EMAIL / SMTP TAB -->
        @if($activeTab === 'email')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Mail Server Configurations</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Setup SMTP transmission servers. Credentials are encrypted on storage.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-label for="mail_driver">Driver Type</x-label>
                        <x-input id="mail_driver" type="text" wire:model="settingsData.mail_driver" class="w-full mt-1.5" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-label for="smtp_host">SMTP Host Address</x-label>
                        <x-input id="smtp_host" type="text" wire:model="settingsData.smtp_host" placeholder="smtp.mailgun.org" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-label for="smtp_port">Server TCP Port</x-label>
                        <x-input id="smtp_port" type="text" wire:model="settingsData.smtp_port" placeholder="587" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="smtp_encryption">Encryption Protocol</x-label>
                        <x-input id="smtp_encryption" type="text" wire:model="settingsData.smtp_encryption" placeholder="tls" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="smtp_username">SMTP Username</x-label>
                        <x-input id="smtp_username" type="text" wire:model="settingsData.smtp_username" class="w-full mt-1.5" />
                    </div>
                </div>

                <!-- Password with Toggle visibility -->
                <div class="space-y-1.5">
                    <x-label for="smtp_password">SMTP Server Password</x-label>
                    <div class="relative w-full">
                        <x-input id="smtp_password" type="{{ ($visibility['smtp_password'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.smtp_password" class="w-full pr-10" />
                        <button type="button" wire:click="toggleVisibility('smtp_password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-650 cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="sender_name">From Sender Name</x-label>
                        <x-input id="sender_name" type="text" wire:model="settingsData.sender_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="sender_address">From Sender Address</x-label>
                        <x-input id="sender_address" type="email" wire:model="settingsData.sender_address" class="w-full mt-1.5" />
                    </div>
                </div>

                <!-- Test Connection Panel -->
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex flex-col sm:flex-row items-end gap-3 justify-between">
                    <div class="w-full sm:max-w-xs">
                        <x-label for="testEmail">Send Test SMTP Dispatch</x-label>
                        <x-input id="testEmail" type="email" wire:model="testEmailAddress" class="w-full mt-1.5 bg-white text-xs" />
                    </div>
                    <button type="button" wire:click="sendTestEmail" class="py-2.5 px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                        Dispatch Email
                    </button>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save SMTP Settings
                    </button>
                </div>
            </div>
        @endif

        <!-- NOTIFICATION CHANNELS TAB -->
        @if($activeTab === 'notifications')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Active Notification Delivery Nodes</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Control active dispatch hooks globally.</p>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_email_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Email Invoices Notification</span>
                            <span class="text-[10px] text-slate-400">Sends transactional receipt matches and check-out notes.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_db_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Database Internal Messages Logs</span>
                            <span class="text-[10px] text-slate-400">Writes rows inside the in-app notification center.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_whatsapp_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">WhatsApp OTP Delivery Channels (Preparation)</span>
                            <span class="text-[10px] text-slate-400">Prepares dynamic webhooks dispatch to messaging portals.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Notification Paths
                    </button>
                </div>
            </div>
        @endif

        <!-- PAYMENT GATEWAYS TAB -->
        @if($activeTab === 'payments')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Active Payments integrations</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Configure gateway credentials for Midtrans, Xendit, and Stripe.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="payment_mode">Gateways Mode</x-label>
                        <select id="payment_mode" wire:model="settingsData.payment_mode" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="sandbox">Sandbox (Testing)</option>
                            <option value="production">Production (Live)</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-5 space-y-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Midtrans Indonesia</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="midtrans_merchant_id">Merchant ID</x-label>
                            <x-input id="midtrans_merchant_id" type="text" wire:model="settingsData.midtrans_merchant_id" class="w-full mt-1.5" />
                        </div>
                        <div>
                            <x-label for="midtrans_client_key">Client Key Token</x-label>
                            <div class="relative w-full mt-1.5">
                                <x-input id="midtrans_client_key" type="{{ ($visibility['midtrans_client_key'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.midtrans_client_key" class="w-full pr-10" />
                                <button type="button" wire:click="toggleVisibility('midtrans_client_key')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-5 space-y-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Stripe Gateway</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="stripe_publishable_key">Stripe Publishable Key</x-label>
                            <x-input id="stripe_publishable_key" type="text" wire:model="settingsData.stripe_publishable_key" class="w-full mt-1.5" />
                        </div>
                        <div>
                            <x-label for="stripe_secret">Stripe API Secret</x-label>
                            <div class="relative w-full mt-1.5">
                                <x-input id="stripe_secret" type="{{ ($visibility['stripe_secret'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.stripe_secret" class="w-full pr-10" />
                                <button type="button" wire:click="toggleVisibility('stripe_secret')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Gateways keys
                    </button>
                </div>
            </div>
        @endif

        <!-- STORAGE SETTINGS TAB -->
        @if($activeTab === 'storage')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Active storage drivers</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Control file uploads destinations and compression limits.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="storage_driver">File Storage Driver</x-label>
                        <select id="storage_driver" wire:model="settingsData.storage_driver" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="local">Local Hard Disk Disk</option>
                            <option value="s3">Amazon S3 Object Storage</option>
                            <option value="gcs">Google Cloud Storage</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="max_upload_size">Maximum Upload Limit (MB)</x-label>
                        <x-input id="max_upload_size" type="number" wire:model="settingsData.max_upload_size" placeholder="10" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Storage Driver
                    </button>
                </div>
            </div>
        @endif

        <!-- SECURITY TAB -->
        @if($activeTab === 'security')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Security & Sessions policy</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Configure authentication complexity requirements.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="session_timeout">Idle Session Timeout (Minutes)</x-label>
                        <x-input id="session_timeout" type="number" wire:model="settingsData.session_timeout" placeholder="120" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="password_policy">Password Complexity Threshold</x-label>
                        <select id="password_policy" wire:model="settingsData.password_policy" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="normal">Standard (Min 8 Characters)</option>
                            <option value="strict">Strict (Require Mixed-case, numbers, special symbols)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Security Policy
                    </button>
                </div>
            </div>
        @endif

        <!-- CACHE & TUNING TAB -->
        @if($activeTab === 'cache')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Cache tuning parameters</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Control system performance cache values.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="cache_driver">Tuning Cache Store</x-label>
                        <x-input id="cache_driver" type="text" wire:model="settingsData.cache_driver" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="cache_ttl">Standard Cache Duration (Seconds)</x-label>
                        <x-input id="cache_ttl" type="number" wire:model="settingsData.cache_ttl" placeholder="3600" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-950 block">Cache Operations Control</span>
                        <span class="text-[10px] text-slate-400">Evict all cache records instantly to reflect updates.</span>
                    </div>
                    <button type="button" wire:click="clearCache" class="py-2 px-3.5 bg-rose-50 border border-rose-100 text-rose-700 font-bold rounded-xl text-xs hover:bg-rose-100 transition cursor-pointer">
                        Clear Cache
                    </button>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Cache Settings
                    </button>
                </div>
            </div>
        @endif

        <!-- JOB SCHEDULER TAB -->
        @if($activeTab === 'scheduler')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Scheduler crontabs</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Setup recurring schedules triggers in cron expressions.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="billing_cron">Rental Invoices Generation Schedule</x-label>
                        <x-input id="billing_cron" type="text" wire:model="settingsData.billing_cron" placeholder="0 0 1 * *" class="w-full mt-1.5 font-mono text-xs" />
                    </div>
                    <div>
                        <x-label for="reminder_cron">Lease Reminders Trigger</x-label>
                        <x-input id="reminder_cron" type="text" wire:model="settingsData.reminder_cron" placeholder="0 9 * * *" class="w-full mt-1.5 font-mono text-xs" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Cron Schedules
                    </button>
                </div>
            </div>
        @endif

        <!-- APIS & INTEGRATIONS TAB -->
        @if($activeTab === 'integrations')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Integrations & Credentials</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Configure Google, reCAPTCHA, and WhatsApp tokens.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="google_analytics_id">Google Analytics UA/G-ID</x-label>
                        <x-input id="google_analytics_id" type="text" wire:model="settingsData.google_analytics_id" placeholder="G-XXXXXXXX" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="recaptcha_site_key">Google reCAPTCHA Site Key</x-label>
                        <x-input id="recaptcha_site_key" type="text" wire:model="settingsData.recaptcha_site_key" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Save Integration Keys
                    </button>
                </div>
            </div>
        @endif

        <!-- DIAGNOSTICS TAB -->
        @if($activeTab === 'diagnostics')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Platform Specifications & Diagnostics</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Real-time indicators of runtime packages.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Laravel Version</span>
                        <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $laravelVersion }}</span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">PHP Runtime</span>
                        <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $phpVersion }}</span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Redis Cache Ping</span>
                        <span class="text-xs font-bold mt-1.5 flex items-center gap-1.5
                            {{ $redisStatus === 'Connected' ? 'text-emerald-700' : 'text-rose-700' }}
                        ">
                            <span class="h-2 w-2 rounded-full {{ $redisStatus === 'Connected' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                            {{ $redisStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Queue Connection</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1.5 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $queueStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Cron Daemon</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1.5 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $schedulerStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Local Disk Size</span>
                        <span class="text-sm font-black text-slate-950 mt-1.5 block">{{ $storageUsage }}</span>
                    </div>
                </div>

                <!-- Export/Import Actions -->
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Configurations Import / Export</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-5 border border-slate-150 bg-slate-50/50 rounded-2xl space-y-3">
                            <span class="text-xs font-bold text-slate-900 block">Export Settings JSON</span>
                            <p class="text-[10px] text-slate-400">Download a full serialized settings dump representing present keys values.</p>
                            <button type="button" wire:click="exportConfig" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                                Export Config File
                            </button>
                        </div>

                        <div class="p-5 border border-slate-150 bg-slate-50/50 rounded-2xl space-y-3">
                            <span class="text-xs font-bold text-slate-900 block">Import Settings JSON</span>
                            <p class="text-[10px] text-slate-400">Upload a configurations template file to apply setting overrides.</p>
                            
                            <div class="flex items-center gap-3">
                                <input type="file" wire:model="importFile" class="text-xs text-slate-500" />
                                @if($importFile)
                                    <button type="button" wire:click="importConfig" class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 cursor-pointer">
                                        Import
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- CHANGE AUDITS TAB -->
        @if($activeTab === 'audits')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Configuration settings activity logs</h3>
                        <p class="text-xs text-slate-450 mt-0.5 leading-normal">Chronological record of system setting changes.</p>
                    </div>
                    <button type="button" wire:click="clearAudits" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold cursor-pointer">
                        Clear Logs
                    </button>
                </div>

                <div class="border border-slate-100 rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3">Timestamp</th>
                                <th class="px-5 py-3">Operator</th>
                                <th class="px-5 py-3">Setting Key</th>
                                <th class="px-5 py-3">Changes (Old &rarr; New)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-650 font-medium">
                            @forelse($audits as $audit)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-slate-450 text-[10px] whitespace-nowrap">
                                        {{ $audit->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="px-5 py-3 font-semibold text-slate-800">
                                        {{ $audit->user ? $audit->user->name : 'System Scheduler' }}
                                    </td>
                                    <td class="px-5 py-3 font-mono text-[11px] text-indigo-650">
                                        {{ $audit->properties['key'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-5 py-3 space-y-1">
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-mono text-[10px] max-w-[120px] truncate">{{ $audit->properties['old_value'] ?? 'None' }}</span>
                                            <span class="text-slate-400">&rarr;</span>
                                            <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-mono text-[10px] max-w-[120px] truncate">{{ $audit->properties['new_value'] ?? 'None' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-400 italic">No settings modifications recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

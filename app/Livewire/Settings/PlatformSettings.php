<?php

namespace App\Livewire\Settings;

use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\Settings\PlatformSettingsService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PlatformSettings extends Component
{
    use WithFileUploads;

    public string $activeTab = 'general';
    public string $search = '';

    // Bound settings array
    public array $settingsData = [];

    // Auxiliary actions properties
    public string $testEmailAddress = '';
    public $importFile;

    // Password fields visibility states
    public array $visibility = [];

    protected function rules(): array
    {
        return [
            'settingsData.platform_name' => ['nullable', 'string', 'max:255'],
            'settingsData.app_name' => ['nullable', 'string', 'max:255'],
            'settingsData.company_name' => ['nullable', 'string', 'max:255'],
            'settingsData.smtp_host' => ['nullable', 'string'],
            'settingsData.smtp_port' => ['nullable', 'numeric'],
            'settingsData.smtp_username' => ['nullable', 'string'],
            'settingsData.smtp_password' => ['nullable', 'string'],
            'settingsData.sender_address' => ['nullable', 'email'],
        ];
    }

    public function mount(): void
    {
        $service = app(PlatformSettingsService::class);

        // Predefined list of settings keys to initialize
        $keys = [
            // General
            'platform_name', 'app_name', 'company_name', 'logo_url', 'favicon_url', 
            'default_language', 'default_timezone', 'currency', 'date_format', 'time_format',
            'number_format', 'country', 'business_address', 'contact_info',
            // Localization
            'languages',
            // Email
            'mail_driver', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 
            'smtp_encryption', 'sender_name', 'sender_address', 'reply_to',
            // Notifications
            'enable_email_notifications', 'enable_db_notifications', 'enable_whatsapp_notifications',
            'enable_push_notifications', 'enable_sms_notifications',
            // Payments
            'midtrans_merchant_id', 'midtrans_client_key', 'midtrans_server_key', 
            'xendit_api_key', 'stripe_publishable_key', 'stripe_secret', 'stripe_webhook_secret', 
            'payment_mode', 'retry_strategy',
            // Storage
            'storage_driver', 's3_key', 's3_secret', 's3_region', 's3_bucket', 
            'max_upload_size', 'allowed_file_types',
            // Security
            'password_policy', 'session_timeout', 'remember_login', 'enable_2fa', 
            'rate_limit_requests', 'rate_limit_decay',
            // Cache
            'cache_driver', 'cache_ttl', 'redis_host', 'redis_port',
            // Scheduler
            'billing_cron', 'reminder_cron', 'cleanup_cron',
            // Integrations
            'google_maps_api_key', 'google_analytics_id', 'google_tag_manager_id', 
            'recaptcha_site_key', 'recaptcha_secret', 'whatsapp_api_url', 'whatsapp_api_token',
            // Backup
            'backup_frequency', 'backup_retention_days',
        ];

        foreach ($keys as $key) {
            $this->settingsData[$key] = $service->get($key, '');
            $this->visibility[$key] = false;
        }

        // Set default values if empty
        if (empty($this->settingsData['platform_name'])) $this->settingsData['platform_name'] = 'Kosan SaaS';
        if (empty($this->settingsData['app_name'])) $this->settingsData['app_name'] = 'Kosan Property Engine';
        if (empty($this->settingsData['default_language'])) $this->settingsData['default_language'] = 'en';
        if (empty($this->settingsData['default_timezone'])) $this->settingsData['default_timezone'] = 'UTC';
        if (empty($this->settingsData['currency'])) $this->settingsData['currency'] = 'IDR';
        if (empty($this->settingsData['mail_driver'])) $this->settingsData['mail_driver'] = 'smtp';
        if (empty($this->settingsData['storage_driver'])) $this->settingsData['storage_driver'] = 'local';
        if (empty($this->settingsData['cache_driver'])) $this->settingsData['cache_driver'] = 'redis';
        if (empty($this->settingsData['payment_mode'])) $this->settingsData['payment_mode'] = 'sandbox';

        $this->testEmailAddress = Auth::user()->email;
    }

    public function toggleVisibility(string $key): void
    {
        $this->visibility[$key] = !($this->visibility[$key] ?? false);
    }

    public function saveSettings(): void
    {
        $this->validate();
        
        $service = app(PlatformSettingsService::class);

        foreach ($this->settingsData as $key => $value) {
            $service->set($key, $value);
        }

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Settings saved successfully!']);
    }

    /**
     * Clear Cache manual runner.
     */
    public function clearCache(): void
    {
        Cache::flush();
        activity_log(
            event: 'settings.clear_cache',
            description: "System cache manually cleared",
            tenantId: null,
            userId: Auth::id()
        );
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Application cache cleared!']);
    }

    /**
     * Send Test Email SMTP runner.
     */
    public function sendTestEmail(): void
    {
        $this->validate([
            'testEmailAddress' => ['required', 'email'],
        ]);

        try {
            Mail::raw('This is a test email dispatched from your Kosan Settings Console.', function ($message) {
                $message->to($this->testEmailAddress)
                        ->subject('Kosan SMTP Testing Connection');
            });
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Test email sent successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Email failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Clear application audit log.
     */
    public function clearAudits(): void
    {
        ActivityLog::where('event', 'like', 'settings.%')->delete();
        $this->dispatch('toast', ['type' => 'warning', 'message' => 'Configuration settings activity logs cleared.']);
    }

    /**
     * Export config JSON file.
     */
    public function exportConfig()
    {
        $service = app(PlatformSettingsService::class);
        $json = $service->export();

        activity_log(
            event: 'settings.export',
            description: "System configurations settings exported to JSON",
            tenantId: null,
            userId: Auth::id()
        );

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, 'kosan_settings_export.json', [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Import JSON configuration template file.
     */
    public function importConfig(): void
    {
        $this->validate([
            'importFile' => ['required', 'file', 'mimes:json'],
        ]);

        try {
            $jsonPayload = file_get_contents($this->importFile->getRealPath());
            $service = app(PlatformSettingsService::class);
            $service->import($jsonPayload);

            activity_log(
                event: 'settings.import',
                description: "System configurations settings imported from JSON file",
                tenantId: null,
                userId: Auth::id()
            );

            // Re-mount component to bind imported values
            $this->mount();
            $this->importFile = null;

            $this->dispatch('toast', ['type' => 'success', 'message' => 'Configurations imported successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Import failed: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        // 1. Audit trail of configuration logs
        $audits = ActivityLog::with('user')
            ->where('event', 'like', 'settings.%')
            ->latest()
            ->take(15)
            ->get();

        // 2. Diagnostics
        $redisStatus = 'Disconnected';
        try {
            Redis::ping();
            $redisStatus = 'Connected';
        } catch (\Exception $e) {}

        // Mock statuses for other elements
        $queueStatus = 'Running';
        $schedulerStatus = 'Active';

        $storageUsage = '0.00 MB';
        try {
            $size = 0;
            foreach (Storage::disk('public')->allFiles() as $file) {
                $size += Storage::disk('public')->size($file);
            }
            $storageUsage = round($size / 1024 / 1024, 2) . ' MB';
        } catch (\Exception $e) {}

        return view('livewire.settings.platform-settings', [
            'audits' => $audits,
            'laravelVersion' => app()->version(),
            'phpVersion' => PHP_VERSION,
            'redisStatus' => $redisStatus,
            'queueStatus' => $queueStatus,
            'schedulerStatus' => $schedulerStatus,
            'storageUsage' => $storageUsage,
        ]);
    }
}

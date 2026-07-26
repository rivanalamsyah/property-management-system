<?php

namespace App\Services\Settings;

use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Exception;

class PlatformSettingsService
{
    /**
     * Keys containing private credentials that should be encrypted.
     */
    protected array $sensitiveKeys = [
        'smtp_password',
        'midtrans_client_key',
        'midtrans_server_key',
        'xendit_api_key',
        'stripe_secret',
        'stripe_webhook_secret',
        'whatsapp_api_token',
        'firebase_credentials',
        'recaptcha_secret',
    ];

    /**
     * Retrieve a setting value, decrypting if sensitive.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = Setting::whereNull('tenant_id')->where('key', $key)->first();

        if (!$setting || $setting->value === null) {
            return $default;
        }

        if ($this->isSensitive($key)) {
            try {
                return Crypt::decryptString($setting->value);
            } catch (Exception $e) {
                // If decryption fails, return default or raw value if not encrypted
                return $default;
            }
        }

        return $setting->value;
    }

    /**
     * Store or update a setting value, encrypting if sensitive, and log the change.
     */
    public function set(string $key, mixed $value): void
    {
        $oldSetting = Setting::whereNull('tenant_id')->where('key', $key)->first();
        $oldRawValue = $oldSetting ? $oldSetting->value : null;
        
        $oldDecryptedValue = null;
        if ($oldSetting && $oldSetting->value !== null) {
            if ($this->isSensitive($key)) {
                try {
                    $oldDecryptedValue = Crypt::decryptString($oldSetting->value);
                } catch (Exception $e) {
                    $oldDecryptedValue = $oldSetting->value;
                }
            } else {
                $oldDecryptedValue = $oldSetting->value;
            }
        }

        // Encrypt value if sensitive
        $storeValue = $value;
        if ($value !== null && $this->isSensitive($key)) {
            $storeValue = Crypt::encryptString((string)$value);
        }

        Setting::updateOrCreate(
            ['tenant_id' => null, 'key' => $key],
            ['value' => $storeValue]
        );

        // Record setting changes in ActivityLog
        if ($oldDecryptedValue !== $value) {
            activity_log(
                event: 'settings.update',
                description: "System setting updated: {$key}",
                properties: [
                    'key' => $key,
                    'old_value' => $this->isSensitive($key) ? '••••••••' : $oldDecryptedValue,
                    'new_value' => $this->isSensitive($key) ? '••••••••' : $value,
                ],
                tenantId: null,
                userId: Auth::id()
            );
        }
    }

    /**
     * Check if a setting key is classified as sensitive.
     */
    public function isSensitive(string $key): bool
    {
        return in_array($key, $this->sensitiveKeys);
    }

    /**
     * Export all system settings as a JSON payload.
     */
    public function export(): string
    {
        $settings = Setting::whereNull('tenant_id')->get()->map(function ($setting) {
            $decryptedVal = $setting->value;
            if ($setting->value !== null && $this->isSensitive($setting->key)) {
                try {
                    $decryptedVal = Crypt::decryptString($setting->value);
                } catch (Exception $e) {}
            }
            return [
                'key' => $setting->key,
                'value' => $decryptedVal,
            ];
        });

        return json_encode([
            'exported_at' => now()->toIso8601String(),
            'settings' => $settings->toArray(),
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Import system settings from a JSON payload.
     */
    public function import(string $jsonPayload): void
    {
        $data = json_decode($jsonPayload, true);

        if (!is_array($data) || !isset($data['settings']) || !is_array($data['settings'])) {
            throw new Exception('Invalid configuration JSON schema.');
        }

        foreach ($data['settings'] as $item) {
            if (isset($item['key'])) {
                $this->set($item['key'], $item['value'] ?? null);
            }
        }
    }
}

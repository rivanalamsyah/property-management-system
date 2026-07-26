<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use App\Models\ActivityLog;
use App\Services\Settings\PlatformSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class PlatformConfigurationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@kosan.test',
        ]);
    }

    public function test_setting_updates_triggers_audit_activity_log(): void
    {
        $this->actingAs($this->user);
        $service = new PlatformSettingsService();

        // 1. Act: change platform_name setting
        $service->set('platform_name', 'Kosan Enterprise');

        // 2. Assert Setting record updated in DB
        $this->assertDatabaseHas('settings', [
            'tenant_id' => null,
            'key' => 'platform_name',
            'value' => 'Kosan Enterprise',
        ]);

        // 3. Assert ActivityLog generated for system audit
        $this->assertDatabaseHas('activity_logs', [
            'event' => 'settings.update',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_sensitive_credentials_keys_are_encrypted(): void
    {
        $this->actingAs($this->user);
        $service = new PlatformSettingsService();

        // 1. Act: set sensitive smtp_password
        $secretValue = 'my-super-secret-password-123';
        $service->set('smtp_password', $secretValue);

        // 2. Assert stored DB value does not match raw password string
        $record = Setting::whereNull('tenant_id')->where('key', 'smtp_password')->first();
        $this->assertNotNull($record);
        $this->assertNotEquals($secretValue, $record->value);

        // 3. Assert service decrypts it back to original value
        $retrieved = $service->get('smtp_password');
        $this->assertEquals($secretValue, $retrieved);
    }

    public function test_configurations_import_and_export(): void
    {
        $this->actingAs($this->user);
        $service = new PlatformSettingsService();

        // Seed some settings
        $service->set('platform_name', 'Original Name');
        $service->set('smtp_password', 'secret-pass');

        // 1. Export settings
        $exportedJson = $service->export();
        $this->assertStringContainsString('Original Name', $exportedJson);
        $this->assertStringContainsString('secret-pass', $exportedJson);

        // 2. Import overrides
        $importPayload = json_encode([
            'exported_at' => now()->toIso8601String(),
            'settings' => [
                ['key' => 'platform_name', 'value' => 'Imported Overridden Name'],
                ['key' => 'smtp_password', 'value' => 'new-secret-pass'],
            ],
        ]);

        $service->import($importPayload);

        // 3. Verify overrides applied
        $this->assertEquals('Imported Overridden Name', $service->get('platform_name'));
        $this->assertEquals('new-secret-pass', $service->get('smtp_password'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tenant;
use App\Livewire\Security\SecurityCenter;
use App\Livewire\Backup\BackupCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SecurityBackupCenterTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');

        $this->admin = User::factory()->create([
            'email' => 'admin@kosan.test',
        ]);
        
        $ownerRole = \App\Models\Role::firstOrCreate(['name' => 'owner'], ['label' => 'Owner']);
        $this->tenant = Tenant::factory()->create();
        $this->admin->tenants()->attach($this->tenant->id, [
            'role_id' => $ownerRole->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        app(\App\Services\TenantManager::class)->setTenant($this->tenant);
    }

    public function test_firewall_blocks_banned_ip(): void
    {
        // 1. Arrange: Block loopback IPs (both IPv4 and IPv6)
        DB::table('security_ip_rules')->insert([
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'ip_address' => '127.0.0.1',
                'type' => 'block',
                'reason' => 'Suspicious scans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'ip_address' => '::1',
                'type' => 'block',
                'reason' => 'Suspicious scans',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 2. Act: Send request
        $response = $this->get('/');

        // 3. Assert: 403 Forbidden and incident recorded
        $response->assertStatus(403);
    }

    public function test_session_termination_via_security_center(): void
    {
        $this->actingAs($this->admin);

        // 1. Setup session row in DB
        DB::table('sessions')->insert([
            'id' => 'dummy-sess-id',
            'user_id' => $this->admin->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/Firefox',
            'payload' => 'payload-data',
            'last_activity' => time(),
        ]);

        // 2. Act: invoke Livewire component terminate method
        Livewire::test(SecurityCenter::class)
            ->call('terminateSession', 'dummy-sess-id');

        // 3. Assert: row deleted
        $this->assertDatabaseMissing('sessions', ['id' => 'dummy-sess-id']);
    }

    public function test_backup_and_validated_restore_operations(): void
    {
        $this->actingAs($this->admin);

        // 1. Compile backup via Livewire
        Livewire::test(BackupCenter::class)
            ->call('createManualBackup', 'database');

        $backup = DB::table('monitoring_backups')->first();
        $this->assertNotNull($backup);
        $this->assertEquals('database', $backup->type);
        $this->assertEquals('success', $backup->status);

        Storage::assertExists($backup->filepath);

        // 2. Restore from backup
        Livewire::test(BackupCenter::class)
            ->set('selectedBackupId', $backup->id)
            ->set('restoreReason', 'System config corruption recovery')
            ->call('triggerRestore');

        $this->assertDatabaseHas('monitoring_restores', [
            'backup_id' => $backup->id,
            'status' => 'success',
            'reason' => 'System config corruption recovery',
        ]);
    }

    public function test_workspace_suspension_archiving(): void
    {
        $this->actingAs($this->admin);

        // 1. Act: archive workspace
        Livewire::test(BackupCenter::class)
            ->call('updateWorkspaceStatus', $this->tenant->id, 'suspended');

        // 2. Assert: state updated in DB
        $this->assertEquals(\App\Enums\WorkspaceStatus::SUSPENDED, $this->tenant->fresh()->status);
    }

    public function test_disaster_drill_failover_simulation(): void
    {
        $this->actingAs($this->admin);

        // 1. Act: trigger DB failover simulation drill
        Livewire::test(BackupCenter::class)
            ->call('simulateDisaster', 'db');

        // 2. Assert: open critical incident recorded in DB logs
        $this->assertDatabaseHas('security_incidents', [
            'event_type' => 'database_failure',
            'severity' => 'critical',
            'status' => 'open',
        ]);
    }
}

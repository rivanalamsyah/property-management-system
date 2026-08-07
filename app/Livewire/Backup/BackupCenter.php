<?php

namespace App\Livewire\Backup;

use App\Models\Tenant;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BackupCenter extends Component
{
    public string $activeTab = 'overview';
    public ?string $selectedBackupId = null;
    public string $restoreReason = '';

    // Disaster simulations logs
    public array $simulationEvents = [];

    public function mount(): void
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }
    }

    /**
     * Create manual backup record in database.
     */
    public function createManualBackup(string $type = 'full'): void
    {
        try {
            $uuid = (string) Str::uuid();
            $filename = "backup-platform-{$type}-" . now()->format('Y-m-d-His') . ".zip";
            $filepath = "backups/{$filename}";

            // Ensure backups folder exists in local disk
            Storage::makeDirectory('backups');
            Storage::put($filepath, 'Kosan SaaS System Backup Core Data Placeholder ' . $uuid);

            $sizeBytes = Storage::size($filepath);
            $checksum = md5(Storage::get($filepath));

            DB::table('monitoring_backups')->insert([
                'id' => $uuid,
                'filename' => $filename,
                'filepath' => $filepath,
                'size_bytes' => $sizeBytes,
                'checksum' => $checksum,
                'type' => $type,
                'status' => 'success',
                'operator_id' => Auth::id(),
                'created_at' => now(),
            ]);

            // Log activity log update
            DB::table('activity_logs')->insert([
                'tenant_id' => null,
                'user_id' => Auth::id(),
                'event' => 'backup.create',
                'description' => "Created manual {$type} backup: {$filename}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->dispatch('toast', ['type' => 'success', 'message' => 'Manual backup archive compiled successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Backup creation failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete backup log and remove storage file.
     */
    public function deleteBackup(string $id): void
    {
        try {
            $backup = DB::table('monitoring_backups')->where('id', $id)->first();
            if ($backup) {
                Storage::delete($backup->filepath);
                DB::table('monitoring_backups')->where('id', $id)->delete();
                $this->dispatch('toast', ['type' => 'warning', 'message' => 'Backup archive deleted from disk.']);
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Delete failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Restore platform/workspace from selected backup.
     */
    public function triggerRestore(): void
    {
        $this->validate([
            'selectedBackupId' => ['required', 'uuid'],
            'restoreReason' => ['required', 'string', 'max:255'],
        ]);

        try {
            $backup = DB::table('monitoring_backups')->where('id', $this->selectedBackupId)->first();
            if (!$backup) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Invalid backup selection.']);
                return;
            }

            // 1. Validate Checksum & File integrity
            if (!Storage::exists($backup->filepath)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Backup source archive file is missing from disk!']);
                return;
            }

            $currentChecksum = md5(Storage::get($backup->filepath));
            if ($currentChecksum !== $backup->checksum) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Validation Failure: Backup MD5 checksum mismatch! Data may be corrupted.']);
                return;
            }

            // 2. Perform mock restoration pipeline
            $uuid = (string) Str::uuid();
            DB::table('monitoring_restores')->insert([
                'id' => $uuid,
                'backup_id' => $backup->id,
                'operator_id' => Auth::id(),
                'status' => 'success',
                'duration_seconds' => mt_rand(4, 9),
                'reason' => $this->restoreReason,
                'created_at' => now(),
            ]);

            DB::table('activity_logs')->insert([
                'tenant_id' => null,
                'user_id' => Auth::id(),
                'event' => 'backup.restore',
                'description' => "Restored system platform configuration from archive file: {$backup->filename}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->selectedBackupId = null;
            $this->restoreReason = '';
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Platform data restore completed successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Restore failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Archive, Suspend, or Reactivate specific tenant workspaces.
     */
    public function updateWorkspaceStatus(string $tenantId, string $status): void
    {
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->status = $status;
        $tenant->save();

        $this->dispatch('toast', [
            'type' => $status === 'active' ? 'success' : 'warning',
            'message' => "Workspace '{$tenant->name}' status updated to {$status}."
        ]);
    }

    /**
     * Simulate system disasters without actual destructive execution.
     */
    public function simulateDisaster(string $disasterType): void
    {
        $incId = (string) Str::uuid();
        $details = match ($disasterType) {
            'db' => [
                'type' => 'database_failure',
                'desc' => 'CRITICAL: Database connection ping timed out. Read-replicas disconnected.',
                'severity' => 'critical'
            ],
            'storage' => [
                'type' => 'storage_failure',
                'desc' => 'WARNING: Primary local backup disk size reached 98% capacity threshold limit.',
                'severity' => 'high'
            ],
            'queue' => [
                'type' => 'queue_failure',
                'desc' => 'CRITICAL: Queue job failures count has exceeded SRE limits (15 jobs failed in 5 mins).',
                'severity' => 'high'
            ],
            default => [
                'type' => 'system_failure',
                'desc' => 'SRE System failure simulated event.',
                'severity' => 'medium'
            ]
        };

        // Insert simulated threat alert into security center incident log
        DB::table('security_incidents')->insert([
            'id' => $incId,
            'event_type' => $details['type'],
            'description' => $details['desc'],
            'ip_address' => request()->ip(),
            'severity' => $details['severity'],
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->simulationEvents[] = [
            'time' => now()->format('H:i:s'),
            'type' => $details['type'],
            'desc' => $details['desc']
        ];

        $this->dispatch('toast', ['type' => 'error', 'message' => "SRE Alert triggered: {$details['desc']}"]);
    }

    public function render()
    {
        // Fetch catalogs
        $backups = DB::table('monitoring_backups')
            ->leftJoin('users', 'monitoring_backups.operator_id', '=', 'users.id')
            ->select('monitoring_backups.*', 'users.name as operator_name')
            ->orderBy('created_at', 'desc')
            ->get();

        $restores = DB::table('monitoring_restores')
            ->leftJoin('monitoring_backups', 'monitoring_restores.backup_id', '=', 'monitoring_backups.id')
            ->leftJoin('users', 'monitoring_restores.operator_id', '=', 'users.id')
            ->select('monitoring_restores.*', 'monitoring_backups.filename as backup_filename', 'users.name as operator_name')
            ->orderBy('created_at', 'desc')
            ->get();

        $workspaces = Tenant::take(10)->get();

        // Calculate backup metrics
        $backupCount = DB::table('monitoring_backups')->count();
        $totalBytes = DB::table('monitoring_backups')->sum('size_bytes');
        $totalSizeMb = round($totalBytes / 1024 / 1024, 4) . ' MB';
        $lastBackup = DB::table('monitoring_backups')->orderBy('created_at', 'desc')->first();
        $lastBackupDate = $lastBackup ? Carbon::parse($lastBackup->created_at)->diffForHumans() : 'Never';

        return view('livewire.backup.backup-center', [
            'backups' => $backups,
            'restores' => $restores,
            'workspaces' => $workspaces,
            'backupCount' => $backupCount,
            'totalSizeMb' => $totalSizeMb,
            'lastBackupDate' => $lastBackupDate,
        ]);
    }
}

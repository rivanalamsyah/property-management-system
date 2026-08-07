<?php

namespace App\Livewire\Security;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SecurityCenter extends Component
{
    public string $activeTab = 'dashboard';
    
    // IP rule creation
    public string $newIp = '';
    public string $ipType = 'block';
    public string $ipReason = '';

    // Resolution note creation
    public string $resolutionNote = '';

    public function mount(): void
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }
    }

    /**
     * Terminate an active user session in DB.
     */
    public function terminateSession(string $sessionId): void
    {
        try {
            DB::table('sessions')->where('id', $sessionId)->delete();
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Sesi pengguna telah diakhiri.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Gagal mengakhiri sesi: ' . $e->getMessage()]);
        }
    }

    /**
     * Terminate all active sessions except current user's active session.
     */
    public function terminateAllSessions(): void
    {
        try {
            $currentSessionId = session()->getId();
            DB::table('sessions')->where('id', '!=', $currentSessionId)->delete();
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Semua sesi pengguna lainnya telah diakhiri.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Gagal mengakhiri sesi.']);
        }
    }

    /**
     * Add firewall IP block/allow rule.
     */
    public function addIpRule(): void
    {
        $this->validate([
            'newIp' => ['required', 'ip'],
            'ipReason' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::table('security_ip_rules')->insert([
                'id' => (string) Str::uuid(),
                'ip_address' => $this->newIp,
                'type' => $this->ipType,
                'reason' => $this->ipReason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->newIp = '';
            $this->ipReason = '';
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Aturan IP Firewall berhasil ditambahkan.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Gagal menambahkan aturan (IP duplikat).']);
        }
    }

    /**
     * Delete firewall rule.
     */
    public function deleteIpRule(string $id): void
    {
        DB::table('security_ip_rules')->where('id', $id)->delete();
        $this->dispatch('toast', ['type' => 'warning', 'message' => 'Aturan Firewall berhasil dihapus.']);
    }

    /**
     * Resolve security incident alert.
     */
    public function resolveIncident(string $id): void
    {
        $this->validate([
            'resolutionNote' => ['required', 'string', 'max:500'],
        ]);

        DB::table('security_incidents')
            ->where('id', $id)
            ->update([
                'status' => 'resolved',
                'resolution_notes' => $this->resolutionNote,
                'updated_at' => now(),
            ]);

        $this->resolutionNote = '';
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Laporan insiden keamanan telah ditandai sebagai selesai.']);
    }

    public function render()
    {
        // 1. Fetch active sessions list
        $sessions = [];
        try {
            $sessions = DB::table('sessions')
                ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
                ->select('sessions.*', 'users.name as user_name')
                ->get()
                ->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'user_name' => $s->user_name ?? 'Guest',
                        'ip_address' => $s->ip_address,
                        'user_agent' => substr($s->user_agent, 0, 70) . '...',
                        'last_activity' => Carbon::createFromTimestamp($s->last_activity)->diffForHumans(),
                    ];
                })->toArray();
        } catch (\Exception $e) {}

        // 2. Fetch firewall rules
        $ipRules = DB::table('security_ip_rules')->latest()->get();

        // 3. Fetch security incidents logs
        $incidents = DB::table('security_incidents')
            ->leftJoin('users', 'security_incidents.user_id', '=', 'users.id')
            ->select('security_incidents.*', 'users.name as user_name')
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Fetch Users role matrix
        $rolesList = Role::with('permissions')->get();
        $permissionsList = Permission::all();

        // Counts
        $openAlertsCount = DB::table('security_incidents')->where('status', 'open')->count();
        $failedLogins = mt_rand(2, 6);
        $blockedRequests = DB::table('security_incidents')->where('event_type', 'blocked_ip')->count();

        return view('livewire.security.security-center', [
            'sessions' => $sessions,
            'ipRules' => $ipRules,
            'incidents' => $incidents,
            'rolesList' => $rolesList,
            'permissionsList' => $permissionsList,
            'openAlertsCount' => $openAlertsCount,
            'failedLogins' => $failedLogins,
            'blockedRequests' => $blockedRequests,
        ]);
    }
}

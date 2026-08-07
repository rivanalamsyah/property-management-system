<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Setting;
use App\Models\InAppNotification;
use App\Models\SavedReport;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSettingsAndLogsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();

        $owner   = User::where('email', 'owner@example.test')->first();
        $staff1  = User::where('email', 'staff@example.test')->first();
        $staff2  = User::where('email', 'staff2@example.test')->first();
        $penyewa = User::where('email', 'penyewa@example.test')->first();

        // 1. Settings
        tenant_manager()->setTenant($tenant1);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'app_theme'],           ['value' => 'light']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'allow_late_complaints'], ['value' => 'true']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'invoice_due_day'],      ['value' => '5']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'late_fee_amount'],      ['value' => '50000']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'late_fee_type'],        ['value' => 'flat']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'whatsapp_notification'], ['value' => 'true']);
        Setting::updateOrCreate(['tenant_id' => $tenant1->id, 'key' => 'email_notification'],    ['value' => 'true']);

        // 2. In-App Notifications
        InAppNotification::firstOrCreate(['tenant_id' => $tenant1->id, 'user_id' => $owner->id,   'type' => 'payment'], ['data' => ['title' => 'Bukti Pembayaran Baru', 'message' => 'Budi Santoso mengunggah bukti transfer sewa Kamar A-101.']]);
        InAppNotification::firstOrCreate(['tenant_id' => $tenant1->id, 'user_id' => $staff1->id,  'type' => 'warning'], ['data' => ['title' => 'Tagihan Jatuh Tempo', 'message' => 'Tagihan sewa Rudi Setiawan (Kamar B-201) sudah mendekati jatuh tempo.']]);
        InAppNotification::firstOrCreate(['tenant_id' => $tenant1->id, 'user_id' => $staff2->id,  'type' => 'complaint'], ['data' => ['title' => 'Komplain Baru Masuk', 'message' => 'Kran air patah di Kamar B-201.']]);

        // 3. Saved Reports
        SavedReport::firstOrCreate(['tenant_id' => $tenant1->id, 'name' => 'Laporan Pendapatan H1 2026'], ['report_type' => 'financial', 'filters' => ['period' => 'h1_2026', 'boarding_house' => 'all'], 'user_id' => $owner->id]);
        SavedReport::firstOrCreate(['tenant_id' => $tenant1->id, 'name' => 'Daftar Tunggakan Sewa Aktif'], ['report_type' => 'overdue', 'filters' => ['status' => 'overdue'], 'user_id' => $staff1->id]);

        // 4. Activity Logs
        $this->seedActivityLogs($tenant1->id, [$owner, $staff1, $staff2, $penyewa]);

        // 5. System-wide Monitoring & Security Data
        $this->seedMonitoringData([$owner, $staff1, $staff2], [$tenant1]);
        $this->seedSecurityData([$tenant1]);

        tenant_manager()->setTenant(null);
    }

    private function seedActivityLogs(string $tenantId, array $users): void
    {
        $events = [
            ['login',          'User berhasil login ke sistem.'],
            ['view_dashboard', 'Mengakses halaman dashboard.'],
            ['view_residents', 'Mengakses daftar penghuni.'],
            ['view_invoices',  'Mengakses daftar tagihan.'],
            ['verify_payment', 'Memverifikasi pembayaran penghuni.'],
            ['create_invoice', 'Membuat tagihan sewa baru.'],
            ['update_room',    'Memperbarui data kamar.'],
            ['logout',         'User logout dari sistem.'],
        ];

        $ipAddresses = ['192.168.1.10', '192.168.1.15', '10.0.0.5', '203.0.113.42'];

        foreach ($users as $user) {
            if (!$user) continue;
            $logCount = rand(5, 10);
            for ($i = 0; $i < $logCount; $i++) {
                [$event, $description] = $events[array_rand($events)];
                ActivityLog::create([
                    'tenant_id'   => $tenantId,
                    'user_id'     => $user->id,
                    'event'       => $event,
                    'description' => $description,
                    'properties'  => ['module' => explode('_', $event)[0] ?? 'system'],
                    'ip_address'  => $ipAddresses[array_rand($ipAddresses)],
                    'user_agent'  => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'created_at'  => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    'updated_at'  => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }

    private function seedMonitoringData(array $users, array $tenants): void
    {
        $methods    = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        $urls       = [
            '/dashboard', '/residents', '/rooms', '/invoices', '/payments',
            '/complaints', '/maintenance', '/announcements', '/reports',
            '/api/residents', '/api/invoices', '/api/payments/verify',
        ];
        $statusCodes = [200, 200, 200, 200, 201, 301, 404, 422, 500];

        // 1. Seed request logs (id is auto-incrementing integer)
        for ($i = 0; $i < 50; $i++) {
            $user = $users[array_rand($users)];
            if (!$user) continue;
            $statusCode = $statusCodes[array_rand($statusCodes)];

            DB::table('monitoring_request_logs')->insert([
                'method'        => $methods[array_rand($methods)],
                'url'           => $urls[array_rand($urls)],
                'status_code'   => $statusCode,
                'duration_ms'   => rand(10, 1500),
                'ip_address'    => '192.168.1.' . rand(2, 254),
                'user_id'       => $user->id,
                'tenant_id'     => $tenants[0]->id,
                'created_at'    => now()->subMinutes(rand(1, 10000)),
            ]);
        }

        // 2. Seed exception logs (id is primary uuid, message is column name, no tenant_id)
        $exceptions = [
            ['class' => 'Illuminate\\Database\\QueryException',   'msg' => 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry'],
            ['class' => 'Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException', 'msg' => 'The route api/v1/unknown could not be found.'],
            ['class' => 'Illuminate\\Auth\\Access\\AuthorizationException', 'msg' => 'This action is unauthorized.'],
            ['class' => 'ErrorException', 'msg' => 'Undefined array key "settings"'],
        ];

        foreach ($exceptions as $ex) {
            DB::table('monitoring_exceptions')->insert([
                'id'                => Str::uuid(),
                'exception_class'   => $ex['class'],
                'message'           => $ex['msg'],
                'stack_trace'       => '#0 C:\\laragon\\www\\kosan\\app\\Http\\Controllers\\Controller.php(25): doSomething()',
                'occurrences_count' => rand(1, 10),
                'last_occurred_at'  => now()->subHours(rand(1, 48)),
                'created_at'        => now()->subDays(rand(1, 5)),
                'updated_at'        => now(),
            ]);
        }

        // 3. Seed BCDR (backup/restore) log
        $backups = [
            ['name' => 'backup_weekly_cihampelas.sql', 'size' => 12500000],
            ['name' => 'backup_manual_cihampelas.sql', 'size' => 12550000],
        ];

        foreach ($backups as $bk) {
            $backupId = Str::uuid();
            DB::table('monitoring_backups')->insert([
                'id'          => $backupId,
                'filename'    => $bk['name'],
                'filepath'    => 'backups/' . $bk['name'],
                'size_bytes'  => $bk['size'],
                'type'        => 'database',
                'status'      => 'success',
                'operator_id' => $users[0]->id,
                'created_at'  => now()->subDays(rand(1, 14)),
            ]);

            // Add corresponding monitoring_restores entry
            if (rand(0, 1)) {
                DB::table('monitoring_restores')->insert([
                    'id'               => Str::uuid(),
                    'backup_id'        => $backupId,
                    'operator_id'      => $users[0]->id,
                    'status'           => 'success',
                    'duration_seconds' => rand(60, 300),
                    'reason'           => 'Restore testing setelah upgrade database schema.',
                    'tenant_id'        => $tenants[0]->id,
                    'created_at'       => now()->subDays(15),
                ]);
            }
        }
    }

    private function seedSecurityData(array $tenants): void
    {
        $ipRules = [
            ['ip' => '185.220.101.5',  'type' => 'block', 'reason' => 'Brute force login attempt terdeteksi dari IP ini.'],
            ['ip' => '45.148.10.220',  'type' => 'block', 'reason' => 'Scanning aktivitas mencurigakan dari subnet ini.'],
            ['ip' => '192.168.100.1',  'type' => 'allow', 'reason' => 'IP internal kantor pusat diizinkan.'],
            ['ip' => '10.0.0.0',       'type' => 'allow', 'reason' => 'IP jaringan internal server diizinkan.'],
            ['ip' => '103.145.90.12',  'type' => 'block', 'reason' => 'IP diblokir karena percobaan SQL injection.'],
        ];

        foreach ($ipRules as $rule) {
            if (!DB::table('security_ip_rules')->where('ip_address', $rule['ip'])->exists()) {
                DB::table('security_ip_rules')->insert([
                    'id'         => Str::uuid(),
                    'ip_address' => $rule['ip'],
                    'type'       => $rule['type'],
                    'reason'     => $rule['reason'],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ]);
            }
        }

        $incidents = [
            [
                'event_type'       => 'brute_force',
                'description'      => 'Terdeteksi 50+ percobaan login gagal berturut-turut pada akun owner@example.test dalam 5 menit.',
                'ip_address'       => '185.220.101.5',
                'severity'         => 'high',
                'status'           => 'resolved',
                'resolution_notes' => 'IP sudah diblokir di level firewall. Akun dikunci sementara.',
                'tenant_id'        => $tenants[0]->id,
            ],
            [
                'event_type'       => 'unauthorized_access',
                'description'      => 'Percobaan akses ke endpoint /admin tanpa autentikasi yang valid.',
                'ip_address'       => '45.148.10.220',
                'severity'         => 'medium',
                'status'           => 'resolved',
                'resolution_notes' => 'Request ditolak oleh middleware auth. IP dipantau.',
                'tenant_id'        => $tenants[0]->id,
            ],
            [
                'event_type'       => 'privilege_escalation',
                'description'      => 'Terdeteksi percobaan akses fitur admin oleh user dengan role tenant.',
                'ip_address'       => '192.168.1.55',
                'severity'         => 'high',
                'status'           => 'open',
                'resolution_notes' => null,
                'tenant_id'        => $tenants[0]->id,
            ],
        ];

        foreach ($incidents as $incident) {
            if (!DB::table('security_incidents')->where('ip_address', $incident['ip_address'])->where('event_type', $incident['event_type'])->exists()) {
                DB::table('security_incidents')->insert([
                    'id'               => Str::uuid(),
                    'event_type'       => $incident['event_type'],
                    'description'      => $incident['description'],
                    'ip_address'       => $incident['ip_address'],
                    'user_id'          => null,
                    'tenant_id'        => $incident['tenant_id'],
                    'severity'         => $incident['severity'],
                    'status'           => $incident['status'],
                    'resolution_notes' => $incident['resolution_notes'],
                    'created_at'       => now()->subDays(rand(1, 20)),
                    'updated_at'       => now()->subDays(rand(0, 5)),
                ]);
            }
        }
    }
}

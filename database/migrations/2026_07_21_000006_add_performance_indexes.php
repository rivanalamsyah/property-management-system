<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Activity Logs
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index(['tenant_id', 'event']);
            $table->index('user_id');
        });

        // 2. Invoices
        Schema::table('invoices', function (Blueprint $table) {
            $table->index(['status', 'due_date']);
            $table->index(['resident_id', 'status']);
            $table->index(['tenant_id', 'invoice_date']);
        });

        // 3. Payments
        Schema::table('payments', function (Blueprint $table) {
            $table->index(['tenant_id', 'status']);
            $table->index('payment_date');
        });

        // 4. Contracts
        Schema::table('contracts', function (Blueprint $table) {
            $table->index(['status', 'end_date']);
            $table->index(['tenant_id', 'start_date']);
        });

        // 5. Monitoring Request Logs
        Schema::table('monitoring_request_logs', function (Blueprint $table) {
            $table->index(['status_code', 'created_at']);
        });

        // 6. Residents
        Schema::table('residents', function (Blueprint $table) {
            $table->index('status');
        });

        // 7. Complaints
        Schema::table('complaints', function (Blueprint $table) {
            $table->index(['status', 'tenant_id']);
        });

        // 8. Rooms
        Schema::table('rooms', function (Blueprint $table) {
            $table->index(['status', 'boarding_house_id']);
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['status', 'boarding_house_id']);
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex(['status', 'tenant_id']);
        });

        Schema::table('residents', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('monitoring_request_logs', function (Blueprint $table) {
            $table->dropIndex(['status_code', 'created_at']);
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropIndex(['status', 'end_date']);
            $table->dropIndex(['tenant_id', 'start_date']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'status']);
            $table->dropIndex(['payment_date']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['status', 'due_date']);
            $table->dropIndex(['resident_id', 'status']);
            $table->dropIndex(['tenant_id', 'invoice_date']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'event']);
            $table->dropIndex(['user_id']);
        });
    }
};

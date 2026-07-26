<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Firewall rules
        Schema::create('security_ip_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address')->unique();
            $table->string('type')->default('block'); // allow, block
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        // 2. Incident Center Alerts logs
        Schema::create('security_incidents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('event_type'); // brute_force, unauthorized_access, blocked_ip, privilege_escalation
            $table->text('description');
            
            $table->string('ip_address', 45);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('tenant_id')->nullable();
            
            $table->string('severity')->default('medium'); // low, medium, high, critical
            $table->string('status')->default('open'); // open, investigating, resolved
            $table->text('resolution_notes')->nullable();
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_incidents');
        Schema::dropIfExists('security_ip_rules');
    }
};

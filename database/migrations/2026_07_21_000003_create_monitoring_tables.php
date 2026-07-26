<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. HTTP Request Logs Table
        Schema::create('monitoring_request_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            
            $table->string('method', 10);
            $table->text('url');
            $table->integer('status_code');
            $table->integer('duration_ms'); // millisecond duration
            $table->string('ip_address', 45)->nullable();
            
            $table->timestamp('created_at')->nullable();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // 2. Exception / Error Aggregator Table
        Schema::create('monitoring_exceptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('exception_class');
            $table->text('message');
            $table->longText('stack_trace');
            $table->text('url')->nullable();
            $table->integer('occurrences_count')->default(1);
            
            $table->timestamp('last_occurred_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_exceptions');
        Schema::dropIfExists('monitoring_request_logs');
    }
};

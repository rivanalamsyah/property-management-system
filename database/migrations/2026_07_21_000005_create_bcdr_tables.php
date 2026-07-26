<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Backups historical records table
        Schema::create('monitoring_backups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('filepath');
            $table->bigInteger('size_bytes')->default(0);
            $table->string('checksum')->nullable();
            
            $table->string('type')->default('full'); // full, database, storage, config
            $table->string('status')->default('success'); // success, failed
            
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('operator_id')->references('id')->on('users')->nullOnDelete();
        });

        // 2. Restores logs table
        Schema::create('monitoring_restores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('backup_id')->constrained('monitoring_backups')->cascadeOnDelete();
            $table->unsignedBigInteger('operator_id')->nullable();
            
            $table->string('status')->default('success'); // success, failed
            $table->integer('duration_seconds')->default(0);
            $table->string('reason')->nullable();
            $table->uuid('tenant_id')->nullable(); // workspace restore scoping
            
            $table->timestamp('created_at')->nullable();

            $table->foreign('operator_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_restores');
        Schema::dropIfExists('monitoring_backups');
    }
};

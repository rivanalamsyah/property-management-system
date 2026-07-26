<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            $table->decimal('price_monthly', 12, 2)->default(0.00);
            $table->decimal('price_yearly', 12, 2)->default(0.00);
            
            // Limits
            $table->integer('max_rooms')->default(-1); // -1 = unlimited
            $table->integer('max_tenants')->default(-1);
            $table->integer('max_staff')->default(-1);
            $table->integer('max_branches')->default(-1);
            $table->integer('storage_limit_mb')->default(100);
            $table->integer('max_upload_size_mb')->default(2);
            
            // Features
            $table->boolean('has_reports')->default(false);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_resident_portal')->default(false);
            $table->boolean('has_maintenance')->default(false);
            $table->boolean('has_announcements')->default(false);
            
            // Feature flags / JSON custom
            $table->json('feature_flags')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};

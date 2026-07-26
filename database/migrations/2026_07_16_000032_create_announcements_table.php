<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('boarding_house_id')->nullable();
            
            $table->string('announcement_number');
            $table->string('title');
            $table->string('summary')->nullable();
            $table->text('content');
            $table->string('category'); // general, maintenance, water_shutdown, cleaning, rent_reminder, emergency, holiday, promotional, other
            $table->string('priority')->default('normal'); // low, normal, important, high, emergency
            $table->string('status')->default('draft'); // draft, scheduled, published, expired, archived, cancelled
            
            $table->string('target_type')->default('all'); // all, boarding_house, floor, room, selected_tenants
            $table->json('target_filters')->nullable(); // json representation of targets: floors [], rooms [], residents []
            
            $table->timestamp('publish_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('pinned_at')->nullable();
            
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();

            $table->unique(['tenant_id', 'announcement_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

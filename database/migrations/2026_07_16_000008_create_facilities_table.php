<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->nullable(); // null means global default, value means tenant-scoped custom
            $table->string('name');
            $table->string('slug');
            $table->string('icon'); // icon class or identifier
            $table->string('category'); // Room, General, Security, Shared, etc.
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('boarding_house_facility', function (Blueprint $table) {
            $table->uuid('boarding_house_id');
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->primary(['boarding_house_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boarding_house_facility');
        Schema::dropIfExists('facilities');
    }
};

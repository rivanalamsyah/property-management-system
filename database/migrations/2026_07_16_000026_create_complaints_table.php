<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('boarding_house_id');
            $table->uuid('room_id')->nullable();
            $table->uuid('resident_id');

            $table->string('complaint_number');
            $table->string('category'); // electricity, water, bathroom, ac, internet, furniture, door, roof, kitchen, security, cleaning, other
            $table->string('priority')->default('normal'); // low, normal, high, critical, emergency
            $table->string('status')->default('open'); // open, reviewed, assigned, in_progress, waiting_parts, completed, verified, closed, cancelled
            
            $table->string('subject');
            $table->text('description');
            $table->text('internal_notes')->nullable();
            $table->boolean('is_tenant_visible')->default(true);

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();

            $table->unique(['tenant_id', 'complaint_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};

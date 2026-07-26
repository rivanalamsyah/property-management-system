<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('boarding_house_id');
            $table->string('room_number');
            $table->string('room_name')->nullable();
            $table->integer('floor')->default(1);
            $table->string('building_block')->nullable();
            $table->string('room_type'); // Standard, Deluxe, Suite, VIP
            $table->decimal('monthly_rent', 12, 2);
            $table->decimal('security_deposit', 12, 2)->default(0.00);
            $table->string('room_size')->nullable(); // e.g., 3x4, 4x5
            $table->integer('max_occupants')->default(1);
            $table->string('gender_restriction')->default('any'); // any, male, female
            $table->string('status')->default('available'); // available, occupied, reserved, maintenance, cleaning, unavailable, inactive
            $table->text('description')->nullable();
            $table->text('internal_notes')->nullable();
            $table->integer('display_order')->default(0);
            $table->string('room_code')->unique();
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->unique(['boarding_house_id', 'room_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

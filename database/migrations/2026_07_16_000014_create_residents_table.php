<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id'); // Workspace context
            $table->uuid('boarding_house_id')->nullable();
            $table->uuid('room_id')->nullable();

            // Profile info
            $table->string('name');
            $table->string('nik');
            $table->string('gender')->default('male'); // male, female
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('nationality')->default('WNI');
            $table->string('occupation');
            $table->string('marital_status');
            $table->string('religion')->nullable();
            $table->string('photo')->nullable();

            // Contact
            $table->string('phone');
            $table->string('whatsapp');
            $table->string('email');

            // Emergency Contact
            $table->string('emergency_name');
            $table->string('emergency_relationship');
            $table->string('emergency_phone');
            $table->text('emergency_address');

            // Address Info
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('postal_code');
            $table->text('address');

            // Operational Lifecycle details
            $table->string('status')->default('pending'); // pending, reserved, active, late_payment, moving_out, former, blacklisted, inactive
            
            // Check-in info
            $table->date('check_in_date')->nullable();
            $table->time('move_in_time')->nullable();
            $table->decimal('initial_meter_reading', 8, 2)->nullable();
            $table->decimal('security_deposit', 12, 2)->default(0.00);
            $table->text('check_in_notes')->nullable();

            // Check-out info
            $table->date('check_out_date')->nullable();
            $table->decimal('final_meter_reading', 8, 2)->nullable();
            $table->text('check_out_notes')->nullable();
            $table->text('damage_notes')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();

            $table->unique(['tenant_id', 'nik']);
            $table->unique(['tenant_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

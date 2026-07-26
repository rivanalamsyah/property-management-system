<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('boarding_house_id');
            $table->uuid('room_id')->nullable();
            $table->uuid('resident_id');

            $table->string('contract_number');
            $table->string('contract_type')->default('monthly'); // monthly, quarterly, semi_annual, annual, custom
            $table->string('status')->default('draft'); // draft, pending_approval, active, expiring_soon, renewed, completed, cancelled, terminated, expired
            
            // Lease Bounds
            $table->date('start_date');
            $table->date('end_date');
            $table->date('move_in_date');
            $table->date('move_out_date')->nullable();
            $table->integer('duration_months')->default(1);
            $table->boolean('auto_renewal')->default(false);

            // Financial Specifications
            $table->decimal('monthly_rent', 12, 2);
            $table->decimal('security_deposit', 12, 2)->default(0.00);
            $table->decimal('electricity_fee', 12, 2)->default(0.00);
            $table->decimal('water_fee', 12, 2)->default(0.00);
            $table->decimal('internet_fee', 12, 2)->default(0.00);
            $table->decimal('parking_fee', 12, 2)->default(0.00);
            $table->decimal('additional_charges', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);

            // Admin info
            $table->text('internal_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->string('signed_pdf_path')->nullable();
            $table->integer('version')->default(1);

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();

            $table->unique(['tenant_id', 'contract_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};

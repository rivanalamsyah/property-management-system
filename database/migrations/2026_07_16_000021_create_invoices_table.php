<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('boarding_house_id');
            $table->uuid('room_id')->nullable();
            $table->uuid('resident_id');
            $table->uuid('contract_id')->nullable();

            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->date('billing_period_start');
            $table->date('billing_period_end');
            
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('penalty', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->string('status')->default('draft'); // draft, pending, sent, viewed, partially_paid, paid, overdue, cancelled, voided
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
            $table->foreign('contract_id')->references('id')->on('contracts')->nullOnDelete();

            $table->unique(['tenant_id', 'invoice_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

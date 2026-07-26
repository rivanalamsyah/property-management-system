<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('invoice_id');
            $table->uuid('contract_id')->nullable();
            $table->uuid('resident_id');
            $table->uuid('boarding_house_id');

            $table->string('transaction_number');
            $table->string('reference_number')->nullable();
            $table->date('payment_date');
            $table->string('payment_method'); // cash, bank_transfer, virtual_account, qris, credit_card, debit_card, ewallet
            $table->decimal('amount_paid', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(0.00);
            $table->decimal('penalty_paid', 12, 2)->default(0.00);
            $table->text('notes')->nullable();
            
            $table->string('proof_of_payment_path')->nullable();
            $table->string('status')->default('pending'); // pending, waiting_verification, verified, completed, failed, cancelled
            
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('reconciliation_notes')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->foreign('contract_id')->references('id')->on('contracts')->nullOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();

            $table->unique(['tenant_id', 'transaction_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

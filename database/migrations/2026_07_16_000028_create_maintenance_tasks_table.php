<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('complaint_id');

            $table->string('task_number');
            $table->unsignedBigInteger('assigned_staff_id')->nullable();
            
            $table->timestamp('assigned_at')->nullable();
            $table->date('estimated_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            $table->text('repair_notes')->nullable();
            $table->text('replacement_parts')->nullable();
            $table->decimal('cost', 12, 2)->default(0.00);

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
            $table->foreign('assigned_staff_id')->references('id')->on('users')->nullOnDelete();

            $table->unique(['tenant_id', 'task_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_tasks');
    }
};

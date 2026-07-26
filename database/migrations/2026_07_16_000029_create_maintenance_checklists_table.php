<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_checklists', function (Blueprint $table) {
            $table->id();
            $table->uuid('maintenance_task_id');
            $table->string('item');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->foreign('maintenance_task_id')->references('id')->on('maintenance_tasks')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_checklists');
    }
};

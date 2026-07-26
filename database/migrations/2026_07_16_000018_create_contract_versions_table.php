<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_versions', function (Blueprint $table) {
            $table->id();
            $table->uuid('contract_id');
            $table->integer('version_number');
            $table->unsignedBigInteger('created_by');
            $table->string('reason')->nullable();
            $table->json('previous_values')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_versions');
    }
};

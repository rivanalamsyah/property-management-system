<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resident_timelines', function (Blueprint $table) {
            $table->id();
            $table->uuid('resident_id');
            $table->string('event'); // created, check_in, check_out, status_change, document_uploaded, document_removed, profile_updated
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // icon class representation
            $table->string('color')->nullable(); // e.g., bg-emerald-500, bg-indigo-500
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resident_timelines');
    }
};

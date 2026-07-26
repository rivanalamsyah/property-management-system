<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_timelines', function (Blueprint $table) {
            $table->id();
            $table->uuid('complaint_id');
            $table->string('event'); // submitted, reviewed, assigned, in_progress, progress_updated, completed, verified, closed, cancelled
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();

            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_timelines');
    }
};

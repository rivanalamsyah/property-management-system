<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_facility', function (Blueprint $table) {
            $table->uuid('room_id');
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->primary(['room_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_facility');
    }
};

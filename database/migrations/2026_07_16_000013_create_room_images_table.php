<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_images', function (Blueprint $table) {
            $table->id();
            $table->uuid('room_id');
            $table->string('file_path');
            $table->boolean('is_cover')->default(false);
            $table->integer('display_order')->default(0);
            $table->string('label')->nullable();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_images');
    }
};

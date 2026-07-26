<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boarding_house_galleries', function (Blueprint $table) {
            $table->id();
            $table->uuid('boarding_house_id');
            $table->string('file_path');
            $table->boolean('is_cover')->default(false);
            $table->integer('display_order')->default(0);
            $table->string('label')->nullable();
            $table->timestamps();

            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boarding_house_galleries');
    }
};

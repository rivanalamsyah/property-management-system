<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boarding_house_rules', function (Blueprint $table) {
            $table->id();
            $table->uuid('boarding_house_id');
            $table->string('category'); // General, Curfew, Visitor, Pet, Cleanliness, Security, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // icon visual class or identifier
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible_public')->default(true);
            $table->timestamps();

            $table->foreign('boarding_house_id')->references('id')->on('boarding_houses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boarding_house_rules');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('complaint_id');
            $table->string('file_path');
            $table->string('label')->nullable();
            $table->timestamps();

            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_attachments');
    }
};

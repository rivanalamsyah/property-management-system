<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resident_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('resident_id');
            $table->string('document_type'); // KTP, Passport, Family Card, Student Card, Employee Card
            $table->string('file_path');
            $table->string('label')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resident_documents');
    }
};

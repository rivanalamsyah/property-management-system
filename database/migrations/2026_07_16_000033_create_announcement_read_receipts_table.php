<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_read_receipts', function (Blueprint $table) {
            $table->id();
            $table->uuid('announcement_id');
            $table->uuid('resident_id');
            
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('announcement_id')->references('id')->on('announcements')->cascadeOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();

            $table->unique(['announcement_id', 'resident_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_read_receipts');
    }
};

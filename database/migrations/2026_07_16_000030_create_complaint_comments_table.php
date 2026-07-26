<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_comments', function (Blueprint $table) {
            $table->id();
            $table->uuid('complaint_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('resident_id')->nullable();
            
            $table->text('comment');
            $table->boolean('is_tenant_visible')->default(true);
            $table->string('attachment_path')->nullable();

            $table->timestamps();

            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('resident_id')->references('id')->on('residents')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_comments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fault_report_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fault_report_id')->constrained('fault_reports')->onDelete('cascade');
            $table->enum('media_type', ['image', 'video']);
            $table->string('file_path');
            $table->timestamps();
            $table->index('fault_report_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fault_report_media');
    }
};

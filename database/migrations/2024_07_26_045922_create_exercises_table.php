<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('titleAr')->nullable();
            $table->string('titleEn')->nullable();
            $table->foreignId('body_part_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('descriptionAr')->nullable();
            $table->string('descriptionEn')->nullable();
            $table->string('image')->nullable();
            $table->string('videoUrl')->nullable();
            $table->string('duration')->nullable();
            $table->string('type')->nullable();
            $table->string('level')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};

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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->string('titleAr')->nullable();
            $table->string('titleEn')->nullable();
            $table->foreignId('category_diet_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('calories')->nullable();
            $table->string('carbs')->nullable();
            $table->string('protein')->nullable();
            $table->string('fat')->nullable();
            $table->string('total_time')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->text('ingredientsAr')->nullable();
            $table->text('ingredientsEn')->nullable();
            $table->text('descriptionAr')->nullable();
            $table->text('descriptionEn')->nullable();
            $table->string('image');
            $table->json('suitable_for')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};

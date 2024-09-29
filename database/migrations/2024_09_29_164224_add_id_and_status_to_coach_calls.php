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
        Schema::table('coach_calls', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->string('status')->nullable()->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coach_calls', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'status']);
        });
    }
};

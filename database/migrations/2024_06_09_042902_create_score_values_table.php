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
        Schema::create('score_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('score_id')->constrained()->onDelete('cascade');
            $table->foreignId('intern_id')->constrained()->onDelete('cascade');
            $table->integer('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_values');
    }
};

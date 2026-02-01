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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('required_sorcerer_grade', ['1', '2', '3', '4', 's']);
            $table->enum('curse_level', ['1', '2', '3', '4', 's']);
            $table->enum('category', ['exorcism', 'investigation', 'rescue', 'escort']);
            $table->string('location');
            $table->enum('urgency_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['at_large', 'exorcised', 'sealed', 'contained'])->default('at_large');
            $table->timestamp('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};

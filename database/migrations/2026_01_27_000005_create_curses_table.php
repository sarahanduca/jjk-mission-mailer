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
        Schema::create('curses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('curse_level', ['1', '2', '3', '4', 's']);
            $table->enum('curse_type', ['vengeful', 'natural', 'cursed_object', 'disaster']);
            $table->text('abilities')->nullable();
            $table->text('known_weaknesses')->nullable();
            $table->enum('status', ['at_large', 'exorcised', 'sealed', 'contained'])->default('at_large');
            $table->timestamp('first_sighted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curses');
    }
};

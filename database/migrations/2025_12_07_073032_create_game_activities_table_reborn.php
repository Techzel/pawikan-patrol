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
        Schema::create('game_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('game_type'); // 'memory-match', 'puzzle', 'find-the-pawikan'
            $table->integer('score')->default(0);
            $table->integer('time_spent')->default(0); // in seconds
            $table->integer('moves')->nullable(); // For Memory Match & Puzzle
            $table->string('difficulty')->nullable(); // For Puzzle (easy/medium/hard)
            $table->timestamp('played_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_activities');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('game_type'); // quiz, word_scramble, etc.
            $table->string('game_name'); // specific game name/title
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->decimal('accuracy', 5, 2)->default(0.00); // percentage
            $table->integer('time_spent')->default(0); // in seconds
            $table->json('game_data')->nullable(); // store additional game-specific data
            $table->string('difficulty_level')->default('medium'); // easy, medium, hard
            $table->boolean('completed')->default(false);
            $table->timestamp('played_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('user_id');
            $table->index('game_type');
            $table->index('score');
            $table->index('played_at');
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

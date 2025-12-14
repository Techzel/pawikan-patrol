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
        Schema::dropIfExists('game_activities');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('game_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('game_type'); // 'word-scramble', 'quiz', etc.
            $table->integer('score');
            $table->integer('level')->default(1);
            $table->integer('time_spent')->default(0); // in seconds
            $table->float('accuracy')->default(0); // percentage
            $table->string('status')->default('completed'); // 'completed', 'abandoned'
            $table->timestamp('played_at');
            $table->timestamps();
        });
    }
};

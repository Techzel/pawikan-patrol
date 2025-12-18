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
        Schema::table('game_activities', function (Blueprint $table) {
            $table->index(['game_type', 'time_spent']); // For leaderboard sorting
            $table->index(['user_id', 'game_type']); // For user stats
            $table->index(['game_type', 'difficulty']); // For difficulty filtering
            $table->index('played_at'); // For recent activities
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_activities', function (Blueprint $table) {
            $table->dropIndex(['game_type', 'time_spent']);
            $table->dropIndex(['user_id', 'game_type']);
            $table->dropIndex(['game_type', 'difficulty']);
            $table->dropIndex(['played_at']);
        });
    }
};

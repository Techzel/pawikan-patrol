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
        Schema::create('patroller_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('patroller_id')->unique(); // e.g., PTR-0001
            $table->string('badge_number')->nullable()->unique();
            $table->string('rank')->default('Junior Patroller');
            $table->text('bio')->nullable();
            $table->string('department')->nullable();
            $table->json('patrol_areas')->nullable();
            $table->timestamp('patrol_since')->nullable();
            
            // Statistics (Aggregated for easy access)
            $table->integer('total_patrols')->default(0);
            $table->integer('turtles_saved')->default(0);
            $table->integer('nests_protected')->default(0);
            $table->decimal('performance_rating', 3, 2)->default(0.00);
            
            $table->timestamps();
            
            // Indexes
            $table->index('rank');
            $table->index('patroller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patroller_profiles');
    }
};

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
        Schema::create('patrollers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('patroller_id')->unique();
            $table->string('badge_number')->nullable();
            $table->string('department')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->json('certifications')->nullable();
            $table->json('training_completed')->nullable();
            $table->json('specializations')->nullable();
            $table->json('equipment_assigned')->nullable();
            $table->string('status')->default('active');
            $table->json('availability_schedule')->nullable();
            $table->decimal('performance_rating', 3, 2)->nullable();
            $table->date('last_performance_review')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index('patroller_id');
            $table->index('badge_number');
            $table->index('status');
            $table->index('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrollers');
    }
};

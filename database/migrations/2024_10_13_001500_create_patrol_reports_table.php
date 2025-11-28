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
        Schema::create('patrol_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patroller_id')->constrained('users')->onDelete('cascade');
            $table->string('report_type'); // incident, observation, maintenance, emergency
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('priority')->default('medium'); // low, medium, high, critical
            $table->string('status')->default('submitted'); // submitted, under_review, resolved, closed
            $table->json('images')->nullable(); // Array of image paths
            $table->json('evidence')->nullable(); // Additional evidence data
            $table->integer('turtle_count')->nullable(); // For turtle sighting reports
            $table->string('turtle_species')->nullable(); // Species observed
            $table->string('turtle_condition')->nullable(); // healthy, injured, dead
            $table->string('weather_conditions')->nullable();
            $table->text('immediate_actions')->nullable(); // Actions taken by patroller
            $table->text('recommendations')->nullable(); // Patroller recommendations
            $table->boolean('requires_followup')->default(false);
            $table->timestamp('incident_datetime')->nullable(); // When the incident occurred
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['patroller_id', 'created_at']);
            $table->index(['status', 'priority']);
            $table->index(['report_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrol_reports');
    }
};

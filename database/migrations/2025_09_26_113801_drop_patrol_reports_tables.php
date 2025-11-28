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
        // Drop the patrol_report_photos table first due to foreign key constraint
        Schema::dropIfExists('patrol_report_photos');
        
        // Drop the patrol_reports table
        Schema::dropIfExists('patrol_reports');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the tables if needed (this would restore the original structure)
        // This is typically not needed for drop migrations
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration removes 3 unused/redundant tables from the database:
     * 
     * 1. patrollers - Redundant table (all data is in users table)
     * 2. ecological_submissions - Unused feature (never implemented)
     * 3. verification_documents - Unused table (verification uses users table)
     * 
     * All tables are empty (0 records) and not used by the application.
     */
    public function up(): void
    {
        // Drop patrollers table - redundant with users table
        // Users table already has: patroller_id, patroller_since, area_assignment, phone, status
        Schema::dropIfExists('patrollers');
        
        // Drop ecological_submissions table - feature never implemented
        // No routes, no views, only counted in dashboard (always 0)
        Schema::dropIfExists('ecological_submissions');
        
        // Drop verification_documents table - not used
        // Verification system uses users table columns instead
        Schema::dropIfExists('verification_documents');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This down() method is intentionally empty because:
     * 1. All tables being dropped are empty (0 records)
     * 2. The original migration files will be removed
     * 3. These tables are not needed in the application
     * 4. Rolling back would require recreating migrations we've intentionally removed
     */
    public function down(): void
    {
        // Intentionally left empty - these tables are no longer part of the application
    }
};

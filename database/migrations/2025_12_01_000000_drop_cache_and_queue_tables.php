<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration drops the cache and queue-related tables that are no longer needed.
     * The application now uses:
     * - File-based caching instead of database cache
     * - Sync queue driver instead of database queue
     */
    public function up(): void
    {
        // Drop cache tables
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        
        // Drop queue/job tables
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This down() method is intentionally empty because:
     * 1. The original migration files have been removed
     * 2. These tables are no longer needed in the application
     * 3. Rolling back would require recreating migrations we've intentionally removed
     */
    public function down(): void
    {
        // Intentionally left empty - these tables are no longer part of the application
    }
};

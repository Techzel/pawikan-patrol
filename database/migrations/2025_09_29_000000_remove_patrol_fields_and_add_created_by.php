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
        Schema::table('users', function (Blueprint $table) {
            // Remove patrol-related fields
            if (Schema::hasColumn('users', 'patrol_areas')) {
                $table->dropColumn('patrol_areas');
            }
            
            if (Schema::hasColumn('users', 'total_patrols')) {
                $table->dropColumn('total_patrols');
            }
            
            if (Schema::hasColumn('users', 'turtles_saved')) {
                $table->dropColumn('turtles_saved');
            }
            
            if (Schema::hasColumn('users', 'nests_protected')) {
                $table->dropColumn('nests_protected');
            }
            
            if (Schema::hasColumn('users', 'badge_number')) {
                $table->dropColumn('badge_number');
            }
            
            if (Schema::hasColumn('users', 'bio')) {
                $table->dropColumn('bio');
            }
            
            // Add created_by field
            if (!Schema::hasColumn('users', 'created_by')) {
                $table->string('created_by')->nullable()->after('id');
            }
            
        });

        // Set created_by to 'admin' for all existing patrollers with null created_by
        DB::table('users')
            ->where('role', 'patroller')
            ->whereNull('created_by')
            ->update(['created_by' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back the removed fields
            if (!Schema::hasColumn('users', 'patrol_areas')) {
                $table->json('patrol_areas')->nullable()->after('profile_picture');
            }
            
            if (!Schema::hasColumn('users', 'total_patrols')) {
                $table->integer('total_patrols')->default(0)->after('patrol_areas');
            }
            
            if (!Schema::hasColumn('users', 'turtles_saved')) {
                $table->integer('turtles_saved')->default(0)->after('total_patrols');
            }
            
            if (!Schema::hasColumn('users', 'nests_protected')) {
                $table->integer('nests_protected')->default(0)->after('turtles_saved');
            }
            
            if (!Schema::hasColumn('users', 'badge_number')) {
                $table->string('badge_number')->nullable()->after('patroller_id');
            }
            
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('badge_number');
            }
            
            // Remove created_by field
            if (Schema::hasColumn('users', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
    }
};

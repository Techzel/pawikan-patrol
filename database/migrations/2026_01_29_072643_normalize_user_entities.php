<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\PatrollerProfile;
use App\Models\PatrolReport;
use App\Models\PatrolReportPhoto;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 0. Prepare existing tables for migration
        Schema::table('patrol_report_photos', function (Blueprint $table) {
            $table->longText('photo_path')->change();
        });

        // 1. Migrate User Verification Data
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            // Create Verification Record if data exists
            if (!empty($user->verification_status)) {
                DB::table('user_verifications')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'status' => $user->verification_status ?? 'pending',
                        'rejection_reason' => $user->verification_rejection_reason ?? null,
                        'admin_notes' => $user->verification_notes ?? null,
                        'verified_by' => $user->verified_by ?? null,
                        'verified_at' => $user->verified_at ?? null,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]
                );
            }

            // Create Patroller Profile if data exists
            if ($user->role === 'patroller' || !empty($user->patroller_id)) {
                DB::table('patroller_profiles')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'patroller_id' => $user->patroller_id ?? 'PTR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'patrol_since' => $user->patroller_since ?? $user->created_at,
                        'rank' => 'Member',
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]
                );
            }
        }

        // 2. Migrate Patrol Report Photos (JSON -> Photos table)
        $reports = DB::table('patrol_reports')->whereNotNull('images')->get();
        foreach ($reports as $report) {
            $images = json_decode($report->images, true);
            if (is_array($images)) {
                foreach ($images as $index => $path) {
                    // Check if already exists in photos table
                    $exists = DB::table('patrol_report_photos')
                        ->where('patrol_report_id', $report->id)
                        ->where('photo_path', $path)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('patrol_report_photos')->insert([
                            'patrol_report_id' => $report->id,
                            'photo_path' => $path,
                            'display_order' => $index,
                            'created_at' => $report->created_at,
                            'updated_at' => $report->updated_at,
                        ]);
                    }
                }
            }
        }

        // 3. Drop Redundant Columns from Users
        $columnsToDrop = [
            'verification_status', 
            'verification_rejection_reason', 
            'verified_by', 
            'verified_at', 
            'verification_notes',
            'patroller_id',
            'patroller_since',
            'area_assignment'
        ];

        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('users', $column)) {
                // Manually drop known indexes/foreign keys using raw SQL to avoid Blueprint quirks
                try {
                    DB::statement("ALTER TABLE users DROP FOREIGN KEY users_{$column}_foreign");
                } catch (\Exception $e) {}
                
                try {
                    DB::statement("ALTER TABLE users DROP INDEX users_{$column}_foreign");
                } catch (\Exception $e) {}

                try {
                    DB::statement("ALTER TABLE users DROP INDEX users_{$column}_index");
                } catch (\Exception $e) {}

                try {
                    DB::statement("ALTER TABLE users DROP COLUMN {$column}");
                } catch (\Exception $e) {
                    // If everything else fails, try Blueprint drop (last resort)
                    Schema::table('users', function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    });
                }
            }
        }

        // 4. Drop Redundant Columns from Patrol Reports
        Schema::table('patrol_reports', function (Blueprint $table) {
            if (Schema::hasColumn('patrol_reports', 'images')) {
                $table->dropColumn('images');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-adding columns to users (simplified)
        Schema::table('users', function (Blueprint $table) {
            $table->string('verification_status')->nullable();
            $table->text('verification_notes')->nullable();
            $table->string('patroller_id')->nullable();
        });
        
        Schema::table('patrol_reports', function (Blueprint $table) {
            $table->json('images')->nullable();
        });
    }
};

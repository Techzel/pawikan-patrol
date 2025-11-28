<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patroller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StandardizePatrollerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting patroller data standardization...');
        
        // Get all patroller users
        $patrollerUsers = User::where('role', 'patroller')->get();
        $fixedCount = 0;
        $createdProfiles = 0;
        $updatedProfiles = 0;
        
        foreach ($patrollerUsers as $user) {
            $changes = [];
            
            // Fix 1: Ensure created_by is set
            if (empty($user->created_by)) {
                $user->created_by = 'admin';
                $changes[] = 'created_by set to admin';
            }
            
            // Fix 2: Ensure status is set properly
            if (empty($user->status)) {
                $user->status = 'active';
                $changes[] = 'status set to active';
            }
            
            // Fix 3: Ensure is_active is boolean
            if ($user->is_active === null || $user->is_active === '') {
                $user->is_active = true;
                $changes[] = 'is_active set to true';
            }
            
            // Save user changes
            if (!empty($changes)) {
                $user->save();
                $fixedCount++;
                $this->command->info("Fixed user {$user->name} (ID: {$user->id}): " . implode(', ', $changes));
            }
            
            // Fix 4: Ensure patroller profile exists
            $patrollerProfile = $user->patrollerProfile;
            if (!$patrollerProfile) {
                // Create missing patroller profile
                Patroller::create([
                    'user_id' => $user->id,
                    'patroller_id' => $user->patroller_id ?? 'PTR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'department' => 'Field Operations',
                    'status' => 'active',
                    'performance_rating' => 3.0,
                    'certifications' => [],
                    'training_completed' => [],
                    'specializations' => [],
                    'equipment_assigned' => [],
                    'availability_schedule' => [],
                ]);
                $createdProfiles++;
                $this->command->info("Created patroller profile for user {$user->name} (ID: {$user->id})");
            } else {
                // Fix existing profile inconsistencies
                $profileChanges = [];
                
                // Ensure patroller_id is set
                if (empty($patrollerProfile->patroller_id)) {
                    $patrollerProfile->patroller_id = 'PTR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                    $profileChanges[] = 'patroller_id set';
                }
                
                // Ensure department is set
                if (empty($patrollerProfile->department)) {
                    $patrollerProfile->department = 'Field Operations';
                    $profileChanges[] = 'department set to Field Operations';
                }
                
                // Ensure status is set
                if (empty($patrollerProfile->status)) {
                    $patrollerProfile->status = 'active';
                    $profileChanges[] = 'status set to active';
                }
                
                // Ensure performance_rating is set
                if ($patrollerProfile->performance_rating === null) {
                    $patrollerProfile->performance_rating = 3.0;
                    $profileChanges[] = 'performance_rating set to 3.0';
                }
                
                // Ensure arrays are properly initialized
                $arrayFields = ['certifications', 'training_completed', 'specializations', 'equipment_assigned', 'availability_schedule'];
                foreach ($arrayFields as $field) {
                    if ($patrollerProfile->$field === null) {
                        $patrollerProfile->$field = [];
                        $profileChanges[] = "{$field} initialized as empty array";
                    }
                }
                
                if (!empty($profileChanges)) {
                    $patrollerProfile->save();
                    $updatedProfiles++;
                    $this->command->info("Updated patroller profile for user {$user->name} (ID: {$user->id}): " . implode(', ', $profileChanges));
                }
            }
        }
        
        // Fix 5: Handle orphaned patroller profiles (profiles without users)
        $orphanedProfiles = Patroller::whereDoesntHave('user')->count();
        if ($orphanedProfiles > 0) {
            Patroller::whereDoesntHave('user')->delete();
            $this->command->info("Deleted {$orphanedProfiles} orphaned patroller profiles");
        }
        
        // Summary
        $this->command->info('=== Patroller Data Standardization Complete ===');
        $this->command->info("Total patroller users processed: {$patrollerUsers->count()}");
        $this->command->info("Users fixed: {$fixedCount}");
        $this->command->info("Patroller profiles created: {$createdProfiles}");
        $this->command->info("Patroller profiles updated: {$updatedProfiles}");
        $this->command->info("Orphaned profiles deleted: {$orphanedProfiles}");
        
        Log::info('Patroller data standardization completed', [
            'total_users' => $patrollerUsers->count(),
            'users_fixed' => $fixedCount,
            'profiles_created' => $createdProfiles,
            'profiles_updated' => $updatedProfiles,
            'orphaned_deleted' => $orphanedProfiles
        ]);
    }
}

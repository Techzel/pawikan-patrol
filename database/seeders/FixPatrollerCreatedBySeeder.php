<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FixPatrollerCreatedBySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update all existing patrollers with null created_by to show 'admin'
        $updatedCount = User::where('role', 'patroller')
            ->whereNull('created_by')
            ->update(['created_by' => 'admin']);

        $this->command->info("Updated {$updatedCount} patrollers to have 'admin' as created_by");
    }
}

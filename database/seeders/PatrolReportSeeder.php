<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PatrolReport;
use App\Models\User;
use Carbon\Carbon;

class PatrolReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a patroller user (or create one if none exists)
        $patroller = User::where('role', 'patroller')->first();
        
        if (!$patroller) {
            $patroller = User::create([
                'name' => 'Test Patroller',
                'email' => 'patroller@test.com',
                'password' => bcrypt('password'),
                'role' => 'patroller',
                'verification_status' => 'verified'
            ]);
        }

        // Sample validated patrol reports around Dahican Beach area
        $reports = [
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'nesting',
                'title' => 'Olive Ridley Nesting Activity',
                'description' => 'Observed female olive ridley turtle coming ashore to nest. Nest site marked and protected.',
                'location' => 'Dahican Beach, North Section',
                'latitude' => 6.9575,
                'longitude' => 126.2825,
                'priority' => 'high',
                'status' => 'verified',
                'turtle_species' => 'olive_ridley',
                'turtle_count' => 1,
                'turtle_condition' => 'healthy',
                'weather_conditions' => 'Clear night, calm sea',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'sighting',
                'title' => 'Green Sea Turtle Sighting',
                'description' => 'Multiple green sea turtles spotted feeding near the reef area.',
                'location' => 'Dahican Beach, Reef Area',
                'latitude' => 6.9545,
                'longitude' => 126.2835,
                'priority' => 'medium',
                'status' => 'verified',
                'turtle_species' => 'green_sea_turtle',
                'turtle_count' => 3,
                'turtle_condition' => 'healthy',
                'weather_conditions' => 'Sunny, moderate waves',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'incident',
                'title' => 'Injured Hawksbill Turtle Found',
                'description' => 'Found hawksbill turtle with minor shell damage, possibly from boat propeller. Turtle rescued and taken to rehabilitation center.',
                'location' => 'Dahican Beach, South Section',
                'latitude' => 6.9525,
                'longitude' => 126.2795,
                'priority' => 'critical',
                'status' => 'verified',
                'turtle_species' => 'hawksbill',
                'turtle_count' => 1,
                'turtle_condition' => 'injured',
                'weather_conditions' => 'Overcast, rough sea',
                'immediate_actions' => 'Turtle transported to Mati City Marine Rescue Center',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subHours(12),
                'created_at' => Carbon::now()->subHours(12),
            ],
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'rescue',
                'title' => 'Hatchling Release Success',
                'description' => 'Successfully released 87 olive ridley hatchlings into the sea. All hatchlings appeared healthy and active.',
                'location' => 'Dahican Beach, Central Area',
                'latitude' => 6.9555,
                'longitude' => 126.2811,
                'priority' => 'low',
                'status' => 'verified',
                'turtle_species' => 'olive_ridley',
                'turtle_count' => 87,
                'turtle_condition' => 'healthy',
                'weather_conditions' => 'Clear evening, calm sea',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'observation',
                'title' => 'Leatherback Turtle Tracks',
                'description' => 'Large tracks observed on beach, consistent with leatherback turtle. No turtle sighted but nest area identified and marked.',
                'location' => 'Dahican Beach, East Section',
                'latitude' => 6.9565,
                'longitude' => 126.2845,
                'priority' => 'medium',
                'status' => 'verified',
                'turtle_species' => 'leatherback',
                'turtle_count' => 1,
                'turtle_condition' => 'unknown',
                'weather_conditions' => 'Early morning, light breeze',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subDays(4),
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'patroller_id' => $patroller->id,
                'report_type' => 'nesting',
                'title' => 'Green Sea Turtle Nesting',
                'description' => 'Female green sea turtle successfully nested. Approximately 110 eggs laid. Nest protected with barrier.',
                'location' => 'Dahican Beach, West Section',
                'latitude' => 6.9535,
                'longitude' => 126.2785,
                'priority' => 'high',
                'status' => 'verified',
                'turtle_species' => 'green_sea_turtle',
                'turtle_count' => 1,
                'turtle_condition' => 'healthy',
                'weather_conditions' => 'Night patrol, clear sky',
                'validation_status' => PatrolReport::VALIDATION_APPROVED,
                'validated_at' => Carbon::now(),
                'incident_datetime' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($reports as $reportData) {
            PatrolReport::create($reportData);
        }

        $this->command->info('✅ Created ' . count($reports) . ' validated patrol reports with coordinates in Dahican area');
    }
}

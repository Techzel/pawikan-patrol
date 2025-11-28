<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PatrolReport;

class UpdateReportCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:update-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patrol reports with coordinates based on their location';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating patrol report coordinates...');

        // Get all validated reports without coordinates
        $reports = PatrolReport::where('validation_status', PatrolReport::VALIDATION_APPROVED)
            ->where(function($query) {
                $query->whereNull('latitude')
                      ->orWhereNull('longitude');
            })
            ->get();

        if ($reports->isEmpty()) {
            $this->info('No validated reports found without coordinates.');
            return 0;
        }

        $this->info("Found {$reports->count()} validated reports without coordinates.");
        
        $updated = 0;
        
        foreach ($reports as $report) {
            $this->line("\nReport #{$report->id}: {$report->title}");
            $this->line("Location: {$report->location}");
            
            // Ask for coordinates
            $latitude = $this->ask('Enter latitude (or press Enter to skip)');
            
            if (empty($latitude)) {
                $this->warn('Skipped');
                continue;
            }
            
            $longitude = $this->ask('Enter longitude');
            
            if (empty($longitude)) {
                $this->warn('Skipped - longitude required');
                continue;
            }
            
            // Validate coordinates
            if (!is_numeric($latitude) || !is_numeric($longitude)) {
                $this->error('Invalid coordinates. Must be numeric.');
                continue;
            }
            
            // Update report
            $report->latitude = $latitude;
            $report->longitude = $longitude;
            $report->save();
            
            $this->info("✅ Updated Report #{$report->id} with coordinates: [{$latitude}, {$longitude}]");
            $updated++;
        }
        
        $this->newLine();
        $this->info("✅ Successfully updated {$updated} report(s) with coordinates.");
        
        return 0;
    }
}

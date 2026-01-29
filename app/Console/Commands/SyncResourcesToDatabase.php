<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ResourceMetadata;
use Illuminate\Support\Facades\Storage;

class SyncResourcesToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resources:sync-to-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync existing PDF resources from storage to database as base64 for persistence in ephemeral environments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sync of resources to database...');

        $files = Storage::disk('public')->files('resources');
        $syncedCount = 0;

        foreach ($files as $file) {
            if (!str_ends_with(strtolower($file), '.pdf')) {
                continue;
            }

            $filename = basename($file);
            $this->line("Processing: {$filename}");

            try {
                $content = Storage::disk('public')->get($file);
                $base64 = base64_encode($content);

                $meta = ResourceMetadata::firstOrNew(['filename' => $filename]);
                
                // Only update if base64_data is empty to avoid overwriting newer DB versions with older disk files
                if (!$meta->base64_data) {
                    $meta->base64_data = $base64;
                    
                    if (!$meta->exists) {
                        $meta->title = $filename;
                        $meta->description = 'Imported from storage';
                        $meta->published_date = date('Y-m-d', Storage::disk('public')->lastModified($file));
                    }
                    
                    $meta->save();
                    $syncedCount++;
                    $this->info("✓ Synced {$filename}");
                } else {
                    $this->warn("- Skipped {$filename} (Already in DB)");
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to sync {$filename}: {$e->getMessage()}");
            }
        }

        $this->info("Sync complete! Total resources synced: {$syncedCount}");
    }
}

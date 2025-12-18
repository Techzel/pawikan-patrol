<?php

namespace App\Http\Controllers;

use App\Models\PatrolReport;
use Illuminate\Http\Request;

class PatrolMapController extends Controller
{
    /**
     * Display the patrol map with validated reports.
     */
    public function index()
    {
        // Get all validated reports with latitude and longitude
        $validatedReports = PatrolReport::where(function($query) {
                $query->where('validation_status', PatrolReport::VALIDATION_APPROVED)
                      ->orWhere('status', 'validated')
                      ->orWhere('status', 'verified');
            })
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('id', 'title', 'description', 'location', 'latitude', 'longitude', 'report_type', 'priority', 'incident_datetime', 'turtle_species', 'turtle_count', 'turtle_condition', 'gender', 'egg_count', 'created_at', 'patroller_id', 'images')
            ->with(['patroller:id,name', 'user:id,name'])
            ->limit(200)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'description' => $report->description,
                    'location' => $report->location,
                    'latitude' => (float)$report->latitude,
                    'longitude' => (float)$report->longitude,
                    'report_type' => $report->report_type,
                    'priority' => $report->priority,
                    'incident_datetime' => $report->incident_datetime ? $report->incident_datetime->format('M d, Y h:i A') : null,
                    'turtle_species' => $report->turtle_species,
                    'turtle_count' => $report->turtle_count,
                    'turtle_condition' => $report->turtle_condition,
                    'turtle_gender' => $report->gender,
                    'egg_count' => $report->egg_count,
                    'reported_at' => $report->created_at->format('M d, Y'),
                    'reported_by' => $report->patroller ? $report->patroller->name : ($report->user ? $report->user->name : 'Unknown'),
                    'images' => $report->images ?? []
                ];
            });

        return view('patrol-map', compact('validatedReports'));
    }

    /**
     * Get validated reports as JSON for AJAX requests.
     */
    public function getValidatedReports()
    {
        $reports = PatrolReport::where(function($query) {
                $query->where('validation_status', PatrolReport::VALIDATION_APPROVED)
                      ->orWhere('status', 'validated')
                      ->orWhere('status', 'verified');
            })
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('id', 'title', 'description', 'location', 'latitude', 'longitude', 'report_type', 'priority', 'incident_datetime', 'turtle_species', 'turtle_count', 'turtle_condition', 'gender', 'egg_count', 'created_at', 'patroller_id', 'images')
            ->with(['patroller:id,name', 'user:id,name'])
            ->limit(200)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'description' => $report->description,
                    'location' => $report->location,
                    'latitude' => (float)$report->latitude,
                    'longitude' => (float)$report->longitude,
                    'report_type' => $report->report_type,
                    'priority' => $report->priority,
                    'incident_datetime' => $report->incident_datetime ? $report->incident_datetime->format('M d, Y h:i A') : null,
                    'turtle_species' => $report->turtle_species,
                    'turtle_count' => $report->turtle_count,
                    'turtle_condition' => $report->turtle_condition,
                    'turtle_gender' => $report->gender,
                    'egg_count' => $report->egg_count,
                    'images' => $report->images ?? [],
                    'patroller_name' => $report->patroller ? $report->patroller->name : ($report->user ? $report->user->name : 'Unknown'),
                    'created_at' => $report->created_at->format('M d, Y')
                ];
            });

        return response()->json($reports);
    }

    public function gallery()
    {
        // Step 1: Fetch matching reports without sorting in SQL to avoid 'Out of sort memory' error.
        // We fetch only the necessary columns to keep the memory usage in PHP low.
        try {
            // Attempt to increase sort buffer for this session just in case, 
            // though we are moving sorting to PHP.
            \Illuminate\Support\Facades\DB::statement('SET SESSION sort_buffer_size = 1048576 * 2');
        } catch (\Exception $e) {
            // Ignore if the database user doesn't have permission to set session variables
        }

        $reportsCollection = PatrolReport::where(function($query) {
                $query->where('validation_status', PatrolReport::VALIDATION_APPROVED)
                      ->orWhere('status', 'validated')
                      ->orWhere('status', 'verified');
            })
            ->whereNotNull('images')
            ->select('id', 'created_at', 'images')
            ->get();

        // Step 2: Filter and sort in PHP. This is much safer when DB sort memory is restricted.
        $reportIds = $reportsCollection->filter(function($report) {
                $imgs = is_string($report->images) ? json_decode($report->images, true) : $report->images;
                return !empty($imgs) && (is_array($imgs) || is_object($imgs));
            })
            ->sortByDesc('created_at')
            ->take(100)
            ->pluck('id');

        if ($reportIds->isEmpty()) {
            return view('patrol-map-gallery', [
                'reports' => collect(),
                'stats' => [
                    'total_reports' => 0,
                    'total_images' => 0,
                    'species_count' => 0,
                    'locations_count' => 0
                ]
            ]);
        }

        // Step 3: Fetch the full details for the specific 100 IDs.
        // No sorting needed here as we already have the IDs in order.
        $reports = PatrolReport::whereIn('id', $reportIds)
            ->with(['patroller:id,name', 'user:id,name'])
            ->get()
            // Ensure the collection matches the original ID order (descending by created_at)
            ->sortBy(function($report) use ($reportIds) {
                return array_search($report->id, $reportIds->toArray());
            })
            ->values()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'description' => $report->description,
                    'location' => $report->location,
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'report_type' => $report->report_type,
                    'priority' => $report->priority,
                    'incident_datetime' => $report->incident_datetime ? $report->incident_datetime->format('M d, Y h:i A') : null,
                    'turtle_species' => $report->turtle_species,
                    'turtle_count' => $report->turtle_count,
                    'turtle_condition' => $report->turtle_condition,
                    'turtle_gender' => $report->gender,
                    'egg_count' => $report->egg_count,
                    'weather_conditions' => $report->weather_conditions,
                    'reported_at' => $report->created_at->format('M d, Y'),
                    'reported_by' => $report->patroller ? $report->patroller->name : ($report->user ? $report->user->name : 'Unknown'),
                    'images' => is_string($report->images) ? json_decode($report->images, true) : $report->images
                ];
            });

        // Get statistics (calculate globally for all validated reports, not just the displayed 100)
        $statsQuery = PatrolReport::where(function($query) {
                $query->where('validation_status', PatrolReport::VALIDATION_APPROVED)
                      ->orWhere('status', 'validated')
                      ->orWhere('status', 'verified');
            })
            ->whereNotNull('images')
            ->where('images', '!=', '[]')
            ->select('id', 'turtle_species', 'location', 'images');

        $allMatchingReports = $statsQuery->get();

        $stats = [
            'total_reports' => $allMatchingReports->count(),
            'total_images' => $allMatchingReports->sum(function($report) {
                // Handle different image storage formats safely
                $imgs = is_string($report->images) ? json_decode($report->images, true) : $report->images;
                return is_array($imgs) ? count($imgs) : 0;
            }),
            'species_count' => $allMatchingReports->pluck('turtle_species')->filter()->unique()->count(),
            'locations_count' => $allMatchingReports->pluck('location')->filter()->unique()->count()
        ];

        return view('patrol-map-gallery', compact('reports', 'stats'));
    }
}

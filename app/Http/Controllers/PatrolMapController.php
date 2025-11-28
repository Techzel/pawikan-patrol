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
        $validatedReports = PatrolReport::where('validation_status', PatrolReport::VALIDATION_APPROVED)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['patroller', 'user'])
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
        $reports = PatrolReport::where('validation_status', PatrolReport::VALIDATION_APPROVED)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['patroller', 'user'])
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

    /**
     * Display the gallery of patrol reports with images.
     */
    public function gallery()
    {
        // Get only 3 most recent validated reports with images
        $reports = PatrolReport::where('validation_status', PatrolReport::VALIDATION_APPROVED)
            ->whereNotNull('images')
            ->where('images', '!=', '[]')
            ->with(['patroller', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
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
                    'additional_notes' => $report->additional_notes,
                    'reported_at' => $report->created_at->format('M d, Y'),
                    'reported_by' => $report->patroller ? $report->patroller->name : ($report->user ? $report->user->name : 'Unknown'),
                    'images' => is_string($report->images) ? json_decode($report->images, true) : $report->images
                ];
            });

        // Get statistics
        $stats = [
            'total_reports' => $reports->count(),
            'total_images' => $reports->sum(function($report) {
                return count($report['images'] ?? []);
            }),
            'species_count' => $reports->pluck('turtle_species')->filter()->unique()->count(),
            'locations_count' => $reports->pluck('location')->filter()->unique()->count()
        ];

        return view('patrol-map-gallery', compact('reports', 'stats'));
    }
}

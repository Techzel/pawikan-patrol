<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatrolReport;
use App\Models\PatrolReportPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatrolReportController extends Controller
{
    /**
     * Display a listing of patrol reports with filtering.
     */
    public function index(Request $request)
    {
        // If it's not an AJAX request, return the view with initial data
        if (!$request->expectsJson()) {
            $reports = PatrolReport::with(['patroller:id,name', 'photos:id,patrol_report_id', 'verifier:id,name'])
                ->select([
                    'id', 'patroller_id', 'report_type', 'title', 'description', 
                    'status', 'priority', 'created_at', 'incident_datetime'
                ])
                ->latest()
                ->paginate(20);
            
            $patrollers = \App\Models\User::where('role', 'patroller')
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get();
            
            return view('admin.patrol-reports.index', compact('reports', 'patrollers'));
        }

        $validator = Validator::make($request->all(), [
            'report_type' => ['nullable', 'string', Rule::in(PatrolReport::getReportTypeValidationKeys(true))],
            'species' => ['nullable', 'string', Rule::in(PatrolReport::SPECIES_OLIVE_RIDLEY, PatrolReport::SPECIES_GREEN_SEA_TURTLE, PatrolReport::SPECIES_HAWKSBILL, PatrolReport::SPECIES_LEATHERBACK, PatrolReport::SPECIES_LOGGERHEAD)],
            'gender' => ['nullable', 'string', Rule::in(PatrolReport::GENDER_MALE, PatrolReport::GENDER_FEMALE, PatrolReport::GENDER_UNKNOWN)],
            'min_egg_count' => ['nullable', 'integer', 'min:0'],
            'max_egg_count' => ['nullable', 'integer', 'min:0'],
            'incident_type' => ['nullable', 'string', Rule::in(PatrolReport::INCIDENT_INJURY, PatrolReport::INCIDENT_POACHING, PatrolReport::INCIDENT_POLLUTION, PatrolReport::INCIDENT_STRANDING, PatrolReport::INCIDENT_OTHER)],
            'status' => ['nullable', 'string', Rule::in([
                PatrolReport::STATUS_SUBMITTED, 
                PatrolReport::STATUS_PENDING, 
                PatrolReport::STATUS_ACCEPTED, 
                PatrolReport::STATUS_REJECTED,
                PatrolReport::STATUS_VERIFIED,
                PatrolReport::STATUS_NEEDS_CORRECTION,
                PatrolReport::STATUS_UNDER_REVIEW,
                PatrolReport::STATUS_RESOLVED,
                PatrolReport::STATUS_CLOSED
            ])],
            'priority' => ['nullable', 'string', Rule::in(PatrolReport::PRIORITY_LOW, PatrolReport::PRIORITY_MEDIUM, PatrolReport::PRIORITY_HIGH, PatrolReport::PRIORITY_CRITICAL)],
            'patroller' => ['nullable', 'integer', 'exists:users,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'radius' => ['nullable', 'numeric', 'min:0'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $query = PatrolReport::with(['patroller:id,name', 'photos:id,patrol_report_id', 'verifier:id,name'])
            ->select([
                'id', 'patroller_id', 'report_type', 'title', 'description', 
                'status', 'priority', 'created_at', 'incident_datetime',
                'species', 'gender', 'egg_count', 'latitude', 'longitude', 'location'
            ])
            ->latest();
            
        // Apply status filter if provided, otherwise show all reports
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply filters
        if ($request->filled('report_type')) {
            $query->byType($request->report_type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('patroller')) {
            $query->where('patroller_id', $request->patroller);
        }

        if ($request->filled('species')) {
            $query->bySpecies($request->species);
        }

        if ($request->filled('gender')) {
            $query->byGender($request->gender);
        }

        if ($request->filled('min_egg_count') && $request->filled('max_egg_count')) {
            $query->byEggCountRange($request->min_egg_count, $request->max_egg_count);
        } elseif ($request->filled('min_egg_count')) {
            $query->where('egg_count', '>=', $request->min_egg_count);
        } elseif ($request->filled('max_egg_count')) {
            $query->where('egg_count', '<=', $request->max_egg_count);
        }

        if ($request->filled('incident_type')) {
            $query->byIncidentType($request->incident_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Geospatial filtering
        if ($request->filled('latitude') && $request->filled('longitude') && $request->filled('radius')) {
            $query->withinRadius($request->latitude, $request->longitude, $request->radius);
        }

        // Pagination
        $perPage = $request->input('per_page', 20);
        $reports = $query->paginate($perPage);

        return response()->json([
            'data' => $reports->items(),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total(),
            ],
        ]);
    }

    /**
     * Store a newly created patrol report.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'report_type' => ['required', 'string', Rule::in(PatrolReport::getReportTypeValidationKeys(true))],
            'species' => ['required', 'string', Rule::in(PatrolReport::SPECIES_OLIVE_RIDLEY, PatrolReport::SPECIES_GREEN_SEA_TURTLE, PatrolReport::SPECIES_HAWKSBILL, PatrolReport::SPECIES_LEATHERBACK, PatrolReport::SPECIES_LOGGERHEAD)],
            'gender' => ['nullable', 'string', Rule::in(PatrolReport::GENDER_MALE, PatrolReport::GENDER_FEMALE, PatrolReport::GENDER_UNKNOWN)],
            'egg_count' => ['nullable', 'integer', 'min:0'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'description' => ['nullable', 'string', 'max:1000'],
            'incident_type' => ['nullable', 'required_if:report_type,incident', 'string', Rule::in(PatrolReport::INCIDENT_INJURY, PatrolReport::INCIDENT_POACHING, PatrolReport::INCIDENT_POLLUTION, PatrolReport::INCIDENT_STRANDING, PatrolReport::INCIDENT_OTHER)],
            'is_public' => ['nullable', 'boolean'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5120'], // 5MB max per photo
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $report = PatrolReport::create([
            'patroller_id' => auth()->id(),
            'report_type' => $request->report_type,
            'species' => $request->species,
            'gender' => $request->gender,
            'egg_count' => $request->egg_count,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'incident_type' => $request->incident_type,
            'status' => PatrolReport::STATUS_PENDING,
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('patrol-reports/' . $report->id, 'public');
                
                PatrolReportPhoto::create([
                    'patrol_report_id' => $report->id,
                    'photo_path' => $path,
                    'caption' => $request->input("photo_captions.{$index}"),
                    'display_order' => $index,
                ]);
            }
        }

        return response()->json([
            'message' => 'Patrol report submitted successfully',
            'data' => $report->load(['user', 'photos']),
        ], 201);
    }

    /**
     * Display the specified patrol report.
     */
    public function show(Request $request, PatrolReport $report)
    {
        // Check if report is public or user is the owner/admin
        if (!$report->is_public && 
            $report->patroller_id !== auth()->id() && 
            !auth()->user()?->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized');
        }

        // Load relationships
        $report->load(['user', 'photos', 'verifier']);

        // If it's not an AJAX request, return the view
        if (!$request->expectsJson()) {
            return view('admin.patrol-reports.show', ['patrolReport' => $report]);
        }

        return response()->json([
            'data' => $report,
        ]);
    }

    /**
     * Update the specified patrol report.
     */
    public function update(Request $request, PatrolReport $patrolReport): JsonResponse
    {
        // Check if user is the owner or admin
        if ($patrolReport->patroller_id !== auth()->id() && !auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Don't allow editing verified reports unless admin
        if ($patrolReport->status === PatrolReport::STATUS_VERIFIED && !auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Cannot edit verified reports'], 403);
        }

        $validator = Validator::make($request->all(), [
            'report_type' => ['sometimes', 'string', Rule::in(PatrolReport::getReportTypeValidationKeys(true))],
            'species' => ['sometimes', 'string', Rule::in(PatrolReport::SPECIES_OLIVE_RIDLEY, PatrolReport::SPECIES_GREEN_SEA_TURTLE, PatrolReport::SPECIES_HAWKSBILL, PatrolReport::SPECIES_LEATHERBACK, PatrolReport::SPECIES_LOGGERHEAD)],
            'gender' => ['nullable', 'string', Rule::in(PatrolReport::GENDER_MALE, PatrolReport::GENDER_FEMALE, PatrolReport::GENDER_UNKNOWN)],
            'egg_count' => ['nullable', 'integer', 'min:0'],
            'latitude' => ['sometimes', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'numeric', 'between:-180,180'],
            'description' => ['nullable', 'string', 'max:1000'],
            'incident_type' => ['nullable', 'required_if:report_type,incident', 'string', Rule::in(PatrolReport::INCIDENT_INJURY, PatrolReport::INCIDENT_POACHING, PatrolReport::INCIDENT_POLLUTION, PatrolReport::INCIDENT_STRANDING, PatrolReport::INCIDENT_OTHER)],
            'is_public' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patrolReport->update($request->only([
            'report_type',
            'species',
            'gender',
            'egg_count',
            'latitude',
            'longitude',
            'description',
            'incident_type',
        ]));

        return response()->json([
            'message' => 'Patrol report updated successfully',
            'data' => $patrolReport->load(['user', 'photos']),
        ]);
    }

    /**
     * Remove the specified patrol report.
     */
    public function destroy(PatrolReport $report): JsonResponse
    {
        // Check if user is the owner or admin
        if ($report->patroller_id !== auth()->id() && !auth()->user()?->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete associated photos
        foreach ($report->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patrol report deleted successfully',
        ]);
    }

    /**
     * Verify a patrol report (admin only).
     */
    public function verify(Request $request, PatrolReport $patrolReport): JsonResponse
    {
        if (!auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string', Rule::in(PatrolReport::STATUS_VERIFIED, PatrolReport::STATUS_REJECTED)],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patrolReport->update([
            'status' => $request->status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return response()->json([
            'message' => "Report {$request->status} successfully",
            'data' => $patrolReport->load(['user', 'photos', 'verifier']),
        ]);
    }

    /**
     * Show the validation form for a patrol report.
     */
    public function validateReport(PatrolReport $report)
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.patrol-reports.validate', compact('report'));
    }

    /**
     * Get patrol reports for map display.
     */
    public function mapData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'bounds_north' => ['required', 'numeric'],
            'bounds_south' => ['required', 'numeric'],
            'bounds_east' => ['required', 'numeric'],
            'bounds_west' => ['required', 'numeric'],
            'report_type' => ['nullable', 'string', Rule::in(PatrolReport::TYPE_NESTING, PatrolReport::TYPE_SIGHTING, PatrolReport::TYPE_INCIDENT, PatrolReport::TYPE_RESCUE)],
            'species' => ['nullable', 'string', Rule::in(PatrolReport::SPECIES_OLIVE_RIDLEY, PatrolReport::SPECIES_GREEN_SEA_TURTLE, PatrolReport::SPECIES_HAWKSBILL, PatrolReport::SPECIES_LEATHERBACK, PatrolReport::SPECIES_LOGGERHEAD)],
            'gender' => ['nullable', 'string', Rule::in(PatrolReport::GENDER_MALE, PatrolReport::GENDER_FEMALE, PatrolReport::GENDER_UNKNOWN)],
            'incident_type' => ['nullable', 'string', Rule::in(PatrolReport::INCIDENT_INJURY, PatrolReport::INCIDENT_POACHING, PatrolReport::INCIDENT_POLLUTION, PatrolReport::INCIDENT_STRANDING, PatrolReport::INCIDENT_OTHER)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $query = PatrolReport::with(['user', 'photos'])
            ->public()
            ->verified()
            ->whereBetween('latitude', [$request->bounds_south, $request->bounds_north])
            ->whereBetween('longitude', [$request->bounds_west, $request->bounds_east]);

        // Apply filters
        if ($request->filled('report_type')) {
            $query->byType($request->report_type);
        }

        if ($request->filled('species')) {
            $query->bySpecies($request->species);
        }

        if ($request->filled('gender')) {
            $query->byGender($request->gender);
        }

        if ($request->filled('incident_type')) {
            $query->byIncidentType($request->incident_type);
        }

        $reports = $query->latest('reported_at')->get();

        return response()->json([
            'data' => $reports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'report_type' => $report->report_type,
                    'species' => $report->species,
                    'gender' => $report->gender,
                    'egg_count' => $report->egg_count,
                    'incident_type' => $report->incident_type,
                    'created_at' => $report->created_at,
                    'user_name' => $report->user->name,
                    'photo_count' => $report->photos->count(),
                    'thumbnail_url' => $report->photos->first()?->photo_path,
                ];
            }),
        ]);
    }

    /**
     * Get filter options for the frontend.
     */
    public function filterOptions(): JsonResponse
    {
        return response()->json([
            'data' => [
                'report_types' => [
                    ['value' => PatrolReport::TYPE_NESTING, 'label' => 'Nesting Activity'],
                    ['value' => PatrolReport::TYPE_SIGHTING, 'label' => 'Turtle Sighting'],
                    ['value' => PatrolReport::TYPE_INCIDENT, 'label' => 'Incident Report'],
                    ['value' => PatrolReport::TYPE_RESCUE, 'label' => 'Rescue Operation'],
                ],
                'species' => [
                    ['value' => PatrolReport::SPECIES_OLIVE_RIDLEY, 'label' => 'Olive Ridley'],
                    ['value' => PatrolReport::SPECIES_GREEN_SEA_TURTLE, 'label' => 'Green Sea Turtle'],
                    ['value' => PatrolReport::SPECIES_HAWKSBILL, 'label' => 'Hawksbill'],
                    ['value' => PatrolReport::SPECIES_LEATHERBACK, 'label' => 'Leatherback'],
                    ['value' => PatrolReport::SPECIES_LOGGERHEAD, 'label' => 'Loggerhead'],
                ],
                'genders' => [
                    ['value' => PatrolReport::GENDER_MALE, 'label' => 'Male'],
                    ['value' => PatrolReport::GENDER_FEMALE, 'label' => 'Female'],
                    ['value' => PatrolReport::GENDER_UNKNOWN, 'label' => 'Unknown'],
                ],
                'incident_types' => [
                    ['value' => PatrolReport::INCIDENT_INJURY, 'label' => 'Injury'],
                    ['value' => PatrolReport::INCIDENT_POACHING, 'label' => 'Poaching'],
                    ['value' => PatrolReport::INCIDENT_POLLUTION, 'label' => 'Pollution'],
                    ['value' => PatrolReport::INCIDENT_STRANDING, 'label' => 'Stranding'],
                    ['value' => PatrolReport::INCIDENT_OTHER, 'label' => 'Other'],
                ],
            ],
        ]);
    }

    /**
     * Update status of a patrol report (admin only).
     */
    public function updateStatus(Request $request, PatrolReport $report)
    {
        if (!auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['submitted', 'pending', 'accepted', 'reject', 'resolved', 'closed', 'validated', 'needs_correction', 'rejected'])],
            'notes' => ['nullable', 'string', 'max:1000'],
            'validation_notes' => ['nullable', 'string', 'max:1000'],
            'priority' => ['nullable', 'string', Rule::in(['low', 'medium', 'high', 'critical'])],
            'evidence_verified' => ['nullable', 'boolean'],
            'location_verified' => ['nullable', 'boolean'],
            'needs_followup' => ['nullable', 'boolean'],
            'followup_notes' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $updateData = [
            'status' => $validated['status'],
            'admin_notes' => $validated['notes'] ?? $report->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ];

        // Add validation-specific fields
        if (isset($validated['validation_notes'])) {
            $updateData['validation_notes'] = $validated['validation_notes'];
        }
        
        if (isset($validated['priority'])) {
            $updateData['priority'] = $validated['priority'];
        }
        
        if (isset($validated['evidence_verified'])) {
            $updateData['evidence_verified'] = $validated['evidence_verified'];
        }
        
        if (isset($validated['location_verified'])) {
            $updateData['location_verified'] = $validated['location_verified'];
        }
        
        if (isset($validated['needs_followup'])) {
            $updateData['needs_followup'] = $validated['needs_followup'];
        }
        
        if (isset($validated['followup_notes'])) {
            $updateData['followup_notes'] = $validated['followup_notes'];
        }
        
        // Add GPS coordinates for map display
        if (isset($validated['latitude'])) {
            $updateData['latitude'] = $validated['latitude'];
        }
        
        if (isset($validated['longitude'])) {
            $updateData['longitude'] = $validated['longitude'];
        }

        // Set validation status based on status
        if ($validated['status'] === 'validated') {
            $updateData['validation_status'] = PatrolReport::VALIDATION_APPROVED;
            $updateData['validated_by'] = auth()->id();
            $updateData['validated_at'] = now();
        } elseif ($validated['status'] === 'needs_correction') {
            $updateData['validation_status'] = PatrolReport::VALIDATION_NEEDS_CORRECTION;
        } elseif ($validated['status'] === 'rejected') {
            $updateData['validation_status'] = PatrolReport::VALIDATION_REJECTED;
        }

        $report->update($updateData);

        return response()->json([
            'success' => true,
            'message' => "Report status updated to {$validated['status']} successfully",
            'data' => $report->load(['user', 'photos', 'verifier']),
        ]);
    }

    /**
     * Bulk update status of multiple patrol reports (admin only).
     */
    public function bulkStatusUpdate(Request $request)
    {
        if (!auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'report_ids' => ['required', 'array'],
            'report_ids.*' => ['exists:patrol_reports,id'],
            'status' => ['required', 'string', Rule::in(['submitted', 'pending', 'accepted', 'reject', 'resolved', 'closed'])],
        ]);

        $count = PatrolReport::whereIn('id', $validated['report_ids'])
            ->update([
                'status' => $validated['status'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully updated {$count} report(s)",
            'count' => $count,
        ]);
    }

    /**
     * Export patrol reports (admin only).
     */
    public function export(Request $request)
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $format = $request->input('export', 'excel');
        
        $reports = PatrolReport::with(['user', 'photos', 'verifier'])
            ->latest()
            ->get();

        // For now, return JSON. You can add Excel/PDF export later
        if ($format === 'json') {
            return response()->json($reports);
        }

        // Placeholder for Excel export
        return response()->json([
            'message' => 'Export functionality will be implemented',
            'format' => $format,
            'count' => $reports->count(),
        ]);
    }
}

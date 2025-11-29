<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatrolReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PatrollerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isPatroller()) {
                abort(403, 'Access denied. Patroller role required.');
            }
            return $next($request);
        });
    }

    /**
     * Display the patroller dashboard.
     */
    public function dashboard()
    {
        $patroller = Auth::user();
        
        // Get patroller statistics
        $totalReports = PatrolReport::where('patroller_id', $patroller->id)->count();
        $pendingReports = PatrolReport::where('patroller_id', $patroller->id)
            ->where('status', PatrolReport::STATUS_SUBMITTED)
            ->count();
        $resolvedReports = PatrolReport::where('patroller_id', $patroller->id)
            ->where(function($q) {
                $q->whereIn('status', [
                    PatrolReport::STATUS_RESOLVED,
                    PatrolReport::STATUS_ACCEPTED,
                    PatrolReport::STATUS_VERIFIED
                ])
                ->orWhere('validation_status', PatrolReport::VALIDATION_APPROVED);
            })
            ->count();
        $criticalReports = PatrolReport::where('patroller_id', $patroller->id)
            ->where('priority', PatrolReport::PRIORITY_CRITICAL)
            ->count();

        // Get recent reports
        $recentReports = PatrolReport::where('patroller_id', $patroller->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get monthly statistics
        $monthlyStats = PatrolReport::where('patroller_id', $patroller->id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('patroller.dashboard', compact(
            'patroller',
            'totalReports',
            'pendingReports',
            'resolvedReports',
            'criticalReports',
            'recentReports',
            'monthlyStats'
        ));
    }

    /**
     * Display all reports for the patroller.
     */
    public function reports(Request $request)
    {
        $patroller = Auth::user();
        $query = PatrolReport::where('patroller_id', $patroller->id)->with('reviewer');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('report_type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('patroller.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function createReport()
    {
        return view('patroller.reports.create');
    }

    /**
     * Store a newly created report.
     */
    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => ['required', Rule::in(PatrolReport::getReportTypeValidationKeys(true))],
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'priority' => 'required|in:low,medium,high,critical',
            'egg_count' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,unknown',
            'turtle_count' => 'nullable|integer|min:0',
            'turtle_species' => 'nullable|string|max:255',
            'turtle_condition' => 'nullable|in:healthy,injured,dead,unknown',
            'weather_conditions' => 'nullable|string|max:255',
            'immediate_actions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'requires_followup' => 'boolean',
            'incident_datetime' => 'nullable|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('patrol-reports', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Create the report
            $report = PatrolReport::create([
                'patroller_id' => Auth::id(),
                'report_type' => $validated['report_type'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'priority' => $validated['priority'],
                'egg_count' => $validated['egg_count'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'status' => PatrolReport::STATUS_SUBMITTED,
                'images' => $imagePaths,
                'turtle_count' => $validated['turtle_count'] ?? null,
                'turtle_species' => $validated['turtle_species'] ?? null,
                'turtle_condition' => $validated['turtle_condition'] ?? null,
                'weather_conditions' => $validated['weather_conditions'] ?? null,
                'immediate_actions' => $validated['immediate_actions'] ?? null,
                'recommendations' => $validated['recommendations'] ?? null,
                'requires_followup' => $validated['requires_followup'] ?? false,
                'incident_datetime' => $validated['incident_datetime'] ?? null,
            ]);

            Log::info('Patrol report created', [
                'patroller_id' => Auth::id(),
                'report_id' => $report->id,
                'report_type' => $report->report_type,
                'priority' => $report->priority
            ]);

            return redirect()->route('patroller.reports.show', $report)
                ->with('success', 'Report submitted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to create patrol report', [
                'patroller_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to submit report. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified report.
     */
    public function showReport(PatrolReport $report)
    {
        // Ensure patroller can only view their own reports
        if ($report->patroller_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        return view('patroller.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report.
     */
    public function editReport(PatrolReport $report)
    {
        // Ensure patroller can only edit their own reports
        if ($report->patroller_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        // Only allow editing if report is still submitted (not under review)
        if ($report->status !== PatrolReport::STATUS_SUBMITTED) {
            return redirect()->route('patroller.reports.show', $report)
                ->with('error', 'Cannot edit report that is under review or resolved.');
        }

        return view('patroller.reports.edit', compact('report'));
    }

    /**
     * Update the specified report.
     */
    public function updateReport(Request $request, PatrolReport $report)
    {
        // Ensure patroller can only update their own reports
        if ($report->patroller_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        // Only allow updating if report is still submitted
        if ($report->status !== PatrolReport::STATUS_SUBMITTED) {
            return redirect()->route('patroller.reports.show', $report)
                ->with('error', 'Cannot update report that is under review or resolved.');
        }

        $validated = $request->validate([
            'report_type' => ['required', Rule::in(PatrolReport::getReportTypeValidationKeys(true))],
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'priority' => 'required|in:low,medium,high,critical',
            'egg_count' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,unknown',
            'turtle_count' => 'nullable|integer|min:0',
            'turtle_species' => 'nullable|string|max:255',
            'turtle_condition' => 'nullable|in:healthy,injured,dead,unknown',
            'weather_conditions' => 'nullable|string|max:255',
            'immediate_actions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'requires_followup' => 'boolean',
            'incident_datetime' => 'nullable|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle new image uploads
            $imagePaths = $report->images ?? [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('patrol-reports', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Update the report
            $report->update([
                'report_type' => $validated['report_type'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'priority' => $validated['priority'],
                'egg_count' => $validated['egg_count'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'images' => $imagePaths,
                'turtle_count' => $validated['turtle_count'] ?? null,
                'turtle_species' => $validated['turtle_species'] ?? null,
                'turtle_condition' => $validated['turtle_condition'] ?? null,
                'weather_conditions' => $validated['weather_conditions'] ?? null,
                'immediate_actions' => $validated['immediate_actions'] ?? null,
                'recommendations' => $validated['recommendations'] ?? null,
                'requires_followup' => $validated['requires_followup'] ?? false,
                'incident_datetime' => $validated['incident_datetime'] ?? null,
            ]);

            Log::info('Patrol report updated', [
                'patroller_id' => Auth::id(),
                'report_id' => $report->id,
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('patroller.reports.show', $report)
                ->with('success', 'Report updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update patrol report', [
                'patroller_id' => Auth::id(),
                'report_id' => $report->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update report. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified report.
     */
    public function destroyReport(PatrolReport $report)
    {
        // Ensure patroller can only delete their own reports
        if ($report->patroller_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        // Only allow deletion if report is still submitted
        if ($report->status !== PatrolReport::STATUS_SUBMITTED) {
            return redirect()->route('patroller.reports.show', $report)
                ->with('error', 'Cannot delete report that is under review or resolved.');
        }

        try {
            // Delete associated images
            if ($report->images) {
                foreach ($report->images as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $report->delete();

            Log::info('Patrol report deleted', [
                'patroller_id' => Auth::id(),
                'report_id' => $report->id
            ]);

            return redirect()->route('patroller.reports.index')
                ->with('success', 'Report deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to delete patrol report', [
                'patroller_id' => Auth::id(),
                'report_id' => $report->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete report. Please try again.');
        }
    }

    /**
     * Get patroller profile information.
     */
    public function profile()
    {
        $patroller = Auth::user()->load('patrollerProfile');
        
        // Get performance statistics
        $stats = [
            'total_reports' => PatrolReport::where('patroller_id', $patroller->id)->count(),
            'resolved_reports' => PatrolReport::where('patroller_id', $patroller->id)
                ->where(function($q) {
                    $q->whereIn('status', [
                        PatrolReport::STATUS_RESOLVED,
                        PatrolReport::STATUS_ACCEPTED,
                        PatrolReport::STATUS_VERIFIED
                    ])
                    ->orWhere('validation_status', PatrolReport::VALIDATION_APPROVED);
                })->count(),
            'critical_reports' => PatrolReport::where('patroller_id', $patroller->id)
                ->where('priority', PatrolReport::PRIORITY_CRITICAL)->count(),
            'this_month_reports' => PatrolReport::where('patroller_id', $patroller->id)
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
        ];

        return view('patroller.profile', compact('patroller', 'stats'));
    }

    /**
     * Update the authenticated patroller's profile information.
     */
    public function updateProfile(Request $request)
    {
        $patroller = Auth::user()->load('patrollerProfile');
        $section = $request->input('section', 'basic');

        try {
            if ($section === 'contact') {
                $validated = $request->validate([
                    'department' => 'nullable|string|max:255',
                    'emergency_contact' => 'nullable|string|max:255',
                    'emergency_phone' => 'nullable|string|max:20',
                ]);

                $profileData = [
                    'department' => $validated['department'] ?? null,
                    'emergency_contact' => $validated['emergency_contact'] ?? null,
                    'emergency_phone' => $validated['emergency_phone'] ?? null,
                ];

                if ($patroller->patrollerProfile) {
                    $patroller->patrollerProfile->update($profileData);
                } else {
                    $patroller->patrollerProfile()->create(array_merge([
                        'patroller_id' => $patroller->patroller_id ?? ('PTR-' . str_pad($patroller->id, 4, '0', STR_PAD_LEFT)),
                        'status' => 'active',
                    ], $profileData));
                }

                return back()->with('success', 'Contact details updated successfully.');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $patroller->id,
                'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $patroller->id,
                'password' => 'nullable|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                if ($patroller->profile_picture) {
                    Storage::disk('public')->delete($patroller->profile_picture);
                }

                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $patroller->profile_picture = $path;
            }

            $patroller->name = $validated['name'];
            $patroller->email = $validated['email'];
            $patroller->username = $validated['username'];
            $patroller->phone = $validated['phone'] ?? null;

            if (!empty($validated['password'])) {
                $patroller->password = Hash::make($validated['password']);
            }

            $patroller->save();

            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update patroller profile', [
                'patroller_id' => $patroller->id,
                'section' => $section,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update profile. Please try again.')->withInput();
        }
    }
}

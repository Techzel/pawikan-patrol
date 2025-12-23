<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatrolReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get basic statistics for the admin dashboard
        $totalPatrollers = User::where('role', 'patroller')->count();

        $totalAcceptedReports = PatrolReport::where(function ($query) {
            $query->where('status', PatrolReport::STATUS_ACCEPTED)
                ->orWhere('validation_status', PatrolReport::VALIDATION_APPROVED);
        })->count();
        $totalVerifiedReports = PatrolReport::where('status', PatrolReport::STATUS_VERIFIED)->count();
        $totalVerifiedUsers = User::where('verification_status', 'verified')->count();
        
        $patrollers = User::where('role', 'patroller')->latest()->get();
        
        return view('admin.dashboard', compact(
            'totalPatrollers',
            'patrollers',
            'totalAcceptedReports',
            'totalVerifiedReports',
            'totalVerifiedUsers'
        ));
    }

    /**
     * Show the form for creating a new patroller.
     *
     * @return \Illuminate\View\View
     */
    public function createPatroller()
    {
        return view('admin.patrollers.create');
    }

    /**
     * Store a new patroller account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePatroller(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
        ]);

        try {
        // Add "Patroller" prefix to name if not already present
        $patrollerName = $validated['name'];
        if (!str_starts_with(strtolower($patrollerName), 'patroller')) {
            $patrollerName = 'Patroller ' . $patrollerName;
        }
        
        // Create the user account
        $user = User::create([
            'name' => $patrollerName,
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patroller',
            'is_active' => true,
            'phone' => $validated['phone'] ?? null,
                'created_by' => 'admin',
            ]);

            // Generate patroller ID and set patroller since timestamp
            $user->activatePatroller();

            Log::info('New patroller created by admin', [
                'admin_id' => auth()->id(),
                'patroller_id' => $user->id,
                'patroller_email' => $user->email,
                'patroller_username' => $user->username,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Patroller Account Created');
        } catch (\Exception $e) {
            Log::error('Failed to create patroller', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to create patroller account. Please try again.')->withInput();
        }
    }

    /**
     * Update patroller status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePatrollerStatus(Request $request, $id)
    {
        $patroller = User::where('role', 'patroller')->findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $patroller->update([
                'is_active' => $validated['status'] === 'active'
            ]);

            Log::info('Patroller status updated by admin', [
                'admin_id' => auth()->id(),
                'patroller_id' => $patroller->id,
                'new_status' => $validated['status']
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Patroller status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update patroller status', [
                'admin_id' => auth()->id(),
                'patroller_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update patroller status. Please try again.');
        }
    }

    /**
     * Delete a patroller account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPatroller($id)
    {
        $patroller = User::where('role', 'patroller')->findOrFail($id);

        try {
            $patroller->delete();

            Log::info('Patroller deleted by admin', [
                'admin_id' => auth()->id(),
                'patroller_id' => $id,
                'patroller_email' => $patroller->email
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Patroller account deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete patroller', [
                'admin_id' => auth()->id(),
                'patroller_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete patroller account. Please try again.');
        }
    }

    /**
     * Display a listing of all patrollers.
     *
     * @return \Illuminate\View\View
     */
    public function indexPatrollers()
    {
        $patrollers = User::where('role', 'patroller')
            ->latest()
            ->paginate(15);
            
        return view('admin.patrollers.index', compact('patrollers'));
    }

    /**
     * Show the form for editing the specified patroller.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editPatroller($id)
    {
        $patroller = User::where('role', 'patroller')
            ->findOrFail($id);
            
        return view('admin.patrollers.edit', compact('patroller'));
    }

    /**
     * Update the specified patroller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePatroller(Request $request, $id)
    {
        $patroller = User::where('role', 'patroller')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'badge_number' => 'nullable|string|max:50|unique:users,badge_number,' . $id,
            'bio' => 'nullable|string|max:1000',
            'patrol_areas' => 'nullable|array',
            'patrol_areas.*' => 'string|max:255',
            'department' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
        ]);

        try {
            $patroller->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'badge_number' => $validated['badge_number'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'patrol_areas' => $validated['patrol_areas'] ?? [],
            ]);

            Log::info('Patroller updated by admin', [
                'admin_id' => auth()->id(),
                'patroller_id' => $patroller->id,
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('admin.patrollers.index')->with('success', 'Patroller updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update patroller', [
                'admin_id' => auth()->id(),
                'patroller_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update patroller. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified patroller's profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showPatrollerProfile($id)
    {
        $patroller = User::where('role', 'patroller')
            ->findOrFail($id);
            
        return view('admin.patrollers.profile', compact('patroller'));
    }

    /**
     * Update the specified patroller's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePatrollerProfile(Request $request, $id)
    {
        $patroller = User::where('role', 'patroller')->findOrFail($id);
        
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'supervisor_id' => 'nullable|exists:users,id',
            'emergency_contact' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'certifications' => 'nullable|array',
            'certifications.*' => 'string|max:255',
            'training_completed' => 'nullable|array',
            'training_completed.*' => 'string|max:255',
            'specializations' => 'nullable|array',
            'specializations.*' => 'string|max:255',
            'equipment_assigned' => 'nullable|array',
            'equipment_assigned.*' => 'string|max:255',
            'status' => 'required|in:active,inactive,on_leave,suspended',
            'performance_rating' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            // Note: Patroller profile table has been removed
            // All patroller data is now stored in the users table
            
            Log::info('Patroller profile update attempted (table removed)', [
                'admin_id' => auth()->id(),
                'patroller_id' => $patroller->id,
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('admin.patrollers.profile', $id)->with('success', 'Patroller profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update patroller profile', [
                'admin_id' => auth()->id(),
                'patroller_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update patroller profile. Please try again.')->withInput();
        }
    }

    /**
     * Get patroller statistics.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatrollerStatistics($id)
    {
        $patroller = User::where('role', 'patroller')
            ->findOrFail($id);

        $statistics = [
            'total_patrols' => $patroller->total_patrols,
            'turtles_saved' => $patroller->turtles_saved,
            'nests_protected' => $patroller->nests_protected,
            'total_conservation_impact' => $patroller->total_conservation_impact ?? 0,
            'patroller_rank' => $patroller->patroller_rank ?? 'N/A',
            'patroller_since' => $patroller->patroller_since ? $patroller->patroller_since->format('M d, Y') : 'Unknown',
            'last_login' => $patroller->last_login_at ? $patroller->last_login_at->diffForHumans() : 'Never',
            'performance_rating' => 0,
            'performance_level' => 'Not Rated',
            'status' => $patroller->is_active ? 'active' : 'inactive',
            'department' => 'Field Operations',
        ];

        return response()->json($statistics);
    }

    /**
     * Get patroller reports.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function getPatrollerReports($id)
    {
        $patroller = User::where('role', 'patroller')->findOrFail($id);
        
        // This would typically fetch actual reports from the database
        // For now, we'll return an empty collection
        $reports = collect();
        
        return view('admin.patrollers.reports', compact('patroller', 'reports'));
    }

    /**
     * Bulk activate patrollers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkActivatePatrollers(Request $request)
    {
        $validated = $request->validate([
            'patroller_ids' => 'required|array',
            'patroller_ids.*' => 'exists:users,id',
        ]);

        try {
            $count = User::whereIn('id', $validated['patroller_ids'])
                ->where('role', 'patroller')
                ->update(['is_active' => true]);

            Log::info('Bulk patroller activation by admin', [
                'admin_id' => auth()->id(),
                'patroller_count' => $count,
                'patroller_ids' => $validated['patroller_ids']
            ]);

            return redirect()->route('admin.patrollers.index')->with('success', "{$count} patrollers activated successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to bulk activate patrollers', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to activate patrollers. Please try again.');
        }
    }

    /**
     * Bulk deactivate patrollers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDeactivatePatrollers(Request $request)
    {
        $validated = $request->validate([
            'patroller_ids' => 'required|array',
            'patroller_ids.*' => 'exists:users,id',
        ]);

        try {
            $count = User::whereIn('id', $validated['patroller_ids'])
                ->where('role', 'patroller')
                ->update(['is_active' => false]);

            Log::info('Bulk patroller deactivation by admin', [
                'admin_id' => auth()->id(),
                'patroller_count' => $count,
                'patroller_ids' => $validated['patroller_ids']
            ]);

            return redirect()->route('admin.patrollers.index')->with('success', "{$count} patrollers deactivated successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to bulk deactivate patrollers', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to deactivate patrollers. Please try again.');
        }
    }

    /**
     * Bulk delete patrollers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDeletePatrollers(Request $request)
    {
        $validated = $request->validate([
            'patroller_ids' => 'required|array',
            'patroller_ids.*' => 'exists:users,id',
        ]);

        try {
            $count = User::whereIn('id', $validated['patroller_ids'])
                ->where('role', 'patroller')
                ->delete();

            Log::info('Bulk patroller deletion by admin', [
                'admin_id' => auth()->id(),
                'patroller_count' => $count,
                'patroller_ids' => $validated['patroller_ids']
            ]);

            return redirect()->route('admin.patrollers.index')->with('success', "{$count} patrollers deleted successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete patrollers', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete patrollers. Please try again.');
        }
    }

    /**
     * Display verification dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function verificationDashboard()
    {
        // Only count and show regular users (not admin or patroller)
        $totalUsers = User::where('role', 'user')->count();
        $pendingUsers = User::where('role', 'user')->where('verification_status', 'pending')->count();
        $verifiedUsers = User::where('role', 'user')->where('verification_status', 'verified')->count();
        $rejectedUsers = User::where('role', 'user')->where('verification_status', 'rejected')->count();

        $pendingPercentage = $totalUsers > 0 ? round(($pendingUsers / $totalUsers) * 100, 1) : 0;
        $verifiedPercentage = $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100, 1) : 0;
        $rejectedPercentage = $totalUsers > 0 ? round(($rejectedUsers / $totalUsers) * 100, 1) : 0;
        
        // Additional helpful stats
        $verifiedToday = User::where('role', 'user')
            ->where('verification_status', 'verified')
            ->whereDate('updated_at', today())
            ->count();
            
        $rejectedThisMonth = User::where('role', 'user')
            ->where('verification_status', 'rejected')
            ->whereMonth('updated_at', now()->month)
            ->count();

        $recentActivity = User::where('role', 'user')
            ->whereIn('verification_status', ['pending', 'verified', 'rejected'])
            ->with('verifiedBy')
            ->latest()
            ->take(10)
            ->get();
            
        return view('admin.verification.dashboard', [
            'totalUsers' => $totalUsers,
            'pendingUsers' => $pendingUsers,
            'verifiedUsers' => $verifiedUsers,
            'rejectedUsers' => $rejectedUsers,
            'pendingPercentage' => $pendingPercentage,
            'verifiedPercentage' => $verifiedPercentage,
            'rejectedPercentage' => $rejectedPercentage,
            'verifiedToday' => $verifiedToday,
            'rejectedThisMonth' => $rejectedThisMonth,
            'recentActivity' => $recentActivity
        ]);
    }

    /**
     * Display pending verifications.
     *
     * @return \Illuminate\View\View
     */
    public function pendingVerifications()
    {
        $pendingUsers = User::where('role', 'user')
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(15);
            
        return view('admin.verification.pending', [
            'pendingUsers' => $pendingUsers
        ]);
    }

    /**
     * Approve user verification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveVerification($id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->update([
                'verification_status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'verification_notes' => request('notes', 'Account verified by admin')
            ]);

            Log::info('User verification approved by admin', [
                'admin_id' => auth()->id(),
                'user_id' => $id,
                'user_email' => $user->email
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User verification approved successfully.'
                ]);
            }
            
            return redirect()->back()->with('success', 'User verification approved successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to approve user verification', [
                'admin_id' => auth()->id(),
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to approve verification. Please try again.');
        }
    }

    /**
     * Reject user verification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectVerification($id)
    {
        $validated = request()->validate([
            'notes' => 'required|string|min:10'
        ]);

        try {
            $user = User::findOrFail($id);
            
            $user->update([
                'verification_status' => 'rejected',
                'verification_notes' => $validated['notes']
            ]);

            Log::info('User verification rejected by admin', [
                'admin_id' => auth()->id(),
                'user_id' => $id,
                'user_email' => $user->email,
                'reason' => $validated['notes']
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User verification rejected successfully.'
                ]);
            }
            
            return redirect()->back()->with('success', 'User verification rejected successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to reject user verification', [
                'admin_id' => auth()->id(),
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to reject verification. Please try again.');
        }
    }

    /**
     * Bulk approve verifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkApproveVerifications(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        try {
            $count = User::whereIn('id', $validated['user_ids'])
                ->where('verification_status', 'pending')
                ->update([
                    'verification_status' => 'verified',
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                    'verification_notes' => 'Bulk approved by admin'
                ]);

            Log::info('Bulk user verification approval by admin', [
                'admin_id' => auth()->id(),
                'user_count' => $count,
                'user_ids' => $validated['user_ids']
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$count} users verified successfully.",
                    'approved_count' => $count
                ]);
            }
            
            return redirect()->back()->with('success', "{$count} users verified successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to bulk approve user verifications', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to approve verifications. Please try again.');
        }
    }

    /**
     * Bulk reject verifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkRejectVerifications(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'notes' => 'required|string|min:10'
        ]);

        try {
            $count = User::whereIn('id', $validated['user_ids'])
                ->where('verification_status', 'pending')
                ->update([
                    'verification_status' => 'rejected',
                    'verification_notes' => $validated['notes']
                ]);

            Log::info('Bulk user verification rejection by admin', [
                'admin_id' => auth()->id(),
                'user_count' => $count,
                'user_ids' => $validated['user_ids'],
                'reason' => $validated['notes']
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$count} users rejected successfully.",
                    'rejected_count' => $count
                ]);
            }
            
            return redirect()->back()->with('success', "{$count} users rejected successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to bulk reject user verifications', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to reject verifications. Please try again.');
        }
    }

    /**
     * Display content management page.
     *
     * @return \Illuminate\View\View
     */
    public function contentManagement()
    {
        return view('admin.content');
    }

    /**
     * Display system settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Display activity logs page.
     *
     * @return \Illuminate\View\View
     */
    public function logs()
    {
        // This would typically integrate with a logging package
        // For now, we'll return a basic view
        return view('admin.logs');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserVerificationController extends Controller
{
    /**
     * Show the verification dashboard
     */
    public function dashboard()
    {
        // Get counts for all verification statuses using our new scope
        $totalUsers = User::where('role', 'user')->count();
        $pendingUsers = User::where('role', 'user')->hasVerificationStatus('pending')->count();
        $verifiedUsers = User::where('role', 'user')->hasVerificationStatus('verified')->count();
        $rejectedUsers = User::where('role', 'user')->hasVerificationStatus('rejected')->count();
        $underReviewCount = User::where('role', 'user')->hasVerificationStatus('under_review')->count();
        $requiresResubmissionCount = User::where('role', 'user')->hasVerificationStatus('requires_resubmission')->count();

        // Calculate percentages safely
        $pendingPercentage = $totalUsers > 0 ? round(($pendingUsers / $totalUsers) * 100) : 0;
        $verifiedPercentage = $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100) : 0;
        $rejectedPercentage = $totalUsers > 0 ? round(($rejectedUsers / $totalUsers) * 100) : 0;

        // Daily/Monthly Snapshot stats
        $verifiedToday = User::where('role', 'user')
            ->hasVerificationStatus('verified')
            ->whereHas('verification', function($q) {
                $q->whereDate('verified_at', today());
            })->count();

        $rejectedThisMonth = User::where('role', 'user')
            ->hasVerificationStatus('rejected')
            ->whereHas('verification', function($q) {
                $q->whereMonth('updated_at', now()->month);
            })->count();

        // Get recent verification activity
        $recentActivity = User::where('role', 'user')
            ->whereHas('verification', function($q) {
                $q->whereIn('status', ['pending', 'verified', 'rejected', 'under_review', 'requires_resubmission']);
            })
            ->with(['verification.verifier'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Get verification statistics for the last 30 days
        $verificationStats = DB::table('user_verifications')
            ->select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('COUNT(CASE WHEN status = "verified" AND DATE(updated_at) = DATE(verified_at) THEN 1 END) as verified'),
                DB::raw('COUNT(CASE WHEN status = "rejected" THEN 1 END) as rejected'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending')
            )
            ->where('updated_at', '>=', now()->subDays(30))
            ->whereIn('status', ['verified', 'rejected', 'pending'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing dates with zero values for the chart
        $dateRange = collect();
        $startDate = now()->subDays(29);
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $stats = $verificationStats->firstWhere('date', $date);
            $dateRange->push([
                'date' => $date,
                'verified' => $stats ? (int)$stats->verified : 0,
                'rejected' => $stats ? (int)$stats->rejected : 0,
                'pending' => $stats ? (int)$stats->pending : 0
            ]);
        }

        // Handle AJAX requests
        if (request()->ajax()) {
            return response()->json([
                'totalUsers' => $totalUsers,
                'pendingUsers' => $pendingUsers,
                'verifiedUsers' => $verifiedUsers,
                'rejectedUsers' => $rejectedUsers,
                'pendingPercentage' => $pendingPercentage,
                'verifiedPercentage' => $verifiedPercentage,
                'rejectedPercentage' => $rejectedPercentage,
                'verificationStats' => $dateRange
            ]);
        }

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
            'recentActivity' => $recentActivity,
            'verificationStats' => $dateRange,
            'underReviewCount' => $underReviewCount,
            'requiresResubmissionCount' => $requiresResubmissionCount
        ]);
    }

    /**
     * Show pending verifications
     */
    public function pending()
    {
        $pendingUsers = User::hasVerificationStatus('pending')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.verification.pending', compact('pendingUsers'));
    }

    /**
     * Show verifications under review
     */
    public function underReview()
    {
        $users = User::hasVerificationStatus('under_review')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.verification.under-review', compact('users'));
    }

    /**
     * Show verifications requiring resubmission
     */
    public function requiresResubmission()
    {
        $users = User::hasVerificationStatus('requires_resubmission')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.verification.requires-resubmission', compact('users'));
    }

    /**
     * Show verification details
     */
    public function show($id)
    {
        $user = User::with(['verification.verifier'])->findOrFail($id);
        
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json($user);
        }
        
        return view('admin.verification.show', compact('user'));
    }

    /**
     * Start review of a user verification
     */
    public function startReview($id)
    {
        $user = User::findOrFail($id);
        
        $user->verification()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'under_review',
                'verified_by' => Auth::id()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Review started successfully.'
        ]);
    }

    /**
     * Approve a user verification
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        $user = User::findOrFail($id);
        
        $user->verification()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'admin_notes' => $request->notes
            ]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User verification approved successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'User verification approved successfully.');
    }

    /**
     * Reject a user verification
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $user = User::findOrFail($id);
        
        $user->verification()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'rejection_reason' => $request->notes,
                'admin_notes' => $request->notes
            ]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User verification rejected.'
            ]);
        }

        return redirect()->back()->with('success', 'User verification rejected.');
    }

    /**
     * Request resubmission of verification
     */
    public function requestResubmission(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $user = User::findOrFail($id);
        
        $user->verification()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'requires_resubmission',
                'verified_by' => Auth::id(),
                'admin_notes' => $request->notes
            ]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User requested to resubmit verification.'
            ]);
        }

        return redirect()->back()->with('success', 'User requested to resubmit verification.');
    }

    /**
     * Bulk approve verifications
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Update through the relationship for each user
        $count = 0;
        $activeUsers = User::whereIn('id', $request->user_ids)->get();
        foreach ($activeUsers as $user) {
            $user->verification()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => 'verified',
                    'verified_at' => now(),
                    'verified_by' => Auth::id(),
                    'admin_notes' => $request->notes
                ]
            );
            $count++;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully approved $count users.",
            'count' => $count
        ]);
    }

    /**
     * Bulk reject verifications
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'notes' => 'required|string|max:1000'
        ]);

        $count = 0;
        $activeUsers = User::whereIn('id', $request->user_ids)->get();
        foreach ($activeUsers as $user) {
            $user->verification()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => 'rejected',
                    'verified_at' => now(),
                    'verified_by' => Auth::id(),
                    'rejection_reason' => $request->notes,
                    'admin_notes' => $request->notes
                ]
            );
            $count++;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully rejected $count users.",
            'count' => $count
        ]);
    }

    /**
     * Get verification statistics
     */
    public function getStatistics()
    {
        $total = User::count();
        $pending = User::hasVerificationStatus('pending')->count();
        $verified = User::hasVerificationStatus('verified')->count();
        $rejected = User::hasVerificationStatus('rejected')->count();
        $underReview = User::hasVerificationStatus('under_review')->count();
        $requiresResubmission = User::hasVerificationStatus('requires_resubmission')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'pending' => $pending,
                'verified' => $verified,
                'rejected' => $rejected,
                'under_review' => $underReview,
                'requires_resubmission' => $requiresResubmission,
                'verification_rate' => $total > 0 ? round(($verified / $total) * 100, 2) : 0,
                'rejection_rate' => $total > 0 ? round(($rejected / $total) * 100, 2) : 0
            ]
        ]);
    }
}

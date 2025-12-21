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
        // Get counts for all verification statuses
        $totalUsers = User::count();
        $pendingCount = User::where('verification_status', 'pending')->count();
        $verifiedCount = User::where('verification_status', 'verified')->count();
        $rejectedCount = User::where('verification_status', 'rejected')->count();
        $underReviewCount = User::where('verification_status', 'under_review')->count();
        $requiresResubmissionCount = User::where('verification_status', 'requires_resubmission')->count();

        // Get recent verification activity (both pending and completed)
        $recentActivity = User::with('verifiedBy')
            ->whereNotNull('verification_status')
            ->where('verification_status', '!=', 'unverified')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Get verification statistics for the last 30 days
        $verificationStats = User::select(
            DB::raw('DATE(updated_at) as date'),
            DB::raw('COUNT(CASE WHEN verification_status = "verified" AND DATE(updated_at) = DATE(verified_at) THEN 1 END) as verified'),
            DB::raw('COUNT(CASE WHEN verification_status = "rejected" AND DATE(updated_at) = DATE(updated_at) THEN 1 END) as rejected'),
            DB::raw('COUNT(CASE WHEN verification_status = "pending" AND DATE(created_at) = DATE(updated_at) THEN 1 END) as pending')
        )
        ->where('updated_at', '>=', now()->subDays(30))
        ->whereIn('verification_status', ['verified', 'rejected', 'pending'])
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->map(function($item) {
            return [
                'date' => $item->date,
                'verified' => (int)$item->verified,
                'rejected' => (int)$item->rejected,
                'pending' => (int)$item->pending
            ];
        });

        // Fill in missing dates with zero values
        $dateRange = collect();
        $startDate = now()->subDays(29);
        
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $stats = $verificationStats->firstWhere('date', $date) ?? [
                'date' => $date,
                'verified' => 0,
                'rejected' => 0,
                'pending' => 0
            ];
            $dateRange->push($stats);
        }

        // If this is an AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json([
                'totalUsers' => $totalUsers,
                'pendingCount' => $pendingCount,
                'verifiedCount' => $verifiedCount,
                'rejectedCount' => $rejectedCount,
                'underReviewCount' => $underReviewCount,
                'requiresResubmissionCount' => $requiresResubmissionCount,
                'verificationStats' => $dateRange
            ]);
        }

        return view('admin.verification.dashboard', [
            'totalUsers' => $totalUsers,
            'pendingCount' => $pendingCount,
            'verifiedCount' => $verifiedCount,
            'rejectedCount' => $rejectedCount,
            'underReviewCount' => $underReviewCount,
            'requiresResubmissionCount' => $requiresResubmissionCount,
            'recentActivity' => $recentActivity,
            'verificationStats' => $dateRange
        ]);
    }

    /**
     * Show pending verifications
     */
    public function pending()
    {
        $users = User::where('verification_status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.verification.pending', compact('users'));
    }

    /**
     * Show verifications under review
     */
    public function underReview()
    {
        $users = User::where('verification_status', 'under_review')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.verification.under-review', compact('users'));
    }

    /**
     * Show verifications requiring resubmission
     */
    public function requiresResubmission()
    {
        $users = User::where('verification_status', 'requires_resubmission')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.verification.requires-resubmission', compact('users'));
    }

    /**
     * Show verification details
     */
    public function show($id)
    {
        $user = User::with('verifiedBy')->findOrFail($id);
        
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
        
        $user->update([
            'verification_status' => 'under_review',
            'verified_by' => Auth::id()
        ]);

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
        
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_notes' => $request->notes
        ]);

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
        
        $user->update([
            'verification_status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_notes' => $request->notes
        ]);

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
        
        $user->update([
            'verification_status' => 'requires_resubmission',
            'verified_by' => Auth::id(),
            'verification_notes' => $request->notes
        ]);

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

        $count = User::whereIn('id', $request->user_ids)
            ->update([
                'verification_status' => 'verified',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'verification_notes' => $request->notes
            ]);

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

        $count = User::whereIn('id', $request->user_ids)
            ->update([
                'verification_status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'verification_notes' => $request->notes
            ]);

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
        $pending = User::where('verification_status', 'pending')->count();
        $verified = User::where('verification_status', 'verified')->count();
        $rejected = User::where('verification_status', 'rejected')->count();
        $underReview = User::where('verification_status', 'under_review')->count();
        $requiresResubmission = User::where('verification_status', 'requires_resubmission')->count();

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

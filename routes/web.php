<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PatrolReportController;
use App\Http\Controllers\Admin\PatrollerController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Games\GameActivityController;

// Public Routes
Route::get('/', function () {
    return view('LandingPage');
});

Route::get('/3d-explorer', function () {
    return view('3d-explorer');
});

use App\Http\Controllers\PatrolMapController;

Route::get('/patrol-map', [PatrolMapController::class, 'index'])->name('patrol-map');
Route::get('/patrol-map/gallery', [PatrolMapController::class, 'gallery'])->name('patrol-map.gallery');
Route::get('/api/validated-reports', [PatrolMapController::class, 'getValidatedReports']);

Route::get('/games', function () {
    return view('games.index');
});

Route::get('/games/quiz', function () {
    return view('games.quiz');
});

Route::get('/games/word-scramble', function () {
    return view('games.word-scramble');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Auth form (login/register)
    Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth.form');
    
    // Login routes
    Route::get('/login', function () {
        return redirect('/auth');
    })->name('login.redirect');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    // Registration routes
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    // Test route for register form (can be removed if not needed)
    Route::get('/test-register', function () {
        return view('auth.test-register');
    })->name('test.register');
});

// API route removed - now handled by PatrolMapController

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // API Routes for AJAX calls
    Route::prefix('api')->group(function () {
        Route::get('/users/{id}', function ($id) {
            // Check if user is admin
            if (!auth()->user() || auth()->user()->role !== 'admin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            $user = \App\Models\User::findOrFail($id);
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username ?? 'N/A',
                'role' => $user->role,
                'status' => $user->status ?? 'active',
                'verification_status' => $user->verification_status,
                'verification_notes' => $user->verification_notes,
                'verified_at' => $user->verified_at ? $user->verified_at->format('M j, Y g:i A') : null,
                'created_at' => $user->created_at->format('M j, Y g:i A'),
                'updated_at' => $user->updated_at->format('M j, Y g:i A')
            ]);
        })->name('api.users.show');
    });
    
    // Patrol Map Routes
    Route::post('/patrol-map/visit-location', [AuthController::class, 'visitLocation'])->name('patrol-map.visit-location');
    
    // Leaderboards Route
    Route::get('/leaderboards', function () {
        $user = Auth::user();
        $overallRank = $user->getOverallRank();
        $quizRank = $user->getGameRank('quiz');
        $wordScrambleRank = $user->getGameRank('word_scramble');
        
        // Get leaderboard data
        $gameActivityController = new \App\Http\Controllers\Games\GameActivityController();
        
        // Overall leaderboard (all games)
        $overallResponse = $gameActivityController->leaderboard();
        $overallLeaderboard = collect($overallResponse->getData()->leaderboard);
        
        // Quiz leaderboard
        $quizResponse = $gameActivityController->leaderboard('quiz');
        $quizLeaderboard = collect($quizResponse->getData()->leaderboard);
        
        // Word Scramble leaderboard
        $wordScrambleResponse = $gameActivityController->leaderboard('word_scramble');
        $wordScrambleLeaderboard = collect($wordScrambleResponse->getData()->leaderboard);
        
        return view('leaderboards', compact(
            'user', 
            'overallRank', 
            'quizRank', 
            'wordScrambleRank',
            'overallLeaderboard',
            'quizLeaderboard',
            'wordScrambleLeaderboard'
        ));
    })->name('leaderboards');
    
    // Game Activity Routes (JSON responses for AJAX calls)
    Route::prefix('game-activities')->group(function () {
        Route::post('/record', [GameActivityController::class, 'record'])->name('game-activities.record');
        Route::get('/', [GameActivityController::class, 'index'])->name('game-activities.index');
        Route::get('/statistics', [GameActivityController::class, 'statistics'])->name('game-activities.statistics');
        Route::get('/best-scores', [GameActivityController::class, 'bestScores'])->name('game-activities.best-scores');
        Route::get('/leaderboard/{gameType?}', [GameActivityController::class, 'leaderboard'])->name('game-activities.leaderboard');
        Route::delete('/{id}', [GameActivityController::class, 'destroy'])->name('game-activities.destroy');
    });
    
    // Patroller Routes
    Route::prefix('patroller')->middleware('auth')->group(function () {
        Route::get('/dashboard', [PatrollerController::class, 'dashboard'])->name('patroller.dashboard');
        Route::get('/profile', [PatrollerController::class, 'profile'])->name('patroller.profile');
        Route::put('/profile', [PatrollerController::class, 'updateProfile'])->name('patroller.profile.update');
        
        // Report Routes
        Route::prefix('reports')->group(function () {
            Route::get('/', [PatrollerController::class, 'reports'])->name('patroller.reports.index');
            Route::get('/create', [PatrollerController::class, 'createReport'])->name('patroller.reports.create');
            Route::post('/store', [PatrollerController::class, 'storeReport'])->name('patroller.reports.store');
            Route::get('/{report}', [PatrollerController::class, 'showReport'])->name('patroller.reports.show');
            Route::get('/{report}/edit', [PatrollerController::class, 'editReport'])->name('patroller.reports.edit');
            Route::put('/{report}', [PatrollerController::class, 'updateReport'])->name('patroller.reports.update');
            Route::delete('/{report}', [PatrollerController::class, 'destroyReport'])->name('patroller.reports.destroy');
        });
    });

    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/recent-activities', [GameActivityController::class, 'recentGlobal'])->name('admin.recent-activities');
    });
    
    // Admin Dashboard Routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Patroller Management
        Route::prefix('patrollers')->group(function () {
            // Patroller CRUD operations
            Route::get('/', [AdminController::class, 'indexPatrollers'])->name('admin.patrollers.index');
            Route::get('/create', [AdminController::class, 'createPatroller'])->name('admin.patrollers.create');
            Route::post('/store', [AdminController::class, 'storePatroller'])->name('admin.patrollers.store');
            Route::get('/{id}/edit', [AdminController::class, 'editPatroller'])->name('admin.patrollers.edit');
            Route::put('/{id}', [AdminController::class, 'updatePatroller'])->name('admin.patrollers.update');
            Route::put('/{id}/status', [AdminController::class, 'updatePatrollerStatus'])->name('admin.patrollers.update-status');
            Route::delete('/{id}', [AdminController::class, 'destroyPatroller'])->name('admin.patrollers.destroy');
            
            // Patroller profile management
            Route::get('/{id}/profile', [AdminController::class, 'showPatrollerProfile'])->name('admin.patrollers.profile');
            Route::put('/{id}/profile', [AdminController::class, 'updatePatrollerProfile'])->name('admin.patrollers.update-profile');
            
            // Patroller statistics and reports
            Route::get('/{id}/statistics', [AdminController::class, 'getPatrollerStatistics'])->name('admin.patrollers.statistics');
            Route::get('/{id}/reports', [AdminController::class, 'getPatrollerReports'])->name('admin.patrollers.reports');
            
            // Bulk operations
            Route::post('/bulk-activate', [AdminController::class, 'bulkActivatePatrollers'])->name('admin.patrollers.bulk-activate');
            Route::post('/bulk-deactivate', [AdminController::class, 'bulkDeactivatePatrollers'])->name('admin.patrollers.bulk-deactivate');
            Route::post('/bulk-delete', [AdminController::class, 'bulkDeletePatrollers'])->name('admin.patrollers.bulk-delete');
            
            // User verification management (Legacy)
            Route::get('/verification', [AdminController::class, 'verificationDashboard'])->name('admin.verification.index');
            Route::get('/verification/pending', [AdminController::class, 'pendingVerifications'])->name('admin.verification.pending');
            Route::put('/verification/{id}/approve', [AdminController::class, 'approveVerification'])->name('admin.verification.approve');
            Route::put('/verification/{id}/reject', [AdminController::class, 'rejectVerification'])->name('admin.verification.reject');
            Route::post('/verification/bulk-approve', [AdminController::class, 'bulkApproveVerifications'])->name('admin.verification.bulk-approve');
            Route::post('/verification/bulk-reject', [AdminController::class, 'bulkRejectVerifications'])->name('admin.verification.bulk-reject');
            
            // New User Verification System
            Route::prefix('verification-new')->group(function () {
                Route::get('/dashboard', [UserVerificationController::class, 'dashboard'])->name('admin.verification-new.dashboard');
                Route::get('/pending', [UserVerificationController::class, 'pending'])->name('admin.verification-new.pending');
                Route::get('/under-review', [UserVerificationController::class, 'underReview'])->name('admin.verification-new.under-review');
                Route::get('/requires-resubmission', [UserVerificationController::class, 'requiresResubmission'])->name('admin.verification-new.requires-resubmission');
                Route::get('/{id}', [UserVerificationController::class, 'show'])->name('admin.verification-new.show');
                Route::post('/{id}/start-review', [UserVerificationController::class, 'startReview'])->name('admin.verification-new.start-review');
                Route::post('/{id}/approve', [UserVerificationController::class, 'approve'])->name('admin.verification-new.approve');
                Route::post('/{id}/reject', [UserVerificationController::class, 'reject'])->name('admin.verification-new.reject');
                Route::post('/{id}/request-resubmission', [UserVerificationController::class, 'requestResubmission'])->name('admin.verification-new.request-resubmission');
                Route::post('/bulk-approve', [UserVerificationController::class, 'bulkApprove'])->name('admin.verification-new.bulk-approve');
                Route::post('/bulk-reject', [UserVerificationController::class, 'bulkReject'])->name('admin.verification-new.bulk-reject');
                Route::get('/statistics', [UserVerificationController::class, 'getStatistics'])->name('admin.verification-new.statistics');
            });
        });
        
        // Patrol Reports Management
        Route::prefix('patrol-reports')->group(function () {
            Route::get('/', [PatrolReportController::class, 'index'])
                ->name('admin.patrol-reports.index');
            Route::get('/export', [PatrolReportController::class, 'export'])
                ->name('admin.patrol-reports.export');
            Route::get('/{report}', [PatrolReportController::class, 'show'])
                ->name('admin.patrol-reports.show');
            Route::get('/{report}/validate', [PatrolReportController::class, 'validateReport'])
                ->name('admin.patrol-reports.validate');
            Route::patch('/{report}/status', [PatrolReportController::class, 'updateStatus'])
                ->name('admin.patrol-reports.update-status');
            Route::delete('/{report}', [PatrolReportController::class, 'destroy'])
                ->name('admin.patrol-reports.destroy');
            Route::patch('/bulk-status-update', [PatrolReportController::class, 'bulkStatusUpdate'])
                ->name('admin.patrol-reports.bulk-status-update');
        });

        // Ecological Submissions Review
        Route::prefix('submissions')->group(function () {
            Route::get('/', [AdminController::class, 'submissions'])->name('admin.submissions');
            Route::get('/pending', [AdminController::class, 'submissions'])->name('admin.submissions.pending');
            Route::get('/approved', [AdminController::class, 'submissions'])->name('admin.submissions.approved');
            Route::get('/rejected', [AdminController::class, 'submissions'])->name('admin.submissions.rejected');
            Route::put('/{id}/status', [AdminController::class, 'updateSubmissionStatus'])->name('admin.submissions.update-status');
        });
        
        // Content Management
        Route::get('/content', [AdminController::class, 'contentManagement'])->name('admin.content.manage');
        
        // System Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        
        // Activity Logs
        Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
    });
    
    
    // Patrol Reports Routes
    Route::prefix('patrol-reports')->group(function () {
        Route::get('/', [PatrolReportController::class, 'index'])->name('patrol-reports.index');
        Route::post('/', [PatrolReportController::class, 'store'])->name('patrol-reports.store');
        Route::get('/{patrolReport}', [PatrolReportController::class, 'show'])->name('patrol-reports.show');
        Route::put('/{patrolReport}', [PatrolReportController::class, 'update'])->name('patrol-reports.update');
        Route::delete('/{patrolReport}', [PatrolReportController::class, 'destroy'])->name('patrol-reports.destroy');
        Route::post('/{patrolReport}/verify', [PatrolReportController::class, 'verify'])->name('patrol-reports.verify')->middleware('admin');
        Route::get('/map-data', [PatrolReportController::class, 'mapData'])->name('patrol-reports.map-data');
        Route::get('/filter-options', [PatrolReportController::class, 'filterOptions'])->name('patrol-reports.filter-options');
    });
});

?>
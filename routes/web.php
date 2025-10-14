<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FiBlogController;
use App\Http\Controllers\Admin\FiCategoryController;
use App\Http\Controllers\Admin\FitLiveSessionAdminController;
use App\Http\Controllers\Admin\FitNewsController as AdminFitNewsController;
use App\Http\Controllers\Admin\HomepageHeroController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Public\FitInsightController;
use App\Http\Controllers\Public\FitLiveController;
use App\Http\Controllers\Public\FitNewsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;

// Home route
Route::get('/time', function () {
    return now()->toDateTimeString(); // e.g. 2025-10-09 17:42:18
});

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search']);

Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');
Route::get('/progress-insights', [ToolsController::class, 'progress_insights'])->name('progress-insights');
Route::get('/bmr-calculator', [ToolsController::class, 'bmr_calculator'])->name('bmr-calculator');
Route::get('/calories', [ToolsController::class, 'calories'])->name('calories');
Route::get('/steps-tracker', [ToolsController::class, 'steps_tracker'])->name('steps-tracker');
Route::get('/health-kit', [ToolsController::class, 'health_kit'])->name('health-kit');
Route::get('/rpe', [ToolsController::class, 'rpe'])->name('rpe');
Route::get('/body-fat', [ToolsController::class, 'body_fat'])->name('body-fat');
Route::get('/planner', [ToolsController::class, 'planner'])->name('planner');
Route::get('/protein-requirement', [ToolsController::class, 'protein_requirement'])->name('protein-requirement');
Route::get('/tdee', [ToolsController::class, 'tdee'])->name('tdee');
Route::get('/water-intake', [ToolsController::class, 'water_intake'])->name('water-intake');
Route::get('/one-rm', [ToolsController::class, 'one_rm'])->name('one-rm');

Route::view('/legal-notice', 'static/legal_notice')->name('legal_notice');
Route::view('/cookie-preference', 'static/cookie_preference')->name('cookie_preference');
Route::view('/privacy-policy', 'static/privacy_policy')->name('privacy_policy');
Route::view('/refund-policy', 'static/refund_policy')->name('refund_policy');
Route::view('/terms-condition', 'static/terms_condition')->name('terms_condition');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
// routes/web.php
Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');





Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PATCH endpoints for AJAX updates (CSRF and method patch supported by Laravel)
    Route::patch('/profile/update-stat', [DashboardController::class, 'updateStat'])
        ->name('profile.update.stat');

    Route::patch('/profile/interest/add', [DashboardController::class, 'addInterest'])
        ->name('profile.interest.add');

    Route::patch('/profile/interest/remove', [DashboardController::class, 'removeInterest'])
        ->name('profile.interest.remove');
});
// User dashboard route
// Route::middleware('auth')->get('/dashboard', function () {
//     $user = auth()->user();

//     if ($user->hasRole('admin')) {
//         return redirect()->route('admin.dashboard');
//     } elseif ($user->hasRole('instructor')) {
//         return redirect()->route('instructor.dashboard');
//     } else {
//         return view('user.dashboard');
//     }
// })->name('dashboard');


// Two-Factor Authentication Routes
Route::middleware('auth')->group(function () {
    Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
    Route::get('/two-factor/setup', [TwoFactorController::class, 'setup'])->name('two-factor.setup');
    Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::delete('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
    Route::get('/two-factor/recovery-codes', [TwoFactorController::class, 'recoveryCodes'])->name('two-factor.recovery-codes');
    Route::post('/two-factor/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.regenerate-recovery-codes');
    Route::get('/two-factor/challenge', [TwoFactorController::class, 'challenge'])->name('two-factor.challenge');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
});

Route::middleware('auth')->group(function () {

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/settings', [AccountController::class, 'settings'])->name('account.settings');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
    Route::post('/account/preferences', [AccountController::class, 'updatePreferences'])->name('account.updatePreferences');

    Route::get('/account/privacy', [AccountController::class, 'privacy'])->name('account.privacy');
    Route::get('/account/security', [AccountController::class, 'security'])->name('account.security');

    Route::get('/account/delete', [AccountController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/account/delete', [AccountController::class, 'destroyAccount'])->name('account.destroy');

    Route::get('/account/download', [AccountController::class, 'downloadData'])->name('account.download');
});

// Instructor routes
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/', [InstructorController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [InstructorController::class, 'analytics'])->name('analytics');
    Route::get('/profile', [InstructorController::class, 'profile'])->name('profile');
    Route::put('/profile', [InstructorController::class, 'updateProfile'])->name('profile.update');

    // Session management for instructors
    Route::get('/sessions', [InstructorController::class, 'sessions'])->name('sessions');
    Route::get('/sessions/create', [InstructorController::class, 'createSession'])->name('sessions.create');
    Route::post('/sessions', [InstructorController::class, 'storeSession'])->name('sessions.store');
    Route::get('/sessions/{session}', [InstructorController::class, 'showSession'])->name('sessions.show');
    Route::get('/sessions/{session}/stream', [InstructorController::class, 'streamSession'])->name('sessions.stream');
    Route::post('/sessions/{session}/{action}', [InstructorController::class, 'updateStreamStatus'])->name('sessions.stream.update')->where('action', 'start|end');

    // FitArena session management for instructors
    Route::get('/fitarena-sessions', [InstructorController::class, 'fitArenaSessions'])->name('fitarena.sessions');
    Route::get('/fitarena-sessions/{session}/stream', [InstructorController::class, 'streamArenaSession'])->name('fitarena.sessions.stream');
    Route::post('/fitarena-sessions/{session}/{action}', [InstructorController::class, 'updateArenaStreamStatus'])->name('fitarena.sessions.stream.update')->where('action', 'start|end');
});

// Public FitLive Routes
Route::prefix('fitlive')->name('fitlive.')->group(function () {
    Route::get('/', [FitLiveController::class, 'index'])->name('index');
    Route::get('/fitexpert', [FitLiveController::class, 'fitexpert'])->name('fitexpert');
    Route::get('/daily-live-classes', [FitLiveController::class, 'fitlive'])->name('fitlive');

    // Scroll the fitflix vdo
    Route::get('/vdo', [FitLiveController::class, 'fitflixShortsVdo'])->name('vdo');

    Route::post('/toggle-like/{video}', [FitLiveController::class, 'toggleLike'])
        ->name('toggleLike');
    Route::post('/share-video/{videoId}', [FitLiveController::class, 'shareVideo'])->name('share-video');
    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitlive'])->group(function () {
        Route::get('/session/{id}', [FitLiveController::class, 'session'])->name('session');
        Route::get('/category/{category}', [FitLiveController::class, 'category'])->name('category');
    });

    Route::get('/{id}', [FitLiveController::class, 'show'])->name('daily-classes.show');
});

// Public FitNews Routes
Route::prefix('fitnews')->name('fitnews.')->group(function () {
    Route::get('/', [FitNewsController::class, 'index'])->name('index');

    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitnews'])->group(function () {
        Route::get('/{fitNews}', [FitNewsController::class, 'show'])->name('show');
        Route::post('/{fitNews}/join', [FitNewsController::class, 'joinStream'])->name('join');
        Route::post('/{fitNews}/leave', [FitNewsController::class, 'leaveStream'])->name('leave');
        Route::get('/{fitNews}/status', [FitNewsController::class, 'getStreamStatus'])->name('status');
    });
});

// Public FitInsight Routes (Blog)
Route::prefix('fitinsight')->name('fitinsight.')->group(function () {
    Route::get('/', [FitInsightController::class, 'index'])->name('index');
    Route::get('/category/{category}', [FitInsightController::class, 'category'])->name('category');

    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitinsight'])->group(function () {
        Route::get('/{blog}', [FitInsightController::class, 'show'])->name('show');
        Route::post('/{blog}/like', [FitInsightController::class, 'like'])->name('like');
        Route::post('/{blog}/share', [FitInsightController::class, 'share'])->name('share');

        Route::get('/{blog}/comments', [FitInsightController::class, 'comments'])->name('fitinsight.comments');

        Route::post('/{blog}/comments', [FitInsightController::class, 'storeComment'])->name('fitinsight.comments.store');
    });
});

// Public FitGuide Routes (User-facing)
Route::prefix('fitguide')->name('fitguide.')->group(function () {
    // Public index and category listings
    Route::get('/', [\App\Http\Controllers\Public\FitGuideController::class, 'index'])->name('index');
    Route::get('/fit-cast', [\App\Http\Controllers\Public\FitGuideController::class, 'fitCast'])->name('fitcast');
    Route::get('/categories', [\App\Http\Controllers\Public\FitGuideController::class, 'categories'])->name('categories');
    Route::get('/category/{category}', [\App\Http\Controllers\Public\FitGuideController::class, 'category'])->name('category');

    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitguide'])->group(function () {
        Route::get('/single/{fgSingle}', [\App\Http\Controllers\Public\FitGuideController::class, 'showSingle'])->name('single.show');
        Route::get('/series/{fgSeries}', [\App\Http\Controllers\Public\FitGuideController::class, 'showSeries'])->name('series.show');
        Route::get('/series/{fgSeries}/episode/{episode}', [\App\Http\Controllers\Public\FitGuideController::class, 'showEpisode'])->name('series.episode');
    });
});

// Public FitDoc Routes (User-facing)
Route::prefix('fitdoc')->name('fitdoc.')->group(function () {
    // Public index and category listings
    Route::get('/', [\App\Http\Controllers\Public\FitDocController::class, 'index'])->name('index');
    Route::get('/single', [\App\Http\Controllers\Public\FitDocController::class, 'singles'])->name('singles');
    Route::get('/series', [\App\Http\Controllers\Public\FitDocController::class, 'series'])->name('series');

    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitdoc'])->group(function () {
        Route::get('/single/{fitDoc}', [\App\Http\Controllers\Public\FitDocController::class, 'showSingle'])->name('single.show');
        Route::get('/series/{fitDoc}', [\App\Http\Controllers\Public\FitDocController::class, 'showSeries'])->name('series.show');
        Route::get('/series/{fitDoc}/episode/{episode}', [\App\Http\Controllers\Public\FitDocController::class, 'showEpisode'])->name('series.episode');
    });
});

// Public FitArena Routes (User-facing)
Route::prefix('fitarena')->name('fitarena.')->group(function () {
    // Public index and category listings
    Route::get('/', [\App\Http\Controllers\Public\FitArenaController::class, 'index'])->name('index');
    Route::get('/live', [\App\Http\Controllers\Public\FitArenaController::class, 'live'])->name('live');
    Route::get('/upcoming', [\App\Http\Controllers\Public\FitArenaController::class, 'upcoming'])->name('upcoming');
    Route::get('/archive', [\App\Http\Controllers\Public\FitArenaController::class, 'archive'])->name('archive');

    // Protected content - requires subscription
    Route::middleware(['auth', 'subscription:fitarena'])->group(function () {
        Route::get('/event/{event}', [\App\Http\Controllers\Public\FitArenaController::class, 'event'])->name('event');
        Route::get('/{event}', [\App\Http\Controllers\Public\FitArenaController::class, 'event'])->name('show');
        Route::get('/{event}/stages/{stage}', [\App\Http\Controllers\Public\FitArenaController::class, 'stage'])->name('stage');
        Route::get('/{event}/sessions/{session}', [\App\Http\Controllers\Public\FitArenaController::class, 'session'])->name('session');
        Route::post('/{event}/join', [\App\Http\Controllers\Public\FitArenaController::class, 'joinEvent'])->name('join');
        Route::post('/{event}/leave', [\App\Http\Controllers\Public\FitArenaController::class, 'leaveEvent'])->name('leave');
    });
});

// User Badges - admin
Route::prefix('user-badges')->name('user.badges.')->group(function () {
    Route::get('/', [App\Http\Controllers\User\BadgeController::class, 'index'])->name('index');
    Route::get('/{badge}/progress', [App\Http\Controllers\User\BadgeController::class, 'progress'])->name('progress');
    Route::post('/check', [App\Http\Controllers\User\BadgeController::class, 'checkBadges'])->name('check');
    Route::patch('/{userBadge}/toggle-visibility', [App\Http\Controllers\User\BadgeController::class, 'toggleVisibility'])->name('toggle-visibility');
});

// Admin routes (Admin only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // User management CRUD
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Role management CRUD
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    Route::get('/roles/create', [AdminController::class, 'createRole'])->name('roles.create');
    Route::post('/roles', [AdminController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{role}/edit', [AdminController::class, 'editRole'])->name('roles.edit');
    Route::put('/roles/{role}', [AdminController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [AdminController::class, 'deleteRole'])->name('roles.delete');

    // Permission management CRUD
    Route::get('/permissions', [AdminController::class, 'permissions'])->name('permissions');
    Route::get('/permissions/create', [AdminController::class, 'createPermission'])->name('permissions.create');
    Route::post('/permissions', [AdminController::class, 'storePermission'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [AdminController::class, 'editPermission'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [AdminController::class, 'updatePermission'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [AdminController::class, 'deletePermission'])->name('permissions.delete');

    // Legacy API-style routes for role assignment
    Route::post('/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('/users/{user}/remove-role', [AdminController::class, 'removeRole'])->name('users.remove-role');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');

    // FitGuide Management (Admin only)
    Route::prefix('fitguide')->name('fitguide.')->group(function () {
        // Main FitGuide route
        Route::get('/', [\App\Http\Controllers\Admin\FitGuideController::class, 'index'])->name('index');
        Route::get('/stats', [\App\Http\Controllers\Admin\FitGuideController::class, 'stats'])->name('stats');

        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\FgCategoryController::class)->parameters(['categories' => 'fgCategory']);
        Route::patch('categories/{fgCategory}/toggle-status', [\App\Http\Controllers\Admin\FgCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Subcategories
        Route::resource('subcategories', \App\Http\Controllers\Admin\FgSubCategoryController::class)->parameters(['subcategories' => 'fgSubCategory']);
        Route::patch('subcategories/{fgSubCategory}/toggle-status', [\App\Http\Controllers\Admin\FgSubCategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
        Route::get('categories/{category}/subcategories', [\App\Http\Controllers\Admin\FgSubCategoryController::class, 'getByCategory'])->name('fitguide.categories.subcategories');

        // Singles
        Route::resource('single', \App\Http\Controllers\Admin\FgSingleController::class)->parameters(['single' => 'fgSingle']);
        Route::patch('single/{fgSingle}/toggle-status', [\App\Http\Controllers\Admin\FgSingleController::class, 'toggleStatus'])->name('single.toggle-status');

        // Series
        Route::resource('series', \App\Http\Controllers\Admin\FgSeriesController::class)->parameters(['series' => 'fgSeries']);
        Route::patch('series/{fgSeries}/toggle-status', [\App\Http\Controllers\Admin\FgSeriesController::class, 'toggleStatus'])->name('series.toggle-status');

        // Series Episodes
        Route::get('series/{fgSeries}/episodes', [\App\Http\Controllers\Admin\FgSeriesController::class, 'episodes'])->name('series.episodes');
        Route::get('series/{fgSeries}/episodes/create', [\App\Http\Controllers\Admin\FgSeriesController::class, 'createEpisode'])->name('series.episodes.create');
        Route::post('series/{fgSeries}/episodes', [\App\Http\Controllers\Admin\FgSeriesController::class, 'storeEpisode'])->name('series.episodes.store');
        Route::get('series/{fgSeries}/episodes/{episode}/edit', [\App\Http\Controllers\Admin\FgSeriesController::class, 'editEpisode'])->name('series.episodes.edit');
        Route::put('series/{fgSeries}/episodes/{episode}', [\App\Http\Controllers\Admin\FgSeriesController::class, 'updateEpisode'])->name('series.episodes.update');
        Route::delete('series/{fgSeries}/episodes/{episode}', [\App\Http\Controllers\Admin\FgSeriesController::class, 'destroyEpisode'])->name('series.episodes.destroy');
        Route::patch('series/{fgSeries}/episodes/{episode}/toggle-status', [\App\Http\Controllers\Admin\FgSeriesController::class, 'toggleEpisodeStatus'])->name('series.episodes.toggle-status');
    });

    // FitDoc Management (Admin only) - Separated by type
    Route::prefix('fitdoc')->name('fitdoc.')->group(function () {
        // Main FitDoc Index
        Route::get('/', [\App\Http\Controllers\Admin\FitDocController::class, 'index'])->name('index');

        // Single Video Routes
        Route::prefix('single')->name('single.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'store'])->name('store');
            Route::get('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'show'])->name('show');
            Route::get('/{fitDoc}/edit', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'edit'])->name('edit');
            Route::put('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'update'])->name('update');
            Route::delete('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'destroy'])->name('destroy');
            Route::patch('/{fitDoc}/toggle-status', [\App\Http\Controllers\Admin\FitDocSingleController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Series Routes
        Route::prefix('series')->name('series.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'store'])->name('store');
            Route::get('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'show'])->name('show');
            Route::get('/{fitDoc}/edit', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'edit'])->name('edit');
            Route::put('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'update'])->name('update');
            Route::delete('/{fitDoc}', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'destroy'])->name('destroy');
            Route::patch('/{fitDoc}/toggle-status', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'toggleStatus'])->name('toggle-status');

            // Episode Routes
            Route::get('/{fitDoc}/episodes', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'episodes'])->name('episodes');
            Route::get('/{fitDoc}/episodes/create', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'createEpisode'])->name('episodes.create');
            Route::post('/{fitDoc}/episodes', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'storeEpisode'])->name('episodes.store');
            Route::get('/{fitDoc}/episodes/{episode}/edit', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'editEpisode'])->name('episodes.edit');
            Route::put('/{fitDoc}/episodes/{episode}', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'updateEpisode'])->name('episodes.update');
            Route::delete('/{fitDoc}/episodes/{episode}', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'destroyEpisode'])->name('episodes.destroy');
            Route::patch('/{fitDoc}/episodes/{episode}/toggle-status', [\App\Http\Controllers\Admin\FitDocSeriesController::class, 'toggleEpisodeStatus'])->name('episodes.toggle-status');
        });

        // Stats
        Route::get('/stats', [\App\Http\Controllers\Admin\FitDocController::class, 'stats'])->name('stats');
    });

    // FitInsight Categories (Admin only)
    Route::prefix('fitinsight')->name('fitinsight.')->group(function () {
        Route::resource('categories', FiCategoryController::class)->parameters(['categories' => 'fiCategory']);
        Route::patch('categories/{fiCategory}/toggle-status', [FiCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::post('categories/bulk-action', [FiCategoryController::class, 'bulkAction'])->name('categories.bulk-action');
    });

    // FitNews Management (Admin only)
    Route::prefix('fitnews')->name('fitnews.')->group(function () {
        // Main listing
        Route::get('/', [\App\Http\Controllers\Admin\FitNewsController::class, 'index'])->name('index');

        // Archive routes – must be declared before wildcard {fitNews}
        Route::get('/archive', [\App\Http\Controllers\Admin\FitNewsArchiveController::class, 'index'])->name('archive.index');
        Route::get('/archive/{fitNews}', [\App\Http\Controllers\Admin\FitNewsArchiveController::class, 'show'])->name('archive.show');
        Route::get('/archive/{fitNews}/download', [\App\Http\Controllers\Admin\FitNewsArchiveController::class, 'download'])->name('archive.download');
        Route::delete('/archive/{fitNews}', [\App\Http\Controllers\Admin\FitNewsArchiveController::class, 'destroy'])->name('archive.destroy');
        Route::post('/archive/bulk-delete', [\App\Http\Controllers\Admin\FitNewsArchiveController::class, 'bulkDelete'])->name('archive.bulk-delete');

        // Standard CRUD
        Route::get('/create', [AdminFitNewsController::class, 'create'])->name('create');
        Route::post('/', [AdminFitNewsController::class, 'store'])->name('store');

        Route::get('/{fitNews}', [AdminFitNewsController::class, 'show'])->name('show');
        Route::get('/{fitNews}/edit', [AdminFitNewsController::class, 'edit'])->name('edit');
        Route::put('/{fitNews}', [AdminFitNewsController::class, 'update'])->name('update');
        Route::delete('/{fitNews}', [AdminFitNewsController::class, 'destroy'])->name('destroy');
        Route::get('/{fitNews}/stream', [AdminFitNewsController::class, 'stream'])->name('stream');
        Route::post('/{fitNews}/start', [AdminFitNewsController::class, 'startStream'])->name('start');
        Route::post('/{fitNews}/end', [AdminFitNewsController::class, 'endStream'])->name('end');
        Route::post('/{fitNews}/viewer-count', [AdminFitNewsController::class, 'updateViewerCount'])->name('viewer-count');
    });

    // FitLive Management (Admin only)
    Route::prefix('fitlive')->name('fitlive.')->group(function () {
        // Categories
        Route::resource('categories', CategoryController::class);

        // Subcategories
        Route::resource('subcategories', SubCategoryController::class);

        // Sessions
        Route::resource('sessions', FitLiveSessionAdminController::class)->parameters(['sessions' => 'fitLiveSession']);
        Route::post('sessions/{fitLiveSession}/start', [FitLiveSessionAdminController::class, 'startSession'])->name('sessions.start');
        Route::post('sessions/{fitLiveSession}/end', [FitLiveSessionAdminController::class, 'endSession'])->name('sessions.end');
        Route::get('sessions/{fitLiveSession}/stream', [FitLiveSessionAdminController::class, 'stream'])->name('sessions.stream');
        Route::post('sessions/{fitLiveSession}/{action}', [FitLiveSessionAdminController::class, 'updateStream'])->name('sessions.stream.update')->where('action', 'start|end');

        // Archive routes
        Route::prefix('archive')->name('archive.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FitLiveArchiveController::class, 'index'])->name('index');
            Route::get('/{fitLiveSession}', [\App\Http\Controllers\Admin\FitLiveArchiveController::class, 'show'])->name('show');
            Route::get('/{fitLiveSession}/download', [\App\Http\Controllers\Admin\FitLiveArchiveController::class, 'download'])->name('download');
            Route::delete('/{fitLiveSession}', [\App\Http\Controllers\Admin\FitLiveArchiveController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [\App\Http\Controllers\Admin\FitLiveArchiveController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // AJAX endpoints for subcategories
        Route::get('/categories/{category}/subcategories', function ($categoryId) {
            $subcategories = App\Models\SubCategory::where('category_id', $categoryId)
                ->select('id', 'name')
                ->get();

            return response()->json($subcategories);
        })->name('fitlive.categories.subcategories');
    });

    // Homepage Management (Admin only)
    Route::prefix('homepage')->name('homepage.')->group(function () {
        Route::resource('hero', HomepageHeroController::class)->parameters(['hero' => 'homepageHero']);
        Route::patch('hero/{homepageHero}/toggle-status', [HomepageHeroController::class, 'toggleStatus'])
            ->name('hero.toggle-status');
    });

    // Subscription Management (Admin only)
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        // Subscription Plans Management
        Route::resource('plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class)->parameters(['plans' => 'subscriptionPlan']);
        Route::patch('plans/{subscriptionPlan}/toggle-status', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'toggleStatus'])->name('plans.toggle-status');

        // User Subscriptions Management
        Route::get('/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('index');
        Route::get('/{userSubscription}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'show'])
            ->whereNumber('userSubscription')
            ->name('show');
        Route::get('manual/create', [\App\Http\Controllers\Admin\SubscriptionController::class, 'createForm'])->name('manual.create');
        Route::post('manual', [\App\Http\Controllers\Admin\SubscriptionController::class, 'createManual'])->name('manual.store');
        Route::patch('/{userSubscription}/cancel', [\App\Http\Controllers\Admin\SubscriptionController::class, 'cancelSubscription'])
            ->whereNumber('userSubscription')
            ->name('cancel');
        Route::patch('/{userSubscription}/refund', [\App\Http\Controllers\Admin\SubscriptionController::class, 'refundSubscription'])
            ->whereNumber('userSubscription')
            ->name('refund');
        Route::get('/analytics/dashboard', [\App\Http\Controllers\Admin\SubscriptionController::class, 'analyticsDashboard'])->name('analytics');
        Route::get('/analytics/revenue', [\App\Http\Controllers\Admin\SubscriptionController::class, 'revenueAnalytics'])->name('revenue');

        // Referral System Management
        Route::prefix('referrals')->name('referrals.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\ReferralController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ReferralController::class, 'store'])->name('store');
            Route::get('/analytics/dashboard', [\App\Http\Controllers\Admin\ReferralController::class, 'analyticsDashboard'])->name('analytics');
            Route::get('/{referralCode}', [\App\Http\Controllers\Admin\ReferralController::class, 'show'])->name('show');
            Route::get('/{referralCode}/edit', [\App\Http\Controllers\Admin\ReferralController::class, 'edit'])->name('edit');
            Route::put('/{referralCode}', [\App\Http\Controllers\Admin\ReferralController::class, 'update'])->name('update');
            Route::delete('/{referralCode}', [\App\Http\Controllers\Admin\ReferralController::class, 'destroy'])->name('destroy');
        });
    });

    // Influencer Management (Admin only)
    Route::prefix('influencers')->name('influencers.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\InfluencerController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\InfluencerController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\InfluencerController::class, 'store'])->name('store');
        Route::get('/{influencerProfile}', [\App\Http\Controllers\Admin\InfluencerController::class, 'show'])->name('show');
        Route::get('/{influencerProfile}/edit', [\App\Http\Controllers\Admin\InfluencerController::class, 'edit'])->name('edit');
        Route::put('/{influencerProfile}', [\App\Http\Controllers\Admin\InfluencerController::class, 'update'])->name('update');
        Route::delete('/{influencerProfile}', [\App\Http\Controllers\Admin\InfluencerController::class, 'destroy'])->name('destroy');
        Route::patch('/{influencerProfile}/approve', [\App\Http\Controllers\Admin\InfluencerController::class, 'approve'])->name('approve');
        Route::patch('/{influencerProfile}/reject', [\App\Http\Controllers\Admin\InfluencerController::class, 'reject'])->name('reject');
        Route::patch('/{influencerProfile}/suspend', [\App\Http\Controllers\Admin\InfluencerController::class, 'suspend'])->name('suspend');
        Route::patch('/{influencerProfile}/reactivate', [\App\Http\Controllers\Admin\InfluencerController::class, 'reactivate'])->name('reactivate');

        // Sales Management
        Route::prefix('sales')->name('sales.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\InfluencerController::class, 'sales'])->name('index');
            Route::patch('/{influencerSale}/confirm', [\App\Http\Controllers\Admin\InfluencerController::class, 'confirmSale'])->name('confirm');
            Route::patch('/{influencerSale}/reject', [\App\Http\Controllers\Admin\InfluencerController::class, 'rejectSale'])->name('reject');
        });

        // Payout Management
        Route::prefix('payouts')->name('payouts.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\InfluencerController::class, 'payouts'])->name('index');
            Route::post('/process', [\App\Http\Controllers\Admin\InfluencerController::class, 'processPayout'])->name('process');
            Route::patch('/{commissionPayout}/approve', [\App\Http\Controllers\Admin\InfluencerController::class, 'approvePayout'])->name('approve');
            Route::patch('/{commissionPayout}/complete', [\App\Http\Controllers\Admin\InfluencerController::class, 'completePayout'])->name('complete');
            Route::patch('/{commissionPayout}/fail', [\App\Http\Controllers\Admin\InfluencerController::class, 'failPayout'])->name('fail');
        });

        // Analytics
        Route::get('/analytics/dashboard', [\App\Http\Controllers\Admin\InfluencerController::class, 'analyticsDashboard'])->name('analytics');
    });

    // Community Management (Admin only)
    Route::prefix('community')->name('community.')->group(function () {
        // Community Dashboard & Analytics
        Route::get('/', [\App\Http\Controllers\Admin\CommunityDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [\App\Http\Controllers\Admin\CommunityDashboardController::class, 'analytics'])->name('analytics');

        // Community Categories Management
        Route::resource('categories', \App\Http\Controllers\Admin\CommunityCategoryController::class);
        Route::patch(
            'categories/{communityCategory}/toggle-status',
            [\App\Http\Controllers\Admin\CommunityCategoryController::class, 'toggleStatus']
        )
            ->name('categories.toggle-status');
        Route::post(
            'categories/update-order',
            [\App\Http\Controllers\Admin\CommunityCategoryController::class, 'updateOrder']
        )
            ->name('categories.update-order');
        Route::post(
            'categories/bulk-action',
            [\App\Http\Controllers\Admin\CommunityCategoryController::class, 'bulkAction']
        )
            ->name('categories.bulk-action');
        Route::get(
            'categories/api/list',
            [\App\Http\Controllers\Admin\CommunityCategoryController::class, 'apiIndex']
        )
            ->name('categories.api');

        // Community Posts Management
        Route::resource('posts', \App\Http\Controllers\Admin\CommunityPostController::class);
        Route::patch(
            'posts/{communityPost}/toggle-status',
            [\App\Http\Controllers\Admin\CommunityPostController::class, 'toggleStatus']
        )
            ->name('posts.toggle-status');
        Route::patch(
            'posts/{communityPost}/toggle-featured',
            [\App\Http\Controllers\Admin\CommunityPostController::class, 'toggleFeatured']
        )
            ->name('posts.toggle-featured');
        Route::post(
            'posts/bulk-action',
            [\App\Http\Controllers\Admin\CommunityPostController::class, 'bulkAction']
        )
            ->name('posts.bulk-action');

        // Community Groups Management
        Route::resource('groups', \App\Http\Controllers\Admin\CommunityGroupController::class);
        Route::patch(
            'groups/{communityGroup}/toggle-status',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'toggleStatus']
        )
            ->name('groups.toggle-status');
        Route::get(
            'groups/{communityGroup}/members',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'members']
        )
            ->name('groups.members');
        Route::patch(
            'groups/{communityGroup}/members/{user}/role',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'updateMemberRole']
        )
            ->name('groups.members.update-role');
        Route::delete(
            'groups/{communityGroup}/members/{user}',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'removeMember']
        )
            ->name('groups.members.remove');
        Route::post(
            'groups/{communityGroup}/members',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'addMember']
        )
            ->name('groups.members.add');
        Route::post(
            'groups/bulk-action',
            [\App\Http\Controllers\Admin\CommunityGroupController::class, 'bulkAction']
        )
            ->name('groups.bulk-action');

        // Badges Management
        Route::resource('badges', \App\Http\Controllers\Admin\BadgeAdminController::class);
        Route::patch(
            'badges/{badge}/toggle-status',
            [\App\Http\Controllers\Admin\BadgeAdminController::class, 'toggleStatus']
        )
            ->name('badges.toggle-status');
        Route::post(
            'badges/{badge}/award',
            [\App\Http\Controllers\Admin\BadgeAdminController::class, 'awardBadge']
        )
            ->name('badges.award');

        // Community Moderation
        Route::prefix('moderation')->name('moderation.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'index'])->name('index');
            Route::post('flag-content', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'flagContent'])->name('flag-content');
            Route::get('flagged-posts', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'flaggedPosts'])->name('flagged-posts');
            Route::get('flagged-comments', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'flaggedComments'])->name('flagged-comments');
            Route::get('blocked-users', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'blockedUser'])->name('blocked-users');
            Route::post('users/{user}/block', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'blockUser'])->name('block-user');
            Route::post('users/{user}/unblock', [\App\Http\Controllers\Admin\CommunityModerationController::class, 'unblockUser'])->name('unblock-user');
        });

        // FitTalk Sessions Management
        Route::prefix('fittalk')->name('fittalk.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FittalkAdminController::class, 'index'])->name('index');
            Route::get('/{fittalkSession}', [\App\Http\Controllers\Admin\FittalkAdminController::class, 'show'])->name('show');
            Route::patch('/{fittalkSession}/status', [\App\Http\Controllers\Admin\FittalkAdminController::class, 'updateStatus'])->name('update-status');
            Route::post('/{fittalkSession}/cancel', [\App\Http\Controllers\Admin\FittalkAdminController::class, 'cancelSession'])->name('cancel');
        });

        // FitFlix Shorts Categories
        Route::prefix('fitflix-shorts')->name('fitflix-shorts.')->group(function () {
            Route::resource('categories', \App\Http\Controllers\Admin\FitFlixShortsCategoryController::class)
                ->parameters(['categories' => 'fitflix_shorts_category'])
                ->names('categories');
            Route::patch(
                'categories/{fitflix_shorts_category}/toggle-status',
                [\App\Http\Controllers\Admin\FitFlixShortsCategoryController::class, 'toggleStatus']
            )
                ->name('categories.toggle-status');
            Route::put('/{id}', [\App\Http\Controllers\Admin\FitFlixShortsController::class, 'update'])->name('update');
        });

        // FitFlix Shorts
        Route::resource('fitflix-shorts', \App\Http\Controllers\Admin\FitFlixShortsController::class)
            ->parameters(['fitflix-shorts' => 'fitflix_short']);
        Route::patch(
            'fitflix-shorts/{fitflix_short}/toggle-published',
            [\App\Http\Controllers\Admin\FitFlixShortsController::class, 'togglePublished']
        )
            ->name('fitflix-shorts.toggle-published');
        Route::patch(
            'fitflix-shorts/{fitflix_short}/toggle-featured',
            [\App\Http\Controllers\Admin\FitFlixShortsController::class, 'toggleFeatured']
        )
            ->name('fitflix-shorts.toggle-featured');
    });

    // FitArena Live Management (Admin only)
    Route::prefix('fitarena')->name('fitarena.')->group(function () {
        // Events management
        Route::get('/', [\App\Http\Controllers\Admin\FitArenaController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\FitArenaController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\FitArenaController::class, 'store'])->name('store');
        Route::get('/{event}', [\App\Http\Controllers\Admin\FitArenaController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [\App\Http\Controllers\Admin\FitArenaController::class, 'edit'])->name('edit');
        Route::put('/{event}', [\App\Http\Controllers\Admin\FitArenaController::class, 'update'])->name('update');
        Route::delete('/{event}', [\App\Http\Controllers\Admin\FitArenaController::class, 'destroy'])->name('destroy');

        // Stages management
        Route::get('/{event}/stages', [\App\Http\Controllers\Admin\FitArenaController::class, 'stages'])->name('stages');
        Route::get('/{event}/stages/create', [\App\Http\Controllers\Admin\FitArenaController::class, 'createStage'])->name('stages.create');
        Route::post('/{event}/stages', [\App\Http\Controllers\Admin\FitArenaController::class, 'storeStage'])->name('stages.store');
        Route::get('/{event}/stages/{stage}/edit', [\App\Http\Controllers\Admin\FitArenaController::class, 'editStage'])->name('stages.edit');
        Route::put('/{event}/stages/{stage}', [\App\Http\Controllers\Admin\FitArenaController::class, 'updateStage'])->name('stages.update');
        Route::delete('/{event}/stages/{stage}', [\App\Http\Controllers\Admin\FitArenaController::class, 'destroyStage'])->name('stages.destroy');

        // Sessions management
        Route::get('/{event}/sessions', [\App\Http\Controllers\Admin\FitArenaController::class, 'sessions'])->name('sessions');
        Route::get('/{event}/sessions/create', [\App\Http\Controllers\Admin\FitArenaController::class, 'createSession'])->name('sessions.create');
        Route::post('/{event}/sessions', [\App\Http\Controllers\Admin\FitArenaController::class, 'storeSession'])->name('sessions.store');
        Route::get('/{event}/sessions/{session}/edit', [\App\Http\Controllers\Admin\FitArenaController::class, 'editSession'])->name('sessions.edit');
        Route::put('/{event}/sessions/{session}', [\App\Http\Controllers\Admin\FitArenaController::class, 'updateSession'])->name('sessions.update');
        Route::delete('/{event}/sessions/{session}', [\App\Http\Controllers\Admin\FitArenaController::class, 'destroySession'])->name('sessions.destroy');

        // Bulk operations
        Route::get('/{event}/sessions/bulk-create', [\App\Http\Controllers\Admin\FitArenaController::class, 'bulkCreateSessions'])->name('sessions.bulk-create');
        Route::post('/{event}/sessions/bulk-store', [\App\Http\Controllers\Admin\FitArenaController::class, 'storeBulkSessions'])->name('sessions.bulk-store');

        // Streaming management
        Route::get('/{event}/sessions/{session}/stream', [\App\Http\Controllers\Admin\FitArenaController::class, 'streamSession'])->name('sessions.stream');
        Route::post('/{event}/sessions/{session}/stream-status', [\App\Http\Controllers\Admin\FitArenaController::class, 'updateStreamStatus'])->name('sessions.stream-status');
    });
});

// User Subscription Routes (Authenticated users)
Route::middleware('auth')->prefix('subscription')->name('subscription.')->group(function () {
    // Subscription management
    Route::get('/', [\App\Http\Controllers\SubscriptionController::class, 'index'])->name('index');
    Route::get('/plans', [\App\Http\Controllers\SubscriptionController::class, 'plans'])->name('plans');
    Route::post('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::patch('/cancel', [\App\Http\Controllers\SubscriptionController::class, 'cancel'])->name('cancel');
    Route::post('/renew', [\App\Http\Controllers\SubscriptionController::class, 'renew'])->name('renew');

    // Referral system
    Route::prefix('referrals')->name('referrals.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SubscriptionController::class, 'referrals'])->name('index');
        Route::post('/apply', [\App\Http\Controllers\SubscriptionController::class, 'applyReferral'])->name('apply');
        Route::get('/my-code', [\App\Http\Controllers\SubscriptionController::class, 'myReferralCode'])->name('my-code');
    });
});
Route::middleware('auth')->prefix('/razorpay')->name('razorpay.')->group(function () {
    Route::post('/order', [\App\Http\Controllers\RazorpayController::class, 'createOrder'])->name('order');
    Route::post('/confirm', [\App\Http\Controllers\RazorpayController::class, 'paymentSuccess'])->name('confirm');
});
// Payment Routes (Authenticated users)
Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {

    // Payment processing
    Route::post('/create-intent', [\App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('create-intent');
    Route::post('/create-order', [\App\Http\Controllers\PaymentController::class, 'createOrder'])->name('create-order');
    Route::get('/success', [\App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('success');
    Route::get('/cancel', [\App\Http\Controllers\PaymentController::class, 'paymentCancel'])->name('cancel');

    // Payment methods
    Route::get('/methods', [\App\Http\Controllers\PaymentController::class, 'getPaymentMethods'])->name('methods');
    Route::post('/methods', [\App\Http\Controllers\PaymentController::class, 'addPaymentMethod'])->name('methods.add');
    Route::delete('/methods', [\App\Http\Controllers\PaymentController::class, 'removePaymentMethod'])->name('methods.remove');

    // Pricing calculation
    Route::post('/calculate-pricing', [\App\Http\Controllers\PaymentController::class, 'calculatePricing'])->name('calculate-pricing');
});

// Webhook Routes (No authentication required)
Route::post('/webhooks/stripe', [\App\Http\Controllers\StripeWebhookController::class, 'handleWebhook'])->name('webhooks.stripe');

// Influencer Dashboard Routes (Authenticated users)
Route::middleware('auth')->prefix('influencer')->name('influencer.')->group(function () {
    // Application and profile management
    Route::get('/', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'index'])->name('index');
    Route::get('/apply', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'showApplication'])->name('apply');
    Route::post('/apply', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'submitApplication'])->name('apply.submit');
    Route::get('/profile', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'updateProfile'])->name('profile.update');

    // Link management (only for approved influencers)
    Route::middleware('can:manage,influencer_profile')->group(function () {
        Route::get('/links', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'links'])->name('links');
        Route::post('/links', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'createLink'])->name('links.create');
        Route::patch('/links/{influencerLink}/toggle', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'toggleLink'])->name('links.toggle');

        // Analytics and earnings
        Route::get('/analytics', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/earnings', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'earnings'])->name('earnings');
        Route::get('/sales', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'sales'])->name('sales');

        // Payout requests
        Route::get('/payouts', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'payouts'])->name('payouts');
        Route::post('/payouts/request', [\App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'requestPayout'])->name('payouts.request');
    });
});

// Public influencer tracking routes (no authentication required)
Route::get('/ref/{code}', [\App\Http\Controllers\SubscriptionController::class, 'trackInfluencerLink'])->name('influencer.track');
Route::post('/ref/{code}/convert', [\App\Http\Controllers\SubscriptionController::class, 'convertInfluencerSale'])->name('influencer.convert');

// FitInsight Blogs (Admin and Instructor)
Route::middleware(['auth', 'role:admin|instructor'])->prefix('admin/fitinsight')->name('admin.fitinsight.')->group(function () {
    Route::resource('blogs', FiBlogController::class)->parameters(['blogs' => 'fiBlog']);
    Route::patch('blogs/{fiBlog}/publish', [FiBlogController::class, 'publish'])->name('blogs.publish');
    Route::patch('blogs/{fiBlog}/unpublish', [FiBlogController::class, 'unpublish'])->name('blogs.unpublish');
    Route::patch('blogs/{fiBlog}/toggle-featured', [FiBlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
    Route::patch('blogs/{fiBlog}/toggle-trending', [FiBlogController::class, 'toggleTrending'])->name('blogs.toggle-trending');
    Route::post('blogs/bulk-action', [FiBlogController::class, 'bulkAction'])->name('blogs.bulk-action');
    Route::post('blogs/upload-image', [FiBlogController::class, 'uploadImage'])->name('blogs.upload-image');
});

// Instructor Admin routes (Limited admin access for instructors)
Route::middleware(['auth', 'role:instructor'])->prefix('admin')->name('admin.')->group(function () {
    // Only allow instructors to access existing categories/subcategories for session creation
    // No creation/editing access to categories/subcategories
    Route::prefix('fitlive')->name('fitlive.')->group(function () {
        // AJAX endpoints for subcategories (read-only for session creation)
        Route::get('/categories/{category}/subcategories', function ($categoryId) {
            $subcategories = App\Models\SubCategory::where('category_id', $categoryId)
                ->select('id', 'name')
                ->get();

            return response()->json($subcategories);
        })->name('instructor.categories.subcategories');
    });
});

// Test route for debugging
Route::get('/test-session-create', function () {
    $categories = App\Models\Category::orderBy('name')->get();
    $subCategories = App\Models\SubCategory::with('category')->orderBy('name')->get();
    $instructors = App\Models\User::role('instructor')->orderBy('name')->get();

    return [
        'categories_count' => $categories->count(),
        'subcategories_count' => $subCategories->count(),
        'instructors_count' => $instructors->count(),
        'first_category' => $categories->first(),
        'first_subcategory' => $subCategories->first(),
        'first_instructor' => $instructors->first(),
    ];
});

// Temporary debug route for FitDoc testing
Route::post('/debug/fitdoc', function (Request $request) {
    \Log::info('=== DEBUG FitDoc Form Submission ===');
    \Log::info('Method: ' . $request->method());
    \Log::info('URL: ' . $request->url());
    \Log::info('All Data: ', $request->all());
    \Log::info('Files: ', $request->allFiles());

    return response()->json([
        'success' => true,
        'message' => 'Debug data logged',
        'data' => $request->all(),
    ]);
})->name('debug.fitdoc');

// Temporary test route for referrals
Route::get('/test-referrals', [\App\Http\Controllers\Admin\TestReferralController::class, 'index'])->name('test.referrals');
Route::get('/test-referrals/json', [\App\Http\Controllers\Admin\TestReferralController::class, 'test'])->name('test.referrals.json');

// Dynamic Tracking Routes (must be at the end to avoid conflicts)
Route::get('/inf/{code}', [\App\Http\Controllers\TrackingController::class, 'trackInfluencerLink'])->name('track.influencer');
Route::get('/ref/{code}', [\App\Http\Controllers\TrackingController::class, 'trackReferralCode'])->name('track.referral');

// AJAX Tracking Routes
Route::post('/track/pageview', [\App\Http\Controllers\TrackingController::class, 'trackPageView'])->name('track.pageview');
Route::get('/api/commission-tiers', [\App\Http\Controllers\TrackingController::class, 'getCommissionTiers'])->name('api.commission-tiers');

// Authenticated tracking routes
Route::middleware('auth')->group(function () {
    // Note: API routes for influencer generate-link and analytics are handled in api.php
    // Route::post('/api/influencer/generate-link', [\App\Http\Controllers\TrackingController::class, 'generateInfluencerLink'])->name('api.influencer.generate-link');
    // Route::get('/api/influencer/analytics', [\App\Http\Controllers\TrackingController::class, 'getInfluencerAnalytics'])->name('api.influencer.analytics');
});

// Admin tracking routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/update-tiers', [\App\Http\Controllers\TrackingController::class, 'updateInfluencerTiers'])->name('admin.update-tiers');
});

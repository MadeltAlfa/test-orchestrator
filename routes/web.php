<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\PositionController;
use App\Http\Controllers\Superadmin\IndicatorController;
use App\Http\Controllers\Superadmin\SkillTestController;
use App\Http\Controllers\Superadmin\PositionIndicatorController;
use App\Http\Controllers\Superadmin\IndicatorTestController;
use App\Http\Controllers\Superadmin\TestGuideController;
use App\Http\Controllers\Superadmin\TestGuideSectionController;
use App\Http\Controllers\Superadmin\TestNormController;
use App\Http\Controllers\Superadmin\ScoringCategoryController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\PlayerController as SuperadminPlayerController;
use App\Http\Controllers\Superadmin\PlayerProfileController;
use App\Http\Controllers\Superadmin\AssessmentController;
use App\Http\Controllers\Superadmin\AssessmentResultController;
use App\Http\Controllers\Superadmin\ReportController;
use App\Http\Controllers\Superadmin\SettingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\PositionCheckController;
use App\Http\Controllers\User\ScoreTestController;
use App\Http\Controllers\User\AssessmentController as UserAssessmentController;
use App\Http\Controllers\User\AssessmentResultController as UserAssessmentResultController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\PdfController as UserPdfController;
use App\Http\Controllers\User\GuideController;

// ─── PUBLIC LANDING ROUTES ──────────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/panduan-posisi', [LandingController::class, 'panduanPosisi'])->name('panduan-posisi');

Route::get('/panduan-tes', [LandingController::class, 'panduanTes'])->name('panduan-tes');
Route::get('/panduan-tes/{id}', [LandingController::class, 'panduanTesShow'])->name('panduan-tes.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── SUPERADMIN ROUTES ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('positions', PositionController::class);
    Route::resource('indicators', IndicatorController::class);
    Route::resource('tests', SkillTestController::class)->parameters(['tests' => 'skillTest']);
    Route::resource('guides', TestGuideController::class)->parameters(['guides' => 'testGuide']);
    Route::resource('guide-sections', TestGuideSectionController::class)->parameters(['guide-sections' => 'testGuideSection']);
    Route::resource('norms', TestNormController::class)->parameters(['norms' => 'testNorm']);
    Route::resource('scoring-categories', ScoringCategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('players', SuperadminPlayerController::class);
    Route::resource('player-profiles', PlayerProfileController::class);
    // Pivot-Weight Position & Indicator
    Route::get('positions/{position}/indicators', [PositionIndicatorController::class, 'index'])->name('positions.indicators.index');
    Route::put('positions/{position}/indicators', [PositionIndicatorController::class, 'update'])->name('positions.indicators.update');
    // Pivot Indicator & Test
    Route::get('indicators/{indicator}/tests', [IndicatorTestController::class, 'index'])->name('indicators.tests.index');
    Route::put('indicators/{indicator}/tests', [IndicatorTestController::class, 'update'])->name('indicators.tests.update');

    Route::resource('assessments', AssessmentController::class);
    Route::resource('assessment-results', AssessmentResultController::class)->only(['index', 'show']);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

// ─── USER ROUTES ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    Route::get('/position-check', [PositionCheckController::class, 'index'])->name('position-check.index');
    Route::post('/position-check', [PositionCheckController::class, 'store'])->name('position-check.store');

    Route::get('/score-test', [ScoreTestController::class, 'index'])->name('score-test.index');
    Route::post('/score-test', [ScoreTestController::class, 'store'])->name('score-test.store');

    Route::get('/assessments', [UserAssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/{assessment}', [UserAssessmentController::class, 'show'])->name('assessments.show');
    Route::get('/assessment-results/{result}', [UserAssessmentResultController::class, 'show'])->name('assessment-results.show');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/pdf/{result}', [UserPdfController::class, 'download'])->name('pdf.download');
    Route::get('/guide', [GuideController::class, 'index'])->name('guide.index');
});

require __DIR__.'/auth.php';

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

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── SUPERADMIN ROUTES ────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
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
    Route::get('positions/{position}/indicators', [PositionIndicatorController::class, 'index'])->name('position-indicators.index');
    Route::post('position-indicators', [PositionIndicatorController::class, 'store'])->name('position-indicators.store');
    Route::put('position-indicators/{id}', [PositionIndicatorController::class, 'update'])->name('position-indicators.update');
    Route::delete('position-indicators/{id}', [PositionIndicatorController::class, 'destroy'])->name('position-indicators.destroy');
    // Pivot Link Indicator & Test
    Route::get('indicators/{indicator}/tests', [IndicatorTestController::class, 'index'])->name('indicator-tests.index');
    Route::post('indicator-tests', [IndicatorTestController::class, 'store'])->name('indicator-tests.store');
    Route::delete('indicator-tests/{id}', [IndicatorTestController::class, 'destroy'])->name('indicator-tests.destroy');
    // Assessment & PDF Export
    Route::get('assessments/{assessment}/print', [AssessmentController::class, 'printPdf'])->name('assessments.print');
    Route::resource('assessments', AssessmentController::class)->only(['index', 'show', 'destroy']);
    Route::resource('assessment-results', AssessmentResultController::class)->only(['index', 'show']);
    // Reports & Exports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
    // System Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

// ─── USER / PLAYER ROUTES ────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    // Manajemen Pemain (Pelatih)
    Route::resource('players', \App\Http\Controllers\User\PlayerController::class)->except(['create', 'edit']);
    // Profil Pemain
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    // Cek & Hitung Posisi
    Route::get('/position-check/input-score', [PositionCheckController::class, 'inputScore'])->name('position-check.input-score');
    Route::post('/position-check/input-score', [PositionCheckController::class, 'storeInputScore'])->name('position-check.store-input-score');
    Route::get('/position-check', [PositionCheckController::class, 'index'])->name('position-check.index');
    Route::post('/position-check', [PositionCheckController::class, 'store'])->name('position-check.store');
    Route::post('/position-check/calculate', [PositionCheckController::class, 'calculate'])->name('position-check.calculate');
    Route::get('/position-check/{id}/result', [PositionCheckController::class, 'result'])->name('position-check.result');
    // Konversi Skor Tes (Stopwatch/Increment/Ajax)
    Route::post('/score-tests/submit', [ScoreTestController::class, 'submit'])->name('score-tests.submit');
    Route::post('/score-tests/ajax-convert', [ScoreTestController::class, 'convertScore'])->name('score-tests.ajax-convert');
    Route::get('/score-tests', [ScoreTestController::class, 'index'])->name('score-tests.index');
    Route::get('/score-tests/{id}', [ScoreTestController::class, 'show'])->name('score-tests.show');
    // Assessment Pemain
    Route::resource('assessments', UserAssessmentController::class)->only(['index', 'show', 'store']);
    Route::get('assessments/{assessment}/ranking', [UserAssessmentResultController::class, 'ranking'])->name('assessments.ranking');
    Route::get('assessment-results/{id}', [UserAssessmentResultController::class, 'show'])->name('assessment-results.show');
    // Riwayat Assessment
    Route::resource('history', HistoryController::class)->only(['index', 'show', 'destroy']);
    // Cetak PDF / Print
    Route::get('pdf/assessment/{id}', [UserPdfController::class, 'assessment'])->name('pdf.assessment');
    Route::get('pdf/history', [UserPdfController::class, 'history'])->name('pdf.history');
    // Panduan Tes
    Route::resource('guides', GuideController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';

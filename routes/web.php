<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\ClientController;


Route::get('/', [PageController::class, 'signin']);
Route::get('/signup', [PageController::class, 'signup']);
Route::get('/forgot-password', [PageController::class, 'forgotPassword']);
Route::get('/verify-email', [PageController::class, 'verifyEmail']);
Route::get('/reset-password', [PageController::class, 'resetPassword']);

Route::prefix('onboarding')->name('onboarding.')->group(function () {
    // Entry point - account type selection
    Route::get('/', [OnboardingController::class, 'index'])->name('index');
    Route::post('/select', [OnboardingController::class, 'select'])->name('select');

    // Talent onboarding routes
    Route::prefix('talent')->name('talent.')->group(function () {
        Route::get('/personal-information', [TalentController::class, 'personalInformation'])
            ->name('personal-information');
        Route::post('/personal-information', [TalentController::class, 'storePersonalInformation'])
            ->name('personal-information.store');

        Route::get('/profile-overview', [TalentController::class, 'profileOverview'])
            ->name('profile-overview');
        Route::post('/profile-overview', [TalentController::class, 'storeProfileOverview'])
            ->name('profile-overview.store');

        Route::get('/professional-information', [TalentController::class, 'professionalInformation'])
            ->name('professional-information');
        Route::post('/professional-information', [TalentController::class, 'storeProfessionalInformation'])
            ->name('professional-information.store');

        Route::get('/employment-history', [TalentController::class, 'employmentHistory'])
            ->name('employment-history');
        Route::post('/employment-history', [TalentController::class, 'storeEmploymentHistory'])
            ->name('employment-history.store');

        Route::get('/education-history', [TalentController::class, 'educationHistory'])
            ->name('education-history');
        Route::post('/education-history', [TalentController::class, 'storeEducationHistory'])
            ->name('education-history.store');

        Route::get('/preference-compliance', [TalentController::class, 'preferenceCompliance'])
            ->name('preference-compliance');
        Route::post('/preference-compliance', [TalentController::class, 'storePreferenceCompliance'])
            ->name('preference-compliance.store');
    });

    // Client onboarding routes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::post('/', [ClientController::class, 'store'])->name('store');
    });
});

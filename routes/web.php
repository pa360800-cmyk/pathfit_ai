<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\SessionScheduleController;
use App\Http\Controllers\SportActivityController;
use App\Http\Controllers\SportAvailableController;
use App\Http\Controllers\AiBasedController;
use App\Http\Controllers\SportRequirementController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index']);

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'registerread'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth', 'login_auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User specific routes
    Route::get('/training-schedule', [UserController::class, 'userTrainingSchedule'])->name('user.training-schedule');
    Route::get('/assigned-coach', [UserController::class, 'assignedCoach'])->name('user.assigned-coach');
    Route::get('/report-activity', [UserController::class, 'reportActivity'])->name('user.report-activity');
    Route::post('/report-activity', [UserController::class, 'storeReportActivity'])->name('user.report-activity.store');
    Route::get('/messenger', [UserController::class, 'messenger'])->name('user.messenger');

    // Message routes (legacy - redirects based on role)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{contact}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{contact}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/contact-sport-coach/{sportId}', [MessageController::class, 'contactSportCoach'])->name('messages.contact-sport-coach');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [UsersController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::resource('training-schedule', TrainingScheduleController::class);
        Route::get('/player-status', [UsersController::class, 'playerStatus'])->name('player-status');
        Route::get('/coach', [UsersController::class, 'adminCoachIndex'])->name('coach.index');
        Route::get('/coach/create', [UsersController::class, 'createCoach'])->name('coach.create');
        Route::post('/coach', [UsersController::class, 'storeCoach'])->name('coach.store');
        Route::get('/coach/{coach}', [UsersController::class, 'showCoach'])->name('coach.show');
        Route::get('/coach/{coach}/edit', [UsersController::class, 'editCoach'])->name('coach.edit');
        Route::put('/coach/{coach}', [UsersController::class, 'updateCoach'])->name('coach.update');
        Route::delete('/coach/{coach}', [UsersController::class, 'destroyCoach'])->name('coach.destroy');
        Route::get('/coach/{coach}/qualifications/{sport}', [UsersController::class, 'coachQualificationsForSport'])->name('coach.qualifications.sport');
        Route::get('/assigncoach', [UsersController::class, 'assignCoachIndex'])->name('assigncoach.index');
        Route::post('/assigncoach', [UsersController::class, 'assignCoachStore'])->name('assigncoach.store');
        Route::get('/athlete', [UsersController::class, 'adminAthleteIndex'])->name('athlete.index');
        Route::get('/player', [UsersController::class, 'adminPlayerIndex'])->name('admin.player.index');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edits');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/sport-activity', [SportActivityController::class, 'index'])->name('sport-activity.index');
        Route::get('/sport-activity/create', [SportActivityController::class, 'create'])->name('sport-activity.create');
        Route::post('/sport-activity', [SportActivityController::class, 'store'])->name('sport-activity.store');
        Route::get('/sport-activity/{sportActivity}/edit', [SportActivityController::class, 'edit'])->name('sport-activity.edit');
        Route::put('/sport-activity/{sportActivity}', [SportActivityController::class, 'update'])->name('sport-activity.update');
        Route::delete('/sport-activity/{sportActivity}', [SportActivityController::class, 'destroy'])->name('sport-activity.destroy');
        Route::get('/sport-available', [SportAvailableController::class, 'index'])->name('sport-available.index');
        Route::get('/sport-available/create', [SportAvailableController::class, 'create'])->name('sport-available.create');
        Route::post('/sport-available', [SportAvailableController::class, 'store'])->name('sport-available.store');
        Route::get('/sport-available/{sportAvailable}/edit', [SportAvailableController::class, 'edit'])->name('sport-available.edit');
        Route::put('/sport-available/{sportAvailable}', [SportAvailableController::class, 'update'])->name('sport-available.update');
        Route::delete('/sport-available/{sportAvailable}', [SportAvailableController::class, 'destroy'])->name('sport-available.destroy');
        Route::get('/ai-based', [AiBasedController::class, 'index'])->name('ai-based.index');
        Route::post('/ai-based/run-assignment', [AiBasedController::class, 'runAiAssignment'])->name('ai-based.run-assignment');
        Route::post('/ai-based/enable-assistance', [AiBasedController::class, 'enableAiAssistance'])->name('ai-based.enable-assistance');
    });

    // Athlete routes
    Route::prefix('athlete')->name('athlete.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'athleteDashboard'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/sport-suggestion', [UserController::class, 'sportSuggestion'])->name('sport-suggestion');

        // Athlete Message routes
        Route::get('/messages', [MessageController::class, 'athleteIndex'])->name('messages.index');
        Route::get('/messages/{contact}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{contact}', [MessageController::class, 'athleteStore'])->name('messages.store');

        // Athlete Session Schedule routes
        Route::get('/session-schedules', [SessionScheduleController::class, 'athleteIndex'])->name('session-schedules.index');
    });

    // Coach routes
    Route::prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'coachDashboard'])->name('dashboard');
        Route::get('/list', [UserController::class, 'coachList'])->name('list');
        Route::get('/athletes', [UserController::class, 'coachAthletesIndex'])->name('athletes.index');
        Route::get('/athletes/create', [UserController::class, 'coachCreateAthlete'])->name('athletes.create');
        Route::post('/athletes', [UserController::class, 'coachStoreAthlete'])->name('athletes.store');
        Route::get('/athletes/{athlete}', [UserController::class, 'coachShowAthlete'])->name('athletes.show');
        Route::get('/athletes/{athlete}/edit', [UserController::class, 'coachEditAthlete'])->name('athletes.edit');
        Route::put('/athletes/{athlete}', [UserController::class, 'coachUpdateAthlete'])->name('athletes.update');
        Route::delete('/athletes/{athlete}', [UserController::class, 'coachDestroyAthlete'])->name('athletes.destroy');
        Route::get('/training-schedules', [TrainingScheduleController::class, 'coachIndex'])->name('training-schedules.index');
        Route::get('/training-schedules/create', [TrainingScheduleController::class, 'coachCreate'])->name('training-schedules.create');
        Route::post('/training-schedules', [TrainingScheduleController::class, 'coachStore'])->name('training-schedules.store');
        Route::get('/training-schedules/{trainingSchedule}', [TrainingScheduleController::class, 'coachShow'])->name('training-schedules.show');
        Route::get('/training-schedules/{trainingSchedule}/edit', [TrainingScheduleController::class, 'coachEdit'])->name('training-schedules.edit');
        Route::put('/training-schedules/{trainingSchedule}', [TrainingScheduleController::class, 'coachUpdate'])->name('training-schedules.update');
        Route::get('/activity-reports', [UserController::class, 'coachActivityReports'])->name('activity-reports.index');
        Route::get('/activity-reports/create', [UserController::class, 'coachCreateActivityReport'])->name('activity-reports.create');
        Route::post('/activity-reports', [UserController::class, 'coachStoreActivityReport'])->name('activity-reports.store');

        // Coach Message routes
        Route::get('/messages', [MessageController::class, 'coachIndex'])->name('messages.index');
        Route::get('/messages/{contact}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{contact}', [MessageController::class, 'coachStore'])->name('messages.store');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Sport Requirements routes
        Route::resource('sport-requirements', SportRequirementController::class);
        Route::patch('sport-requirements/{sportRequirement}/toggle', [SportRequirementController::class, 'toggle'])->name('sport-requirements.toggle');

        // Coach Session Schedule routes
        Route::get('/session-schedules', [SessionScheduleController::class, 'coachIndex'])->name('session-schedules.index');
        Route::get('/session-schedules/create', [SessionScheduleController::class, 'coachCreate'])->name('session-schedules.create');
        Route::post('/session-schedules', [SessionScheduleController::class, 'coachStore'])->name('session-schedules.store');
        Route::get('/session-schedules/{sessionSchedule}', [SessionScheduleController::class, 'coachShow'])->name('session-schedules.show');
        Route::get('/session-schedules/{sessionSchedule}/edit', [SessionScheduleController::class, 'coachEdit'])->name('session-schedules.edit');
        Route::put('/session-schedules/{sessionSchedule}', [SessionScheduleController::class, 'coachUpdate'])->name('session-schedules.update');
        Route::delete('/session-schedules/{sessionSchedule}', [SessionScheduleController::class, 'coachDestroy'])->name('session-schedules.destroy');
    });
});

require __DIR__.'/auth.php';

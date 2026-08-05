<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/page_dashboard', [PageController::class, 'page_dashboard']);
Route::get('/page_usermanagement', [PageController::class, 'page_UserManagement']);
Route::get('/page_menus', [PageController::class, 'page_Menus']);
Route::get('/page_users', [PageController::class, 'page_Users']);
Route::get('/page_team_management', [PageController::class, 'page_TeamManagement']);
Route::get('/page_settings', [PageController::class, 'page_settings']);

Route::get('/profile', [PageController::class, 'profile'])->name('profile');
Route::get('/settings', [PageController::class, 'settings'])->name('settings');

Route::get('/page_mailer', [PageController::class, 'page_Mailer']);
Route::get('/page_notification_test', [PageController::class, 'page_NotificationTest'])->middleware('can:isSuperAdmin');

Route::get('/page_app_settings', [PageController::class, 'page_AppSettings'])->middleware('can:isSuperAdmin');
Route::get('/page_applicants', [PageController::class, 'page_Applicants']);
Route::get('/page_orientation_schedule', [PageController::class, 'page_OrientationSchedule']);

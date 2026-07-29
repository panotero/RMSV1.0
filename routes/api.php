<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\MailerController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\NavIconController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RolesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Organized by feature/module. Middleware groups are used where needed.
| Each resource is grouped using Route::prefix for clarity.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/load_menu', [MenusController::class, 'index']);
    Route::get('/nav-icons', [NavIconController::class, 'index']);
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'getNotifications']);
    });


    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead']);
    Route::get('/notifications/stream', [NotificationController::class, 'stream']);


    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/settings', [UserController::class, 'getUserSettings']);
        Route::get('/counts', [UserController::class, 'counts']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::patch('/save/{id}', [UserController::class, 'save_info']);
        Route::patch('/deactivate/{id}', [UserController::class, 'deactivate']);
        Route::patch('/reactivate/{id}', [UserController::class, 'reactivate']);
    });



    Route::post('/send-mail', [MailerController::class, 'send']);


    Route::prefix('nav_menus')->group(function () {
        Route::get('/list', [MenusController::class, 'menulist']);
        Route::post('/', [MenusController::class, 'store']);
        Route::put('/{id}', [MenusController::class, 'update']);
        Route::delete('/{id}', [MenusController::class, 'destroy']);
        Route::post('/swap', [MenusController::class, 'swapMenuOrder']);
    });

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::get('/users', [TeamController::class, 'availableUsers']);
        Route::post('/', [TeamController::class, 'store'])->middleware('can:isSuperAdmin');
        Route::put('/{id}', [TeamController::class, 'update'])->middleware('can:isSuperAdmin');
        Route::delete('/{id}', [TeamController::class, 'destroy'])->middleware('can:isSuperAdmin');
        Route::get('/{id}/members', [TeamController::class, 'members']);
        Route::post('/{id}/members', [TeamController::class, 'addMember'])->middleware('can:isSuperAdmin');
        Route::patch('/{id}/members/{userId}', [TeamController::class, 'updateMember'])->middleware('can:isSuperAdmin');
        Route::delete('/{id}/members/{userId}', [TeamController::class, 'removeMember'])->middleware('can:isSuperAdmin');
    });

    // Read is open to any authenticated user (populates role-select
    // dropdowns e.g. on the Users page); mutations require roles.manage.
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'index']);
        Route::post('/', [RolesController::class, 'store'])->middleware('permission:roles.manage');
        Route::put('/{role}', [RolesController::class, 'update'])->middleware('permission:roles.manage');
        Route::delete('/{role}', [RolesController::class, 'destroy'])->middleware('permission:roles.manage');
    });

    Route::get('/permissions', [RolesController::class, 'permissions']);

    Route::post('/test-api', function (Request $request) {
        Log::info('Test API triggered', $request->all());
        return response()->json([
            'success' => true,
            'message' => 'API successfully triggered!',
        ]);
    });

    require __DIR__ . '/api_maintenance.php';
});

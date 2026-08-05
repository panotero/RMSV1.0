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
use App\Http\Controllers\LookupListController;
use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\RecruitmentFormController;
use App\Http\Controllers\ApplicantController;

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
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/mark-read', [NotificationController::class, 'markRead']);
    });
    Route::post('/notifications/test-send', [NotificationController::class, 'testSend'])->middleware('can:isSuperAdmin');


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

    Route::prefix('lookupLists')->middleware('can:isSuperAdmin')->group(function () {
        Route::get('/', [LookupListController::class, 'index']);
        Route::post('/', [LookupListController::class, 'store']);
        Route::post('/{listId}/items', [LookupListController::class, 'storeItem']);
        Route::put('/items/{itemId}', [LookupListController::class, 'updateItem']);
        Route::post('/{listId}/items/reorder', [LookupListController::class, 'reorderItems']);
    });

    Route::prefix('checklistItems')->middleware('can:isSuperAdmin')->group(function () {
        Route::get('/', [ChecklistItemController::class, 'index']);
        Route::post('/', [ChecklistItemController::class, 'store']);
        Route::put('/{id}', [ChecklistItemController::class, 'update']);
        Route::delete('/{id}', [ChecklistItemController::class, 'destroy']);
    });

    Route::prefix('checklistGroups')->middleware('can:isSuperAdmin')->group(function () {
        Route::get('/', [ChecklistItemController::class, 'indexGroups']);
        Route::post('/', [ChecklistItemController::class, 'storeGroup']);
        Route::put('/{id}', [ChecklistItemController::class, 'updateGroup']);
        Route::delete('/{id}', [ChecklistItemController::class, 'destroyGroup']);
    });

    Route::prefix('recruitmentForm')->middleware('can:isSuperAdmin')->group(function () {
        Route::get('/active', [RecruitmentFormController::class, 'active']);
        Route::post('/active/fields', [RecruitmentFormController::class, 'storeField']);
        Route::put('/fields/{id}', [RecruitmentFormController::class, 'updateField']);
        Route::delete('/fields/{id}', [RecruitmentFormController::class, 'destroyField']);
    });

    Route::prefix('applicants')->group(function () {
        Route::get('/', [ApplicantController::class, 'index']);
        Route::get('/formConfig', [ApplicantController::class, 'formConfig']);
        Route::get('/statuses', [ApplicantController::class, 'statuses']);
        Route::get('/{id}', [ApplicantController::class, 'show']);
        Route::post('/', [ApplicantController::class, 'store']);
        Route::patch('/{id}/status', [ApplicantController::class, 'updateStatus']);
        Route::patch('/{id}/checklist/{itemId}', [ApplicantController::class, 'toggleChecklistItem']);
        Route::patch('/{id}/interview', [ApplicantController::class, 'interview']);
        Route::patch('/{id}/interviewSummary', [ApplicantController::class, 'interviewSummary']);
        Route::get('/{id}/notes', [ApplicantController::class, 'notes']);
        Route::post('/{id}/notes', [ApplicantController::class, 'storeNote']);
        Route::put('/{id}/orientation', [ApplicantController::class, 'saveOrientation']);
    });

    Route::get('/applicantOrientations', [ApplicantController::class, 'orientationsIndex']);

    Route::post('/test-api', function (Request $request) {
        Log::info('Test API triggered', $request->all());
        return response()->json([
            'success' => true,
            'message' => 'API successfully triggered!',
        ]);
    });
});

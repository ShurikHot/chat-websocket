<?php

use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Chat\MessageStatusController;
use App\Http\Controllers\Forum\BranchController;
use App\Http\Controllers\Forum\MessageForumController;
use App\Http\Controllers\Forum\NotificationController;
use App\Http\Controllers\Forum\SectionController;
use App\Http\Controllers\Forum\ThemeController;
use App\Http\Controllers\ProfileController;
use BeyondCode\LaravelWebSockets\Statistics\Http\Controllers\WebSocketStatisticsEntriesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-websockets'], function () {
    Route::post('/statistics', [WebSocketStatisticsEntriesController::class, 'store']);
});

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chats.show');

    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/update_message_statuses', [MessageStatusController::class, 'update'])->name('message_statuses.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/sections', SectionController::class);
    Route::resource('/branches', BranchController::class);
    Route::resource('/themes', ThemeController::class);
    Route::resource('/fmessages', MessageForumController::class);

    Route::get('/sections/{section}/branches', [SectionController::class, 'getBranches']);
    Route::get('/themes/{branch}/create', [ThemeController::class, 'createWithBranchID'])->name('themes.branchId.create');
    Route::post('/fmessages/{message}/likes', [MessageForumController::class, 'like']);
    Route::post('/fmessages/{message}/complaint', [MessageForumController::class, 'complaint']);
    Route::post('/fmessages/{answer_user_id}/answer', [MessageForumController::class, 'answerNotification']);
    Route::patch('/notifications/update', [NotificationController::class, 'updateCollection'])->name('notifications.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [MainController::class, 'index'])->name('admin.index');
    Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('admin.complaints.index');
    Route::patch('/admin/complaints/{complaint}', [ComplaintController::class, 'update'])->name('admin.complaints.update');

    Route::resource('/admin/roles', RoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ]);

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/role/', [UserController::class, 'toggleRole'])->name('admin.users.toggle');
});


require __DIR__.'/auth.php';

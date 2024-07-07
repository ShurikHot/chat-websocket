<?php

use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Chat\MessageStatusController;
use App\Http\Controllers\Forum\BranchController;
use App\Http\Controllers\Forum\MessageForumController;
use App\Http\Controllers\Forum\SectionController;
use App\Http\Controllers\Forum\ThemeController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');

});

/*!!!!!!!!!!!!!  ОБНОВИТЬ КЭШ РОУТОВ  !!!!!!!!!!!!!!!!   php artisan route:cache   */

Route::middleware('auth')->group(function () {
    Route::resource('/sections', SectionController::class);
    Route::resource('/branches', BranchController::class);
    Route::resource('/themes', ThemeController::class);
    Route::resource('/fmessages', MessageForumController::class);

    Route::get('/sections/{section}/branches', [SectionController::class, 'getBranches']);
    Route::get('/themes/{branch}/create', [ThemeController::class, 'createWithBranchID'])->name('themes.branchId.create');
    Route::post('/fmessages/{message}/likes', [MessageForumController::class, 'like']);
    Route::post('/fmessages/{message}/complaint', [MessageForumController::class, 'complaint']);

    Route::get('/admin', [MainController::class, 'index'])->name('admin.index');
    Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('admin.complaints.index');
    Route::patch('/admin/complaints/{complaint}', [ComplaintController::class, 'update'])->name('admin.complaints.update');

    Route::resource('/admin/roles', RoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
/*        'show' => 'admin.roles.show',*/
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ]);
    /*Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles/', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/{roles}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');*/

});

/*!!!!!!!!!!!!!  ОБНОВИТЬ КЭШ РОУТОВ  !!!!!!!!!!!!!!!!   php artisan route:cache   */

require __DIR__.'/auth.php';

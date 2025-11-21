<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth routes (dari Breeze)
// require __DIR__ . '/auth.php';

Route::get('/', function () {
    return redirect()->route('login.form');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [WorkflowController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [WorkflowController::class, 'dash'])->name('admin.dashboard');
    Route::resource('workflows', WorkflowController::class);
    Route::get('workflows/{workflow}/stages/create', [WorkflowController::class, 'createStage'])->name('workflows.stages.create');
    Route::post('workflows/{workflow}/stages', [WorkflowController::class, 'storeStage'])->name('workflows.stages.store');
    Route::get('workflows/{workflow}/assign', [WorkflowController::class, 'assign'])->name('workflows.assign');
    Route::post('workflows/{workflow}/assign', [WorkflowController::class, 'storeAssign'])->name('workflows.assign.store');
});
// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'dash'])->name('user.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/workflows/{workflow}', [DashboardController::class, 'showWorkflow'])->name('user.workflow.show');
    Route::post('/stages/{stage}/evidence', [DashboardController::class, 'uploadEvidence'])->name('user.evidence.upload');
});

Route::get('workflows/{workflow}/delete', [WorkflowController::class, 'destroy'])
    ->name('delete.all');

// Delete stage
Route::get('stages/{stage}', [WorkflowController::class, 'destroyStage'])
    ->name('delete.stage');

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuditController;
use App\Http\Controllers\Api\SystemEventController;

use App\Http\Controllers\AuthController;

// routes/api.php
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/audit/user-actions', [AuditController::class, 'getUserActions'])->name('audit.getUserActions');
    Route::post('/audit/user-actions', [AuditController::class, 'storeUserAction'])->name('audit.storeUserAction');
    Route::get('/audit/system-events', [AuditController::class, 'getSystemEvents'])->name('audit.getSystemEvents');
    Route::post('/audit/system-events', [AuditController::class, 'storeSystemEvent'])->name('audit.storeSystemEvent');
    Route::put('/update-profile/{id}', [AuthController::class, 'updateProfile'])->name('update.profile');
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/system-events', [AuditController::class, 'auditSystemEvents'])->name('audit.system.events');
    Route::get('/user-actions', [AuditController::class, 'auditUserActions'])->name('audit.user.actions');
});
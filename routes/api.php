<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuditController;

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/audit/user-actions', [AuditController::class, 'getUserActions'])->name('audit.getUserActions');
    Route::post('/audit/user-actions', [AuditController::class, 'storeUserAction'])->name('audit.storeUserAction');
    Route::get('/audit/system-events', [AuditController::class, 'getSystemEvents'])->name('audit.getSystemEvents');
    Route::post('/audit/system-events', [AuditController::class, 'storeSystemEvent'])->name('audit.storeSystemEvent');
});
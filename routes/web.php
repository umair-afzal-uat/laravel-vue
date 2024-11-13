<?php

use App\Http\Controllers\Api\AuditController;
use Illuminate\Support\Facades\Route;

Route::get('/clearCache', [AuditController::class, 'clearCache'])->name('audit.clearCache');

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/{any}', function () {
//     return view('welcome'); 
// })->where('any', '.*');

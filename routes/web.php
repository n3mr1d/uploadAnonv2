<?php

use App\Http\Controllers\AdminPost;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\PastebinController;
use Illuminate\Support\Facades\Route;

// upload files
Route::post('/upload/files', [FilesController::class, 'store'])->name('upload.file');
Route::get('/', [FilesController::class, 'index'])->name('index');
Route::match(['get', 'post'], '/filesbin/{uuid}', [FilesController::class, 'showonefile'])->name('show.files');
Route::get('/upload/files/bulk/{bulk_id}', [FilesController::class, 'bulshow'])->name('show.bulk');
Route::post('/upload/deleted/action', [FilesController::class, 'destroy'])->name('destroy.files');
Route::post('/deleted/action', [FilesController::class, 'desbulk'])->name('desbulk');

// Pastebin routes
Route::get('/pastebin', [PastebinController::class, 'index'])->name('pastebin.index');
Route::post('/pastebin', [PastebinController::class, 'create'])->name('pastebin.store');
Route::match(['get', 'post'], '/pastebin/{uuid}', [PastebinController::class, 'show'])->name('pastebin.show');
Route::post('/pastebin/deleted/action', [PastebinController::class, 'destroy'])->name('pastebin.destory');

Route::get('/admin', [AdminPost::class, 'index'])->name('login')->middleware('guest');
Route::post('/admin', [AdminPost::class, 'login'])->name('admin.post');
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminPost::class, 'showDashboard'])->name('dashboard');
    Route::post('/admin/logout', [AdminPost::class, 'logout'])->name('admin.logout');
});

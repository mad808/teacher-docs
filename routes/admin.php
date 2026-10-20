<?php

use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('teachers', TeacherController::class);
Route::resource('students', StudentController::class)->except(['show']);
Route::resource('institutions', InstitutionController::class)->except(['show']);
Route::resource('departments', DepartmentController::class)->except(['show']);
Route::resource('lessons', LessonController::class)->except(['show']);

Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
    Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    Route::patch('/{document}/toggle-status', [DocumentController::class, 'toggleStatus'])->name('toggle-status');
    Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
});

Route::prefix('conversations')->name('conversations.')->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('index');
    Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
    Route::delete('/{conversation}', [ConversationController::class, 'destroy'])->name('destroy');
    Route::delete('/messages/{message}', [ConversationController::class, 'destroyMessage'])->name('messages.destroy');
});

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/', [SettingController::class, 'update'])->name('update');
});
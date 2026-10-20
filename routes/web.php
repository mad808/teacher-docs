<?php

use App\Http\Controllers\Front\ChatController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\TeacherController;
use App\Http\Controllers\Front\TeacherPortalController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::match(['get', 'post'], '/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'tk', 'ru'])) {
        abort(400);
    }

    session()->put('locale', $locale);
    cookie()->queue(cookie()->forever('locale', $locale));

    return redirect()->back();
})->name('locale.switch');

Route::match(['get', 'post'], '/locale/{locale}', function ($locale) {
    return redirect()->route('locale.switch', ['locale' => $locale]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/locale/{locale}', [HomeController::class, 'setLocale'])->name('locale.set');

Route::prefix('teachers')->name('teachers.')->group(function () {
    Route::get('/', [TeacherController::class, 'index'])->name('index');
    Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
});

Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
});

Route::middleware('auth')->group(function () {
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/start/{teacher}', [ChatController::class, 'start'])->name('start');
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [ChatController::class, 'sendMessage'])->name('send');
    });

    Route::prefix('teacher/portal')->name('teacher.portal.')->group(function () {
        Route::get('/dashboard', [TeacherPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [TeacherPortalController::class, 'editProfile'])->name('profile');
        Route::put('/profile', [TeacherPortalController::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents', [TeacherPortalController::class, 'documents'])->name('documents');
        Route::post('/documents', [TeacherPortalController::class, 'storeDocument'])->name('documents.store');
        Route::delete('/documents/{document}', [TeacherPortalController::class, 'destroyDocument'])->name('documents.destroy');
    });
});
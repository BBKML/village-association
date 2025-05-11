<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocalServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Admin\AdminAssociationController;
use App\Http\Controllers\Admin\AdminHistoryController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminLocalServiceController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\MediaGalleryController;

// ---------- FRONTEND ROUTES ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/histoire', [HistoryController::class, 'index'])->name('history.index');

Route::resource('activities', ActivityController::class)->only(['index', 'show']);
Route::resource('projects', ProjectController::class)->only(['index', 'show']);
Route::resource('news', NewsController::class)->only(['index', 'show']);
Route::resource('events', EventController::class)->only(['index', 'show']);
Route::get('/calendrier', [EventController::class, 'calendar'])->name('events.calendar');
Route::resource('services', LocalServiceController::class)->only(['index', 'show']);

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ---------- CAPTCHA ----------
Route::get('/refresh-captcha', function () {
    return response()->json(['captcha' => app('captcha')->create()]);
});

// ---------- AUTHENTICATION ROUTES ----------
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ---------- ADMIN ROUTES ----------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // Ensure AdminController exists or remove this route.

    Route::resource('associations', AdminAssociationController::class);
    Route::resource('history', AdminHistoryController::class);
    Route::resource('activities', AdminActivityController::class);
    Route::resource('projects', AdminProjectController::class);
    Route::resource('news', AdminNewsController::class);
    Route::resource('events', AdminEventController::class);
    Route::resource('services', AdminLocalServiceController::class);
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

    Route::resource('galleries', MediaGalleryController::class);
    Route::post('galleries/{gallery}/upload', [MediaGalleryController::class, 'upload'])->name('galleries.upload');
    Route::delete('media/{media}', [MediaGalleryController::class, 'destroyMedia'])->name('media.destroy');
});

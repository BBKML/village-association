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
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\PublicGalleryController;

use Mews\Captcha\Facades\Captcha;


// Admin Controllers
use App\Http\Controllers\Admin\AdminAssociationController;
use App\Http\Controllers\Admin\AdminHistoryController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminLocalServiceController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\MediaGalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MediaItemController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\MembershipController;
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// CAPTCHA Refresh
Route::get('/refresh-captcha', function () {
    return response()->json(['captcha' => Captcha::img()]);
})->name('refresh.captcha');

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Association
Route::get('/association', [AssociationController::class, 'about'])->name('association.about');
Route::get('/association/objectifs', [AssociationController::class, 'objectives'])->name('association.objectives');
Route::get('/association/membres', [AssociationController::class, 'members'])->name('association.members');
Route::get('/association/actions', [AssociationController::class, 'activities'])->name('association.activities');
Route::get('/association/projets', [AssociationController::class, 'projects'])->name('association.projects');
Route::get('/association/galerie', [AssociationController::class, 'gallery'])->name('association.gallery');
Route::get('/association/bureau', [AssociationController::class, 'boardMembers'])->name('association.board');
// Exemple d’une route simple vers un contrôleur 
Route::get('/membership/join', [MembershipController::class, 'join'])->name('membership.join');

// routes/web.php
Route::get('/galerie', [PublicGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galerie/{gallery}', [PublicGalleryController::class, 'show'])->name('galleries.show');
// Activities
Route::get('/actions', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/actions/{slug}', [ActivityController::class, 'show'])->name('activities.show');

// History
Route::get('/historique', [HistoryController::class, 'index'])->name('history.index');
Route::get('/historique/{slug}', [HistoryController::class, 'show'])->name('history.show');

// Projects
Route::get('/projets', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projets/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projets/{project:slug}/benevole', [ProjectController::class, 'volunteer'])->name('projects.volunteer');
Route::get('projets/{project}', [ProjectController::class, 'show'])->name('projects.show');

// News
Route::get('/actualites', [NewsController::class, 'index'])->name('news.index');
Route::get('/actualites/{news}', [NewsController::class, 'show'])->name('news.show');

// Events
Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/evenements/calendrier', [EventController::class, 'calendar'])->name('events.calendar');
Route::get('/evenements/archives', [EventController::class, 'past'])->name('events.past');
Route::get('/evenements/{event}', [EventController::class, 'show'])->name('events.show');

// Local Services
Route::get('/services-locaux', [LocalServiceController::class, 'index'])->name('services.index');
Route::get('/services-locaux/{service}', [LocalServiceController::class, 'show'])->name('services.show');

// Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');




/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Resources
    Route::resource('associations', AdminAssociationController::class);
    Route::resource('history', AdminHistoryController::class);
    Route::resource('activities', AdminActivityController::class);
    Route::resource('projects', AdminProjectController::class);
    Route::resource('news', AdminNewsController::class);
    Route::resource('events', AdminEventController::class);
    Route::resource('services', AdminLocalServiceController::class);
    Route::resource('members', MemberController::class);
    Route::resource('messages', ContactMessageController::class)->except(['create', 'edit']);
    
    // Media routes (corrigé)
    Route::resource('galleries', MediaGalleryController::class);
    Route::resource('media', MediaItemController::class)->except(['index', 'create', 'store']);

    // Custom Routes
    Route::post('projects/{project}/update-progress', [AdminProjectController::class, 'updateProgress'])
        ->name('projects.update-progress');
    Route::post('/news/{news}/toggle-publish', [AdminNewsController::class, 'togglePublish'])
        ->name('news.toggle-publish');
    Route::post('messages/{message}/mark-as-read', [ContactMessageController::class, 'markAsRead'])
        ->name('messages.mark-as-read');
    Route::post('/galleries/{gallery}/upload', [MediaGalleryController::class, 'upload'])
        ->name('galleries.upload');
    Route::post('/media/reorder', [MediaItemController::class, 'reorder'])
        ->name('media.reorder');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});
<?php

use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\FaqController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PackageController;
use App\Http\Controllers\Site\PageController;
use Illuminate\Support\Facades\Route;

// Default routes (redirect to default locale)
Route::get('/', function () {
    return redirect()->route('home', ['locale' => app()->getLocale()]);
});

// Multilingual routes
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'
], function () {


    Auth::routes();

    // Home routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

    // Contact routes
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

    // Other pages
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/package', [PackageController::class, 'index'])->name('package');

    // Category and News routes
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

    // Page routes (dynamic pages)
    Route::get('/page/{page}', [PageController::class, 'show'])->name('page.show');

});

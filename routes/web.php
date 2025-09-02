<?php

use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\FaqController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PackageController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('profile', [HomeController::class, 'profile'])->name('profile');

Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact', [ContactController::class, 'send'])->name('contact');

Route::get('faq', [FaqController::class, 'index'])->name('faq');
Route::get('package', [PackageController::class, 'index'])->name('package');

Route::get('category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{news}', [NewsController::class, 'show'])->name('news.show');

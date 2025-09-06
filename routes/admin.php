<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StaticBlockController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->as('auth.')
    ->controller(LoginController::class)
    ->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
        Route::get('logout', 'logout')->name('logout')->middleware('auth');
    });


Route::middleware('auth')
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


        // Access Control
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class)->middleware(['protect_system_roles']);
        Route::resource('permissions', PermissionController::class);

        // Content Management
        Route::resource('categories', CategoryController::class);
        Route::resource('languages', LanguageController::class);
        Route::resource('news', NewsController::class);
        Route::resource('pages', PageController::class);
        Route::resource('faqs', FaqController::class);

        // Website Management
        Route::resource('menus', MenuController::class);
        Route::resource('menu-items', MenuItemController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('static-blocks', StaticBlockController::class);
        Route::resource('testimonials', TestimonialController::class);

        // Business Management
        Route::resource('packages', PackageController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('currencies', CurrencyController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('regions', RegionController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('transactions', TransactionController::class);

        // System
        Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show']);
        Route::resource('settings', SettingController::class)->only(['index']);

        // Setting specific routes
        Route::post('settings/bulk-update', [SettingController::class, 'bulkUpdate'])->name('settings.bulk-update');

    });

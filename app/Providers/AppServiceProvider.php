<?php

namespace App\Providers;

//Interfaces
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\LanguageInterface;
use App\Interfaces\PartnerInterface;
use App\Interfaces\CurrencyInterface;

//Repositories
use App\Models\Menu;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\CurrencyRepository;

//Others
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LanguageInterface::class, UserRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(PartnerInterface::class, PartnerRepository::class);
        $this->app->bind(CurrencyInterface::class, CurrencyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale based on app locale
        Carbon::setLocale(config('app.locale'));

        // Set PHP locale for date formatting
        $locale = config('app.locale');
        if ($locale === 'az') {
            setlocale(LC_TIME, 'az_AZ.UTF-8', 'az_AZ', 'az');
        } elseif ($locale === 'tr') {
            setlocale(LC_TIME, 'tr_TR.UTF-8', 'tr_TR', 'tr');
        }

        //Rate limiter for api routes
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip());
        });


        // Super Admin roluna tam icazə veririk
        try {
            if (Schema::hasTable('roles')) {
                Gate::before(function ($user, $ability) {
                    return $user->hasRole('Super Admin') ? true : null;
                });
            }
        } catch (\Exception $e) {
            // Migration zamanı xətaların qarşısını alırıq
        }

        // Route Model Binding for ActivityLog
        try {
            if (Schema::hasTable('activity_log')) {
                Route::bind('activityLog', function ($value) {
                    return ActivityLog::findOrFail($value);
                });
            }
        } catch (\Exception $e) {
            // Migration zamanı xətaların qarşısını alırıq
        }

        Paginator::useBootstrapFive();

        // Cədvəl mövcud olub-olmadığını yoxlayırıq
        $headerMenu = null;
        $footerMenu = null;

        try {
            // Əgər cədvəl mövcuddursa, sorğuları icra edirik
            if (Schema::hasTable('menus')) {
                $headerMenu = Menu::query()
                    ->with('menuItems')
                    ->where('status', true)
                    ->where('location', 'header')
                    ->first();

                $footerMenu = Menu::query()
                    ->with('menuItems')
                    ->where('status', true)
                    ->where('location', 'footer')
                    ->first();
            }
        } catch (\Exception $e) {
            // Xəta baş verərsə, heç nə etmirik
            // Bu, migration zamanı xətaların qarşısını alır
        }

        View()->share([
            'headerMenu' => $headerMenu,
            'footerMenu' => $footerMenu,
            'site_name' => getSiteName() ?? config('app.name', 'Laravel')
        ]);
    }
}

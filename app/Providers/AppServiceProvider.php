<?php

namespace App\Providers;

//Interfaces
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\LanguageInterface;
//Repositories
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

//Others
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
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


        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Route Model Binding for ActivityLog
        Route::bind('activityLog', function ($value) {
            return ActivityLog::findOrFail($value);
        });

        Paginator::useBootstrapFive();
    }
}

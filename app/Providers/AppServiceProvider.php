<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Interfaces\SubscriptionTypesRepositoryInterface;
use App\Models\Setting;
use App\Repositories\SubscriptionTypesRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            SubscriptionTypesRepositoryInterface::class,
            SubscriptionTypesRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        view()->composer('*', function ($view) { {

                $sitting =   Setting::first();
                $view->with('sitting', $sitting);
            }
        });
    }
}
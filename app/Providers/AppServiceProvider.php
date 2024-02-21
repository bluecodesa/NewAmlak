<?php

namespace App\Providers;

use App\Interfaces\Admin\SettingRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Interfaces\Admin\SubscriptionTypesRepositoryInterface;
use App\Interfaces\Office\AdvisorRepositoryInterface;
use App\Interfaces\Office\DeveloperRepositoryInterface;
use App\Interfaces\Office\EmployeeRepositoryInterface;
use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Models\Setting;
use App\Repositories\Admin\SettingRepository;
use App\Repositories\Admin\SubscriptionTypesRepository;
use App\Repositories\Office\AdvisorRepository;
use App\Repositories\Office\DeveloperRepository;
use App\Repositories\Office\EmployeeRepository;
use App\Repositories\Office\OwnerRepository;
use App\Repositories\Office\ProjectRepository;

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

        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class
        );

        $this->app->bind(
            AdvisorRepositoryInterface::class,
            AdvisorRepository::class
        );

        $this->app->bind(
            DeveloperRepositoryInterface::class,
            DeveloperRepository::class
        );

        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );


        $this->app->bind(
            OwnerRepositoryInterface::class,
            OwnerRepository::class
        );

        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
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

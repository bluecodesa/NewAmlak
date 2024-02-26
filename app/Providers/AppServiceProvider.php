<?php

namespace App\Providers;

use App\Interfaces\Admin\CityRepositoryInterface;
use App\Interfaces\Admin\DistrictRepositoryInterface;
use App\Interfaces\Admin\PaymentGatewayInterface;
use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\PropertyTypeRepositoryInterface;
use App\Interfaces\Admin\PropertyUsageRepositoryInterface;
use App\Interfaces\Admin\RegionRepositoryInterface;
use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Interfaces\Admin\SectionRepositoryInterface;
use App\Interfaces\Admin\ServiceTypeRepositoryInterface;
use App\Interfaces\Admin\SettingRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Interfaces\Admin\SubscriptionTypesRepositoryInterface;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Interfaces\Office\AdvisorRepositoryInterface;
use App\Interfaces\Office\DeveloperRepositoryInterface;
use App\Interfaces\Office\EmployeeRepositoryInterface;
use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Models\Setting;
use App\Repositories\Admin\CityRepository;
use App\Repositories\Admin\DistrictRepository;
use App\Repositories\Admin\PaymentGatewayRepository;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\PropertyTypeRepository;
use App\Repositories\Admin\PropertyUsageRepository;
use App\Repositories\Admin\RegionRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\SectionRepository;
use App\Repositories\Admin\ServiceTypeRepository;
use App\Repositories\Admin\SettingRepository;
use App\Repositories\Admin\SubscriptionTypesRepository;
use App\Repositories\Admin\SystemInvoiceRepository;
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
            SystemInvoiceRepositoryInterface::class,
            SystemInvoiceRepository::class
        );


        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class
        );
        $this->app->bind(
            PaymentGatewayRepositoryInterface::class,
            PaymentGatewayRepository::class
        );



        $this->app->bind(

            \App\Interfaces\Admin\SubscriptionRepositoryInterface::class,
            \App\Repositories\Admin\SubscriptionRepository::class
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


        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );

        $this->app->bind(
            DistrictRepositoryInterface::class,
            DistrictRepository::class
        );

        $this->app->bind(
            PropertyTypeRepositoryInterface::class,
            PropertyTypeRepository::class
        );

        $this->app->bind(
            PropertyUsageRepositoryInterface::class,
            PropertyUsageRepository::class
        );

        $this->app->bind(
            RegionRepositoryInterface::class,
            RegionRepository::class
        );

        $this->app->bind(
            SectionRepositoryInterface::class,
            SectionRepository::class
        );


        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );


        $this->app->bind(
            ServiceTypeRepositoryInterface::class,
            ServiceTypeRepository::class
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

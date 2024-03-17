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
use App\Interfaces\Admin\ServiceRepositoryInterface;
use App\Interfaces\Admin\ServiceTypeRepositoryInterface;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Interfaces\Admin\SubscriptionRepositoryInterface;
use App\Interfaces\Admin\SubscriptionTypeRepositoryInterface;
use App\Interfaces\Admin\SupportRepositoryInterface;
use App\Repositories\Admin\SupportRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Interfaces\Broker\AdvisorRepositoryInterface as BrokerAdvisorRepositoryInterface;
use App\Interfaces\Broker\DeveloperRepositoryInterface as BrokerDeveloperRepositoryInterface;
use App\Interfaces\Broker\OwnerRepositoryInterface as BrokerOwnerRepositoryInterface;
use App\Interfaces\Broker\ProjectRepositoryInterface as BrokerProjectRepositoryInterface;
use App\Interfaces\Broker\PropertyRepositoryInterface;
use App\Interfaces\Broker\SettingRepositoryInterface as BrokerSettingRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Interfaces\Office\AdvisorRepositoryInterface;
use App\Interfaces\Office\DeveloperRepositoryInterface;
use App\Interfaces\Office\EmployeeRepositoryInterface;
use App\Interfaces\Office\OwnerRepositoryInterface;
use App\Interfaces\Office\ProjectRepositoryInterface;
use App\Interfaces\Broker\GalleryRepositoryInterface;
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
use App\Repositories\Admin\ServiceRepository;
use App\Repositories\Admin\ServiceTypeRepository;
use App\Repositories\Admin\SettingRepository;
use App\Repositories\Admin\SubscriptionRepository;
use App\Repositories\Admin\SubscriptionTypeRepository;
use App\Repositories\Admin\SystemInvoiceRepository;
// Broker
use App\Repositories\Broker\AdvisorRepository as BrokerAdvisorRepository;
use App\Repositories\Broker\DeveloperRepository as BrokerDeveloperRepository;
use App\Repositories\Broker\GalleryRepository;
use App\Repositories\Broker\OwnerRepository as BrokerOwnerRepository;
use App\Repositories\Broker\ProjectRepository as BrokerProjectRepository;
use App\Repositories\Broker\PropertyRepository;
use App\Repositories\Broker\SettingRepository as BrokerSettingRepository;
use App\Repositories\Broker\UnitRepository;
// office
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
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );
        $this->app->bind(
            SubscriptionTypeRepositoryInterface::class,
            SubscriptionTypeRepository::class
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
            BrokerSettingRepositoryInterface::class,
            BrokerSettingRepository::class
        );
        $this->app->bind(
            PaymentGatewayRepositoryInterface::class,
            PaymentGatewayRepository::class
        );

        $this->app->bind(
            GalleryRepositoryInterface::class,
            GalleryRepository::class
        );




        $this->app->bind(
            AdvisorRepositoryInterface::class,
            AdvisorRepository::class
        );
        $this->app->bind(
            BrokerAdvisorRepositoryInterface::class,
            BrokerAdvisorRepository::class
        );

        $this->app->bind(
            DeveloperRepositoryInterface::class,
            DeveloperRepository::class
        );
        $this->app->bind(
            BrokerDeveloperRepositoryInterface::class,
            BrokerDeveloperRepository::class
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
            BrokerOwnerRepositoryInterface::class,
            BrokerOwnerRepository::class
        );

        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
        );
        $this->app->bind(
            BrokerProjectRepositoryInterface::class,
            BrokerProjectRepository::class
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
            SupportRepositoryInterface::class,
            SupportRepository::class
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

        $this->app->bind(
            PropertyRepositoryInterface::class,
            PropertyRepository::class
        );

        $this->app->bind(
            ServiceRepositoryInterface::class,
            ServiceRepository::class
        );

        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
        );

        $this->app->bind(
            BrokerDeveloperRepositoryInterface::class,
            BrokerDeveloperRepository::class
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

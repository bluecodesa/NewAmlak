<?php

namespace App\Providers;

use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Interfaces\Admin\CityRepositoryInterface;
use App\Interfaces\Admin\DistrictRepositoryInterface;
use App\Interfaces\Admin\FalLicenseRepositoryInterface;
use App\Interfaces\Admin\PartnerSuccessRepositoryInterface;
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
use App\Interfaces\Office\WalletRepositoryInterface;
use App\Repositories\Admin\SupportRepository;
use App\Repositories\Broker\TicketRepository;
use App\Repositories\Office\RenterRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Interfaces\Admin\TicketTypeRepositoryInterface;
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
use App\Interfaces\Office\ProjectRepositoryInterface as OfficeProjectRepositoryInterface;
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
use App\Interfaces\Broker\TicketRepositoryInterface;
use App\Interfaces\Broker\UnitInterestRepositoryInterface;
use App\Repositories\Admin\TicketTypeRepository;
use App\Repositories\Broker\UnitInterestRepository;
// office
use App\Repositories\Office\AdvisorRepository;
use App\Repositories\Office\DeveloperRepository;
use App\Repositories\Office\EmployeeRepository;
use App\Repositories\Office\OwnerRepository;
use App\Repositories\Office\ProjectRepository as OfficeProjectRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Interfaces\Admin\ProjectRepositoryInterface;
use App\Interfaces\Admin\ProviderServiceRepositoryInterface;
use App\Interfaces\Admin\WalletTypeRepositoryInterface;
use App\Interfaces\Employee\ProjectRepositoryInterface as EmployeeProjectRepositoryInterface;
use App\Interfaces\Employee\SettingRepositoryInterface as EmployeeSettingRepositoryInterface;
use App\Interfaces\Employee\UnitRepositoryInterface as EmployeeUnitRepositoryInterface;
use App\Interfaces\Home\GalleryRepositoryInterface as InterfacesHomeGalleryRepositoryInterface;
use App\Interfaces\Home\RealEstateRequestRepositoryInterface;
use App\Interfaces\Office\ContractRepositoryInterface;
use App\Interfaces\Office\GalleryRepositoryInterface as OfficeGalleryRepositoryInterface;
use App\Interfaces\Office\PropertyRepositoryInterface as OfficePropertyRepositoryInterface;
use App\Interfaces\Office\RenterRepositoryInterface;
use App\Interfaces\Office\SettingRepositoryInterface as OfficeSettingRepositoryInterface;
use App\Interfaces\Office\UnitInterestRepositoryInterface as OfficeUnitInterestRepositoryInterface;
use App\Interfaces\Office\UnitRepositoryInterface as OfficeUnitRepositoryInterface;
use App\Interfaces\ServiceProvider\ProviderServiceRepositoryInterface as ServiceProviderProviderServiceRepositoryInterface;
use App\Interfaces\ServiceProvider\SettingRepositoryInterface as ServiceProviderSettingRepositoryInterface;
use App\Repositories\Admin\AdvertisingRepository;
use App\Repositories\Admin\FalLicenseRepository;
use App\Repositories\Admin\PartnerSuccessRepository;
use App\Repositories\Admin\ProjectRepository;
use App\Repositories\Admin\ProviderServiceRepository;
use App\Repositories\Office\WalletRepository;
use App\Repositories\Admin\WalletTypeRepository;
use App\Repositories\Employee\ProjectRepository as EmployeeProjectRepository;
use App\Repositories\Employee\SettingRepository as EmployeeSettingRepository;
use App\Repositories\Employee\UnitRepository as EmployeeUnitRepository;
use App\Repositories\Home\RealEstateRequestRepository;
use App\Repositories\Office\ContractRepository;
use App\Repositories\Office\GalleryRepository as OfficeGalleryRepository;
use App\Repositories\Office\PropertyRepository as OfficePropertyRepository;
use App\Repositories\Office\SettingRepository as OfficeSettingRepository;
use App\Repositories\Office\UnitInterestRepository as OfficeUnitInterestRepository;
use App\Repositories\Office\UnitRepository as OfficeUnitRepository;

use App\Repositories\Home\GalleryRepository as homeGalleryRepository;
use App\Repositories\ServiceProvider\ProviderServiceRepository as ServiceProviderProviderServiceRepository;
use App\Repositories\ServiceProvider\SettingRepository as ServiceProviderSettingRepository;
use App\Services\NafathService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(NafathService::class, function ($app) {
            return new NafathService();
        });

        $this->app->bind(
            UnitInterestRepositoryInterface::class,
            UnitInterestRepository::class
        );
        $this->app->bind(
            OfficeUnitInterestRepositoryInterface::class,
            OfficeUnitInterestRepository::class
        );

        $this->app->bind(
            TicketTypeRepositoryInterface::class,
            TicketTypeRepository::class
        );

        $this->app->bind(
            SupportRepositoryInterface::class,
            SupportRepository::class
        );
        $this->app->bind(
            TicketRepositoryInterface::class,
            TicketRepository::class
        );
        $this->app->bind(
            RealEstateRequestRepositoryInterface::class,
            RealEstateRequestRepository::class
        );

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
            OfficeSettingRepositoryInterface::class,
            OfficeSettingRepository::class
        );
        $this->app->bind(
            EmployeeSettingRepositoryInterface::class,
            EmployeeSettingRepository::class
        );

        $this->app->bind(
            ServiceProviderSettingRepositoryInterface::class,
            ServiceProviderSettingRepository::class
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
            OfficeGalleryRepositoryInterface::class,
            OfficeGalleryRepository::class
        );

        $this->app->bind(
            InterfacesHomeGalleryRepositoryInterface::class,
            HomeGalleryRepository::class
        );

        $this->app->bind(
            AdvertisingRepositoryInterface::class,
            AdvertisingRepository::class
        );

        $this->app->bind(
            PartnerSuccessRepositoryInterface::class,
            PartnerSuccessRepository::class
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
            RenterRepositoryInterface::class,
            RenterRepository::class
        );
        $this->app->bind(
            BrokerOwnerRepositoryInterface::class,
            BrokerOwnerRepository::class
        );

        $this->app->bind(
            ContractRepositoryInterface::class,
            ContractRepository::class
        );

        $this->app->bind(
            OfficeProjectRepositoryInterface::class,
            OfficeProjectRepository::class
        );

        $this->app->bind(
            EmployeeProjectRepositoryInterface::class,
            EmployeeProjectRepository::class
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
            FalLicenseRepositoryInterface::class,
            FalLicenseRepository::class
        );



        $this->app->bind(
            WalletTypeRepositoryInterface::class,
            WalletTypeRepository::class
        );

        $this->app->bind(
            ProviderServiceRepositoryInterface::class,
            ProviderServiceRepository::class
        );

        $this->app->bind(
            ServiceProviderProviderServiceRepositoryInterface::class,
            ServiceProviderProviderServiceRepository::class
        );


        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class
        );

        $this->app->bind(
            SupportRepositoryInterface::class,
            SupportRepository::class
        );

        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
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
            OfficePropertyRepositoryInterface::class,
            OfficePropertyRepository::class
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
            OfficeUnitRepositoryInterface::class,
            OfficeUnitRepository::class
        );
        $this->app->bind(
            EmployeeUnitRepositoryInterface::class,
            EmployeeUnitRepository::class
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
        if (Auth::check()) {
            $url = URL::current();
            if (isset(auth()->user()->unreadNotifications)) {
                $notifications = auth()->user()->unreadNotifications
                    ->filter(function ($notification) use ($url) {
                        return data_get($notification->data, 'url') == $url;
                    });
                $notifications->each(function ($notification) {
                    $notification->markAsRead();
                });
            }
        }
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

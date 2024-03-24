<?php

use App\Http\Controllers\Admin\General\CityController;
use App\Http\Controllers\Admin\General\DistrictController;
use App\Http\Controllers\Admin\General\PropertyTypeController;
use App\Http\Controllers\Admin\General\PropertyUsageController;
use App\Http\Controllers\Admin\General\RegionController;
use App\Http\Controllers\Admin\General\ServiceController;
use App\Http\Controllers\Admin\General\ServiceTypeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProjectManagement\AdvisorController;
use App\Http\Controllers\Admin\ProjectManagement\DeveloperController;
use App\Http\Controllers\Admin\ProjectManagement\EmployeeController;
use App\Http\Controllers\Admin\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionTypesController;
use App\Http\Controllers\Admin\Subscribers\SystemInvoiceController;
use App\Http\Controllers\Admin\SubUserController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\UserController;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'CheckSubscription', 'redirect.users']
    ],
    function () {
        Route::prefix('app')->name('Admin.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/payment-gateways/{id}/edit', [SettingController::class, 'editPaymentGatewayForm'])->name('payment-gateways.edit');
            Route::put('/payment-gateways/{id}', [SettingController::class, 'updatePaymentGateway'])->name('update-payment-gateway');
            Route::post('/payment-gateways/create', [SettingController::class, 'createPaymentGateway'])->name('create-payment-gateway');
            Route::get('/ChangeActiveHomePage', [SettingController::class, 'ChangeActiveHomePage'])->name('Setting.ChangeActiveHomePage');
            Route::post('/create-broker-subscribers', [SubUserController::class, 'createBrokerSubscribers'])->name('create-broker-subscribers');
            Route::get('/update-broker-subscribers/{id}', [SubUserController::class, 'editbroker'])->name('edit-broker-subscribers');
            Route::put('/update-broker-subscribers/{id}', [SubUserController::class, 'updatebroker'])->name('update-broker-subscribers');
            Route::delete('delete-broker-subscribers/{id}', [SubUserController::class, 'deletebroker'])->name('delete-broker-subscribers');
            Route::put('/taxs/{setting}', [SettingController::class, 'updateTax'])->name('update-tax');
            Route::get('NotificationSetting/{id}', [SettingController::class, 'NotificationSetting'])->name('update.NotificationSetting');
            Route::post('UpdateEmailSetting', [SettingController::class, 'UpdateEmailSetting'])->name('update.UpdateEmailSetting');
            Route::get('EditEmailTemplate/{id}', [SettingController::class, 'EditEmailTemplate'])->name('update.EditEmailTemplate');
            Route::post('StoreEmailTemplate/{id}', [SettingController::class, 'StoreEmailTemplate'])->name('update.StoreEmailTemplate');
            Route::post('StoreNewNotification', [SettingController::class, 'StoreNewNotification'])->name('StoreNewNotification');
            Route::get('TestSendMail', [SettingController::class, 'TestSendMail'])->name('update.TestSendMail');
            Route::get('/interests-type', [SettingController::class, 'showAllInterestTypes'])->name('interests-types');
            Route::get('/interests-type', [SettingController::class, 'createInterestType'])->name('create.interest-type');
            Route::post('/interests-type', [SettingController::class, 'storeInterestType'])->name('store.interest-type');
            Route::get('/interests-type/{id}', [SettingController::class, 'editInterestType'])->name('edit.interest-type');
            Route::put('/interests-type/{id}', [SettingController::class, 'updateInterestType'])->name('update.interest-type');
            Route::delete('/interests-type/{id}', [SettingController::class, 'destroyInterestType'])->name('delete.interest-type');
            //support tickets
            Route::get('/TicketsTypes', [SupportController::class, 'getAllTicketTypes'])->name('SupportTickets.tickets-type');
            Route::get('/ticketType/create', [SupportController::class, 'createTicketType'])->name('SupportTickets.createTicketType');
            Route::post('/ticketType/store', [SupportController::class, 'storeTicketType'])->name('SupportTickets.storeTicketType');
            Route::get('/ticketType/{id}/edit', [SupportController::class, 'editTicketType'])->name('SupportTickets.editTicketType');
            Route::put('/ticketType/{id}/update', [SupportController::class, 'updateTicketType'])->name('SupportTickets.updateTicketType');
            Route::delete('/ticketType/{id}/destroy', [SupportController::class, 'destroyTicketType'])->name('SupportTickets.destroyTicketType');
            Route::post('SupportTickets/{ticketId}/add-response', [SupportController::class, 'addResponse'])->name('SupportTickets.addResponse');
            Route::post('SupportTickets/{id}/close', [SupportController::class, 'closeTicket'])->name('closeTicket');
            Route::get('/InfoSupport', [SupportController::class, 'showInfoSupport'])->name('Support.showInfoSupport');




            Route::resources([
                'roles' => RoleController::class,
                'users' => UserController::class,
                'offices' => OfficeController::class,
                'SubscriptionTypes' => SubscriptionTypesController::class,
                'Subscribers' => SubscriptionController::class,
                'Permissions' => PermissionController::class,
                'settings' => SettingController::class,
                'Sections' => SectionController::class,
                'Region' => RegionController::class,
                'City' => CityController::class,
                'District' => DistrictController::class,
                'Developer' => DeveloperController::class,
                'Advisor' => AdvisorController::class,
                'SystemInvoice' => SystemInvoiceController::class,
                'Owner' => OwnerController::class,
                'Employee' => EmployeeController::class,
                'PropertyType' => PropertyTypeController::class,
                'PropertyUsage' => PropertyUsageController::class,
                'ServiceType' => ServiceTypeController::class,
                'Service' => ServiceController::class,
                'SupportTickets' => SupportController::class,


            ]);
            Route::get('Subscribers.CreateBroker', [SubscriptionController::class, 'createBroker'])->name('Subscribers.CreateBroker');
            Route::post('Subscribers.CreateBroker', [SubscriptionController::class, 'storeBroker'])->name('Subscribers.CreateBroker');
            Route::post('Subscribers.SuspendSubscription/{id}', [SubscriptionController::class, 'SuspendSubscription'])->name('Subscribers.SuspendSubscription');
        });
    }
);


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Auth::routes();
    }
);

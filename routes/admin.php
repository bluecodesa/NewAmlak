<?php

use App\Http\Controllers\Admin\AdvertisingController;
use App\Http\Controllers\Admin\FalLicenseController;
use App\Http\Controllers\Admin\General\CityController;
use App\Http\Controllers\Admin\General\DistrictController;
use App\Http\Controllers\Admin\General\PropertyTypeController;
use App\Http\Controllers\Admin\General\PropertyUsageController;
use App\Http\Controllers\Admin\General\RegionController;
use App\Http\Controllers\Admin\General\ServiceController;
use App\Http\Controllers\Admin\General\ServiceTypeController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PartnerSuccessController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProjectManagement\AdvisorController;
use App\Http\Controllers\Admin\ProjectManagement\DeveloperController;
use App\Http\Controllers\Admin\ProjectManagement\EmployeeController;
use App\Http\Controllers\Admin\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\ProjectManagement\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionTypesController;
use App\Http\Controllers\Admin\Subscribers\SystemInvoiceController;
use App\Http\Controllers\Admin\SubUserController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletTypeController;
use App\Http\Controllers\Broker\TicketController;
use App\Http\Controllers\ReceiptController;
use App\Models\City;
use App\Models\Subscription;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'CheckSubscription', 'redirect.users', 'checkUserRole:admin']
    ],
    function () {
        Route::prefix('app')->name('Admin.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/ContactUs', 'HomeController@ContactUs')->name('ContactUs');
            Route::get('/payment-gateways/{id}/edit', [SettingController::class, 'editPaymentGatewayForm'])->name('payment-gateways.edit');
            Route::put('/payment-gateways/{id}', [SettingController::class, 'updatePaymentGateway'])->name('update-payment-gateway');
            Route::post('/payment-gateways/create', [SettingController::class, 'createPaymentGateway'])->name('create-payment-gateway');
            Route::post('/bank-accounts/create', [SettingController::class, 'createBankAccount'])->name('create-bank-account');
            Route::put('/bank-accounts/{id}', [SettingController::class, 'updateBankAccount'])->name('update-bank-account');
            Route::get('/ChangeActiveHomePage', [SettingController::class, 'ChangeActiveHomePage'])->name('Setting.ChangeActiveHomePage');
            Route::get('/ChangeActiveGalleryPage', [SettingController::class, 'ChangeActiveGalleryPage'])->name('Setting.ChangeActiveGalleryPage');
            Route::get('/ChangeActiveRegisterUsers', [SettingController::class, 'ChangeActiveRegisterUsers'])->name('Setting.ChangeActiveRegisterUsers');
            Route::post('/create-broker-subscribers', [SubUserController::class, 'createBrokerSubscribers'])->name('create-broker-subscribers');
            Route::get('/update-broker-subscribers/{id}', [SubUserController::class, 'editbroker'])->name('edit-broker-subscribers');
            Route::put('/update-broker-subscribers/{id}', [SubUserController::class, 'updatebroker'])->name('update-broker-subscribers');
            Route::delete('delete-broker-subscribers/{id}', [SubUserController::class, 'deletebroker'])->name('delete-broker-subscribers');
            Route::delete('delete-client/{id}', [SubscriptionController::class, 'deleteClient'])->name('delete-client');
            Route::get('show-client/{id}', [SubscriptionController::class, 'showClient'])->name('show-client');
            Route::put('/ChangeAds', [SettingController::class, 'updateAds'])->name('Setting.updateAds');

            Route::put('/taxs/{setting}', [SettingController::class, 'updateTax'])->name('update-tax');
            Route::get('NotificationSetting/{id}', [SettingController::class, 'NotificationSetting'])->name('update.NotificationSetting');
            Route::post('UpdateEmailSetting', [SettingController::class, 'UpdateEmailSetting'])->name('update.UpdateEmailSetting');
            Route::post('UpdateWhatsAppSetting', [SettingController::class, 'UpdateWhatsAppSetting'])->name('update.UpdateWhatsAppSetting');
            Route::get('EditEmailTemplate/{id}', [SettingController::class, 'EditEmailTemplate'])->name('update.EditEmailTemplate');
            Route::get('EditWhatsAppTemplate/{id}', [SettingController::class, 'EditWhatsAppTemplate'])->name('update.EditWhatsAppTemplate');

            Route::post('StoreEmailTemplate/{id}', [SettingController::class, 'StoreEmailTemplate'])->name('update.StoreEmailTemplate');
            Route::post('StoreWhatsAppTemplate/{id}', [SettingController::class, 'StoreWhatsAppTemplate'])->name('update.StoreWhatsAppTemplate');

            Route::post('StoreNewNotification', [SettingController::class, 'StoreNewNotification'])->name('StoreNewNotification');
            Route::get('TestSendMail', [SettingController::class, 'TestSendMail'])->name('update.TestSendMail');

            Route::get('/interests-type', [SettingController::class, 'showAllInterestTypes'])->name('interests-types');
            Route::get('/interests-type', [SettingController::class, 'createInterestType'])->name('create.interest-type');
            Route::post('/interests-type', [SettingController::class, 'storeInterestType'])->name('store.interest-type');
            Route::get('/interests-type/{id}', [SettingController::class, 'editInterestType'])->name('edit.interest-type');
            Route::put('/interests-type/{id}', [SettingController::class, 'updateInterestType'])->name('update.interest-type');
            Route::delete('/interests-type/{id}', [SettingController::class, 'destroyInterestType'])->name('delete.interest-type');
            Route::get('/NotificationsManagement', [SettingController::class, 'NotificationsManagement'])->name('NotificationsManagement');
            Route::get('/UpdateNotificationsManagement', [SettingController::class, 'UpdateNotificationsManagement'])->name('UpdateNotificationsManagement');
            Route::get('/AddNotificationsManagement', [SettingController::class, 'AddNotificationsManagement'])->name('AddNotificationsManagement');
            Route::get('/PrivacyPage', [SettingController::class, 'PrivacyPage'])->name('PrivacyPage');
            Route::post('/UpdatePrivacy', [SettingController::class, 'UpdatePrivacy'])->name('UpdatePrivacy');

            Route::get('/TermsPage', [SettingController::class, 'TermsPage'])->name('TermsPage');
            Route::post('/UpdateTerms', [SettingController::class, 'UpdateTerms'])->name('UpdateTerms');




            Route::put('/updateNumOfEmployee/{id}', [SubscriptionController::class, 'updateNumOfEmployee'])->name('updateNumOfEmployee');



            //support tickets
            Route::get('/TicketsTypes', [SupportController::class, 'getAllTicketTypes'])->name('SupportTickets.tickets-type');
            Route::get('/ticketType/create', [SupportController::class, 'createTicketType'])->name('SupportTickets.createTicketType');
            Route::post('tickets/{id}/close', [SupportController::class, 'closeTicket'])->name('closeTicket');

            Route::post('/ticketType/store', [SupportController::class, 'storeTicketType'])->name('SupportTickets.storeTicketType');
            Route::get('/ticketType/{id}/edit', [SupportController::class, 'editTicketType'])->name('SupportTickets.editTicketType');
            Route::put('/ticketType/{id}/update', [SupportController::class, 'updateTicketType'])->name('SupportTickets.updateTicketType');
            Route::delete('/ticketType/{id}/destroy', [SupportController::class, 'destroyTicketType'])->name('SupportTickets.destroyTicketType');

            Route::post('SupportTickets/{ticketId}/add-response', [SupportController::class, 'addResponse'])->name('SupportTickets.addResponse');
            Route::post('SupportTickets/{id}/close', [SupportController::class, 'closeTicket'])->name('closeTicket');
            Route::get('/InfoSupport', [SupportController::class, 'showInfoSupport'])->name('Support.showInfoSupport');
            Route::put('InfoSupport/update', [SupportController::class, 'updateInfoSupport'])->name('InfoSupport.update');
            // delviry cases

            Route::get('/project-DelviryCases', [ProjectController::class, 'getAllDeliveryCases'])->name('ProjectSettings.delivery-cases');
            Route::get('/project-DelviryCases/create', [ProjectController::class, 'createDeliveryCase'])->name('ProjectSettings.createDelivery-case');
            Route::post('/project-DelviryCases/store', [ProjectController::class, 'storeDeliveryCase'])->name('ProjectSettings.storeDelivery-case');
            Route::get('/project-DelviryCases/{id}/edit', [ProjectController::class, 'editDeliveryCase'])->name('ProjectSettings.editDelivery-case');
            Route::put('/project-DelviryCases/{id}/update', [ProjectController::class, 'updateDeliveryCase'])->name('ProjectSettings.updateDelivery-case');
            Route::delete('/project-DelviryCases/{id}/destroy', [ProjectController::class, 'deleteDeliveryCase'])->name('ProjectSettings.destroyDelivery-case');


            //Receipts
            Route::get('/receipts', [ReceiptController::class, 'indexReceipt'])->name('Receipt.index');
            Route::get('/receipt/{id}', [ReceiptController::class, 'showReceipt'])->name('Receipt.show');
            Route::put('/receipt/update-status/{id}', [ReceiptController::class, 'updateStatus'])->name('Receipt.updateStatus');
            Route::post('/receipts/{id}/comment', [ReceiptController::class, 'addComment'])->name('Receipt.addComment');





            //
            Route::resource('PartnerSuccess', PartnerSuccessController::class);



            Route::resources([
                'roles' => RoleController::class,
                'users' => UserController::class,

                'SubscriptionTypes' => SubscriptionTypesController::class,
                'Subscribers' => SubscriptionController::class,
                'Permissions' => PermissionController::class,
                'settings' => SettingController::class,
                'Sections' => SectionController::class,
                'WalletTypes' => WalletTypeController::class,
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
                'ProjectSettings' => ProjectController::class,
                'Advertisings' => AdvertisingController::class,
                'FalLicense' => FalLicenseController::class,




            ]);
            Route::get('Subscribers.CreateBroker', [SubscriptionController::class, 'createBroker'])->name('Subscribers.CreateBroker');
            Route::post('Subscribers.CreateBroker', [SubscriptionController::class, 'storeBroker'])->name('Subscribers.CreateBroker');
            Route::post('Subscribers.SuspendSubscription/{id}', [SubscriptionController::class, 'SuspendSubscription'])->name('Subscribers.SuspendSubscription');
            Route::get('LoginByUser/{id}', 'Subscribers\SubscriptionController@LoginByUser')->name('Subscribers.LoginByUser');
            Route::get('CreateUser', 'RoleController@CreateUser')->name('roles.CreateUser');
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

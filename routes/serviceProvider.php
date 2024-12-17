<?php

use App\Http\Controllers\Admin\AdminProviderServiceController;
use App\Http\Controllers\Office\Gallary\RealEstateRequestController;
use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Home\UnitInterestController;
use App\Http\Controllers\Office\FinancialManagment\WalletController;
use App\Http\Controllers\Office\Gallary\GallaryController;
use App\Http\Controllers\ServiceProvider\HomeController;
use App\Http\Controllers\Office\ProjectManagement\Contract\ContractController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Office\ProjectManagement\PropertyController;
use App\Http\Controllers\Office\ProjectManagement\Receipt\VoucherController;
use App\Http\Controllers\Office\ProjectManagement\Renter\RenterController;
use App\Http\Controllers\Office\ProjectManagement\UnitController;
use App\Http\Controllers\ServiceProvider\SettingController;
use App\Http\Controllers\ServiceProvider\TicketController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ServiceProvider\MaintenanceOperationManagement\ProviderServiceController;
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



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'checkUserRole:service-povider']
    ],
    function () {
        Route::prefix('serviceProvider')->name('ServiceProvider.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');


       //resources
       Route::resource('ProviderService', ProviderServiceController::class);


       //Ticket
       route::resource('Tickets', TicketController::class);
       Route::post('tickets/{ticketId}/add-response', [TicketController::class, 'addResponse'])->name('tickets.addResponse');
       //




       Route::resource('Setting', SettingController::class);
       route::get('createFalLicense', [SettingController::class, 'createFalLicense'])->name('Setting.createFalLicense')->middleware('CheckSubscription');
       route::post('createFalLicense', [SettingController::class, 'storeFalLicense'])->name('Setting.createFalLicense')->middleware('CheckSubscription');
       route::get('editFalLicense/{id}', [SettingController::class, 'editFalLicense'])->name('Setting.editFalLicense')->middleware('CheckSubscription');
       route::put('updateFalLicense/{id}', [SettingController::class, 'updateFalLicense'])->name('Setting.updateFalLicense')->middleware('CheckSubscription');
       route::delete('deleteFalLicense/{id}', [SettingController::class, 'deleteFalLicense'])->name('Setting.deleteFalLicense')->middleware('CheckSubscription');
       route::put('createPassword/{id}', [SettingController::class, 'createPassword'])->name('Setting.createPassword')->middleware('CheckSubscription');



       //
            route::put('updateOffice/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            route::put('updatePassword/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');



        });





    }
);

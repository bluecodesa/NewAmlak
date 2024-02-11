<?php

use App\Http\Controllers\Admin\General\CityController;
use App\Http\Controllers\Admin\General\DistrictController;
use App\Http\Controllers\Admin\General\RegionController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'CheckSubscription']
    ],
    function () {
        Route::prefix('app')->name('Admin.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/payment-gateways/{id}/edit', [SettingController::class, 'editPaymentGatewayForm'])->name('payment-gateways.edit');
            Route::put('/payment-gateways/{id}', [SettingController::class, 'updatePaymentGatewayStatus'])->name('update-payment-gateway');
            Route::post('/payment-gateways/create', [SettingController::class, 'createPaymentGateway'])->name('create-payment-gateway');
            Route::post('/create-broker-subscribers', [SubUserController::class, 'createBrokerSubscribers'])->name('create-broker-subscribers');
            Route::get('/update-broker-subscribers/{id}', [SubUserController::class, 'editbroker'])->name('edit-broker-subscribers');
            Route::put('/update-broker-subscribers/{id}', [SubUserController::class, 'updatebroker'])->name('update-broker-subscribers');
            Route::delete('delete-broker-subscribers/{id}', [SubUserController::class, 'deletebroker'])->name('delete-broker-subscribers');


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
            ]);
            Route::get('Subscribers.CreateBroker', [SubscriptionController::class, 'createBroker'])->name('Subscribers.CreateBroker');
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
<?php

use App\Http\Controllers\Admin\General\CityController;
use App\Http\Controllers\Admin\General\RegionController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubscriptionTypesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubUserController;
use App\Http\Controllers\Admin\Users\DeveloperController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::prefix('app')->name('Admin.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/payment-gateways/{id}/edit', [SettingController::class, 'editPaymentGatewayForm'])->name('payment-gateways.edit');
            Route::put('/payment-gateways/{id}', [SettingController::class, 'updatePaymentGatewayStatus'])->name('update-payment-gateway');
            Route::post('/payment-gateways/create', [SettingController::class, 'createPaymentGateway'])->name('create-payment-gateway');
            Route::post('/broker_subscribers/create', [SubUserController::class, 'createBrokerSubscribers'])->name('create-broker-subscribers');
            Route::resources([
                'roles' => RoleController::class,
                'users' => UserController::class,
                'offices' => OfficeController::class,
                'SubscriptionTypes' => SubscriptionTypesController::class,
                'Subscribers' => SubUserController::class,
                'Permissions' => PermissionController::class,
                'settings' => SettingController::class,
                'Sections' => SectionController::class,
                'Region' => RegionController::class,
                'City' => CityController::class,
                'Developer' => DeveloperController::class,
            ]);
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

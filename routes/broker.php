<?php

use App\Http\Controllers\Broker\ProjectManagement\AdvisorController;
use App\Http\Controllers\Broker\ProjectManagement\DeveloperController;
use App\Http\Controllers\Broker\ProjectManagement\EmployeeController;
use App\Http\Controllers\Broker\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Broker\ProjectManagement\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PendingPaymentPopup;



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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'CheckSubscription','pendingPayment']
    ],
    function () {
        Route::prefix('broker')->name('Broker.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::resources([
                'Developer' => DeveloperController::class,
                'Advisor' => AdvisorController::class,
                'Owner' => OwnerController::class,
                'Employee' => EmployeeController::class,
                'Project' => ProjectController::class,
            ]);
            Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
        });
    }
);

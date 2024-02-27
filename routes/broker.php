<?php

use App\Http\Controllers\Broker\ProjectManagement\AdvisorController;
use App\Http\Controllers\Broker\ProjectManagement\DeveloperController;
use App\Http\Controllers\Broker\ProjectManagement\EmployeeController;
use App\Http\Controllers\Broker\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Broker\PaymentController;
use App\Http\Controllers\Broker\ProjectManagement\ProjectController;
use App\Http\Controllers\Broker\ProjectManagement\PropertyController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'pendingPayment']
    ],
    function () {
        Route::prefix('broker')->name('Broker.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('UpdateSubscription/{id}', 'HomeController@UpdateSubscription')->name('UpdateSubscription');
            route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
            route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
            route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
            route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
            route::resource('Payment', PaymentController::class);
            route::resource('Property', PropertyController::class);
            Route::get('/CreateUnit/{id}', 'ProjectManagement\PropertyController@CreateUnit')->name('Property.CreateUnit')->middleware('CheckSubscription');
            Route::get('autocomplete', 'ProjectManagement\PropertyController@autocomplete')->name('Property.autocomplete')->middleware('CheckSubscription');
            Route::post('StoreUnit/{id}', 'ProjectManagement\PropertyController@StoreUnit')->name('Property.StoreUnit')->middleware('CheckSubscription');
            Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty')->middleware('CheckSubscription');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty')->middleware('CheckSubscription');
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('Broker.GetCitiesByRegion')->middleware('CheckSubscription');
        });
    }
);

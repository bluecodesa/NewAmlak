<?php

use App\Http\Controllers\Employee\ProjectManagement\AdvisorController;
use App\Http\Controllers\Employee\ProjectManagement\DeveloperController;
use App\Http\Controllers\Employee\ProjectManagement\EmployeeController;
use App\Http\Controllers\Employee\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Employee\ProjectManagement\ProjectController;
use App\Http\Controllers\Employee\SettingController;
use App\Http\Controllers\Employee\HomeController;

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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'checkUserRole:employee']
    ],
    function () {
        Route::prefix('employee')->name('Employee.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
       //resources
    //    Route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
    //    Route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
    //    Route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
    //    Route::resource('Employee', EmployeeController::class)->middleware('CheckSubscription');
    //    Route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
       Route::resource('Setting', SettingController::class)->middleware('CheckSubscription');



    //    //
            route::put('updateEmployee/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            Route::put('/employee/setting/password/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');
            // Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('Office.GetCitiesByRegion');
        });
    }
);
<?php

use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Office\SettingController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'checkUserRole:office']
    ],
    function () {
        Route::prefix('office')->name('Office.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
       //resources
       Route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
       Route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
       Route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
       Route::resource('Employee', EmployeeController::class)->middleware('CheckSubscription');
       Route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
       Route::resource('Setting', SettingController::class)->middleware('CheckSubscription');



       //
            route::put('updateOffice/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            Route::put('/office/setting/password/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');
            Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('Office.GetCitiesByRegion');
        });
    }
);

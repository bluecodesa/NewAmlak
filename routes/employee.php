<?php

use App\Http\Controllers\Employee\ProjectManagement\AdvisorController;
use App\Http\Controllers\Employee\ProjectManagement\DeveloperController;
use App\Http\Controllers\Employee\ProjectManagement\EmployeeController;
use App\Http\Controllers\Employee\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Employee\ProjectManagement\ProjectController;
use App\Http\Controllers\Employee\HomeController;
use App\Http\Controllers\Employee\ProjectManagement\UnitController;
use App\Http\Controllers\Employee\SettingController;
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
            Route::get('/',[HomeController::class, 'index'])->name('home');
       //resources
    //    Route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
    //    Route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
    //    Route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
    //    Route::resource('Employee', EmployeeController::class)->middleware('CheckSubscription');
    //    Route::resource('Project', ProjectController::class)->middleware('CheckSubscription');

            //settings
            Route::resource('Setting', SettingController::class)->middleware('CheckSubscription');
            route::put('updateEmployee/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            Route::put('/employee/setting/password/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');
           //end of setings

             //Unit routes
                route::resource('Unit', UnitController::class)->middleware('CheckSubscription');
                Route::post('SaveNewOwners', [UnitController::class, 'SaveNewOwners'])->name('Unit.SaveNewOwners');
                Route::get('/UnitdeleteImage/{id}', 'ProjectManagement\UnitController@deleteImage')->name('Unit.deleteImage')->middleware('CheckSubscription');
                Route::get('/UpdateRentPriceByType/{id}', 'ProjectManagement\UnitController@UpdateRentPriceByType')->name('Unit.UpdateRentPriceByType')->middleware('CheckSubscription');
                Route::delete('/gallery/unit/{id}', [UnitController::class, 'destroyUnitGallery'])->name('gallery.unit.destroy');
            //end of Unit routes

              //projects routes
       Route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
       Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty')->middleware('CheckSubscription');
       Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty')->middleware('CheckSubscription');
       Route::get('/deleteImage/{id}', 'ProjectManagement\ProjectController@deleteImage')->name('Project.deleteImage')->middleware('CheckSubscription');
       Route::get('/CreateUnitProject/{id}', 'ProjectManagement\ProjectController@CreateUnitFromProject')->name('Project.CreateUnitProject')->middleware('CheckSubscription');
       Route::post('StoreUnitProject/{id}', 'ProjectManagement\ProjectController@StoreUnit')->name('Project.StoreUnitProject')->middleware('CheckSubscription');
       Route::get('autocompleteProject', 'ProjectManagement\ProjectController@autocomplete')->name('Project.autocompleteProject')->middleware('CheckSubscription');
       //end of projects routes

       Route::resource('Employee', EmployeeController::class)->middleware('CheckSubscription');


            // Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', [HomeController::class, 'GetCitiesByRegion'])->name('Employee.GetCitiesByRegion')->middleware('CheckSubscription');
            Route::get('GetDistrictsByCity/{id}', [HomeController::class, 'GetDistrictsByCity'])->name('Employee.GetDistrictsByCity')->middleware('CheckSubscription');
        });
    }
);

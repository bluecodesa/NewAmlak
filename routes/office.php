<?php

use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Office\HomeController;
use App\Http\Controllers\Office\ProjectManagement\Contract\ContractController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Office\ProjectManagement\PropertyController;
use App\Http\Controllers\Office\ProjectManagement\Renter\RenterController;
use App\Http\Controllers\Office\ProjectManagement\UnitController;
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
            Route::get('ViewInvoice', 'HomeController@ViewInvoice')->name('ViewInvoice');

       //resources
       Route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
       Route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
       Route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
       //contract
       Route::resource('Contract', ContractController::class)->middleware('CheckSubscription');


       //

       //renter
       Route::resource('Renter', RenterController::class)->middleware('CheckSubscription');
       Route::post('/renter-search', [RenterController::class, 'searchByIdNumber'])->name('Renter.searchByIdNumber');
       Route::post('/renter/add/{id}', [RenterController::class, 'addAsRenter'])->name('Renter.addAsRenter');
        //end renter
       Route::resource('Employee', EmployeeController::class)->middleware('CheckSubscription');
       //projects routes
       Route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
       Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty')->middleware('CheckSubscription');
       Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty')->middleware('CheckSubscription');
       Route::get('/deleteImage/{id}', 'ProjectManagement\ProjectController@deleteImage')->name('Project.deleteImage')->middleware('CheckSubscription');
       Route::get('/CreateUnitProject/{id}', 'ProjectManagement\ProjectController@CreateUnitFromProject')->name('Project.CreateUnitProject')->middleware('CheckSubscription');
       Route::post('StoreUnitProject/{id}', 'ProjectManagement\ProjectController@StoreUnit')->name('Project.StoreUnitProject')->middleware('CheckSubscription');
       Route::get('autocompleteProject', 'ProjectManagement\ProjectController@autocomplete')->name('Project.autocompleteProject')->middleware('CheckSubscription');
       //end of projects routes

        //Property routes
        route::resource('Property', PropertyController::class)->middleware('CheckSubscription');
        Route::get('/CreateUnit/{id}', 'ProjectManagement\PropertyController@CreateUnit')->name('Property.CreateUnit')->middleware('CheckSubscription');
        Route::get('autocomplete', 'ProjectManagement\PropertyController@autocomplete')->name('Property.autocomplete')->middleware('CheckSubscription');
        Route::post('StoreUnit/{id}', 'ProjectManagement\PropertyController@StoreUnit')->name('Property.StoreUnit')->middleware('CheckSubscription');
        Route::get('/PropertydeleteImage/{id}', 'ProjectManagement\PropertyController@deleteImage')->name('Property.deleteImage')->middleware('CheckSubscription');
        // //end of Property routes

        //Unit routes
        route::resource('Unit', UnitController::class)->middleware('CheckSubscription');
        Route::post('SaveNewOwners', [UnitController::class, 'SaveNewOwners'])->name('Unit.SaveNewOwners');
        Route::get('/UnitdeleteImage/{id}', 'ProjectManagement\UnitController@deleteImage')->name('Unit.deleteImage')->middleware('CheckSubscription');
        Route::get('/UpdateRentPriceByType/{id}', 'ProjectManagement\UnitController@UpdateRentPriceByType')->name('Unit.UpdateRentPriceByType')->middleware('CheckSubscription');
        Route::delete('/gallery/unit/{id}', [UnitController::class, 'destroyUnitGallery'])->name('gallery.unit.destroy');
       //end of Unit routes

       Route::resource('Setting', SettingController::class)->middleware('CheckSubscription');



       //
            route::put('updateOffice/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            Route::put('/office/setting/password/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');
            // Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            // Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', [HomeController::class, 'GetCitiesByRegion'])->name('Office.GetCitiesByRegion')->middleware('CheckSubscription');
            Route::get('GetDistrictsByCity/{id}', [HomeController::class, 'GetDistrictsByCity'])->name('Office.GetDistrictsByCity')->middleware('CheckSubscription');

        });
        Route::get('/get-project-details/{project}', [ContractController::class, 'getProjectDetails']);
        Route::get('/get-units-by-property/{property}', [ContractController::class, 'getUnitsByProperty']);

    }
);

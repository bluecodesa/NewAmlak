<?php

use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Property_Finder\HomeController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'CheckSubscription', 'pendingPayment']
    ],
    function () {
        Route::prefix('PropertyFinder')->name('PropertyFinder.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('home');
            Route::resources([
                'Developer' => DeveloperController::class,
                'Advisor' => AdvisorController::class,
                'Owner' => OwnerController::class,
                'Employee' => EmployeeController::class,
                'Project' => ProjectController::class,
            ]);
            Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('Office.GetCitiesByRegion');
        });
    }
);

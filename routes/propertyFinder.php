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
            Route::put('/update-property-finder/{finder}', [HomeController::class, 'updatePropertyFinder'])->name('updatePropertyFinder');
            Route::put('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');
            Route::post('/PropertyFinder/verify-code-finder', [HomeController::class, 'verifyCode'])->name('verify-code-finder');
            Route::post('/PropertyFinder/complete-registration-finder', [HomeController::class, 'register'])->name('complete-registration-finder');




        });

    }

);

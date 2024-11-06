<?php

use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Property_Finder\HomeController;
use App\Http\Controllers\Property_Finder\RealEstateRequestController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'pendingPayment']
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
                'RealEstateRequest' => RealEstateRequestController::class,

            ]);
            Route::put('/update-property-finder/{finder}', [HomeController::class, 'updatePropertyFinder'])->name('updatePropertyFinder')->middleware('CheckSubscription');
            Route::put('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword')->middleware('CheckSubscription');
            Route::put('/create-password/{id}', [HomeController::class, 'createPassword'])->name('createPassword')->middleware('CheckSubscription');
            Route::post('/PropertyFinder/verify-code-finder', [HomeController::class, 'verifyCode'])->name('verify-code-finder')->middleware('CheckSubscription');
            Route::post('/PropertyFinder/complete-registration-finder', [HomeController::class, 'register'])->name('complete-registration-finder')->middleware('CheckSubscription');
            Route::get('GetDistrictsByCity/{id}', 'HomeController@GetDistrictsCity')->name('GetDistrictsByCity')->middleware('CheckSubscription')->middleware('CheckSubscription');
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('GetCitiesByRegion')->middleware('CheckSubscription')->middleware('CheckSubscription');
            Route::post('/update-request-status/{id}', [RealEstateRequestController::class, 'updateStatus'])->name('updateRequestStatus')->middleware('CheckSubscription');
            Route::post('/update-interest-type/{requestId}', [RealEstateRequestController::class, 'updateInterestType'])->name('updateInterestType')->middleware('CheckSubscription');
            Route::Post('create-ticket', [HomeController::class, 'createTicket'])->name('create-ticket')->middleware('CheckSubscription');
            Route::post('tickets/{ticketId}/add-response', [HomeController::class, 'addReplay'])->name('tickets.addResponse')->middleware('CheckSubscription');






        });

    }

);
Route::get('create-unit', [HomeController::class, 'createUnit'])->name('Owner.create-unit')->middleware('CheckSubscription');
Route::Post('create-unit', [HomeController::class, 'storeUnit'])->name('Owner.store-unit')->middleware('CheckSubscription');
Route::get('edit-unit/{id}', [HomeController::class, 'editUnit'])->name('Owner.edit-unit')->middleware('CheckSubscription');
Route::put('update-unit/{id}', [HomeController::class, 'updateUnit'])->name('Owner.update-unit')->middleware('CheckSubscription');
Route::delete('delete-unit/{id}', [HomeController::class, 'deleteUnit'])->name('Owner.delete-unit')->middleware('CheckSubscription');

Route::get('create-property', [HomeController::class, 'createProperty'])->name('Owner.create-Property')->middleware('CheckSubscription');
Route::Post('create-property', [HomeController::class, 'storeProperty'])->name('Owner.store-Property')->middleware('CheckSubscription');
Route::get('edit-property/{id}', [HomeController::class, 'editProperty'])->name('Owner.edit-property')->middleware('CheckSubscription');
Route::put('update-property/{id}', [HomeController::class, 'updateProperty'])->name('Owner.update-property')->middleware('CheckSubscription');
Route::delete('delete-property/{id}', [HomeController::class, 'deleteProperty'])->name('Owner.delete-property')->middleware('CheckSubscription');


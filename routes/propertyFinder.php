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
                'RealEstateRequest' => RealEstateRequestController::class,

            ]);
            Route::put('/update-property-finder/{finder}', [HomeController::class, 'updatePropertyFinder'])->name('updatePropertyFinder');
            Route::put('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');
            Route::post('/PropertyFinder/verify-code-finder', [HomeController::class, 'verifyCode'])->name('verify-code-finder');
            Route::post('/PropertyFinder/complete-registration-finder', [HomeController::class, 'register'])->name('complete-registration-finder');
            Route::get('GetDistrictsByCity/{id}', 'HomeController@GetDistrictsCity')->name('GetDistrictsByCity')->middleware('CheckSubscription');
            Route::post('/update-request-status/{id}', [RealEstateRequestController::class, 'updateStatus'])->name('updateRequestStatus');
            Route::post('/update-interest-type/{requestId}', [RealEstateRequestController::class, 'updateInterestType'])->name('updateInterestType');
            Route::Post('create-ticket', [HomeController::class, 'createTicket'])->name('create-ticket');
            Route::post('tickets/{ticketId}/add-response', [HomeController::class, 'addReplay'])->name('tickets.addResponse');






        });

    }

);
Route::get('create-unit', [HomeController::class, 'createUnit'])->name('Owner.create-unit');
Route::Post('create-unit', [HomeController::class, 'storeUnit'])->name('Owner.store-unit');
Route::get('edit-unit/{id}', [HomeController::class, 'editUnit'])->name('Owner.edit-unit');
Route::put('update-unit/{id}', [HomeController::class, 'updateUnit'])->name('Owner.update-unit');
Route::delete('delete-unit/{id}', [HomeController::class, 'deleteUnit'])->name('Owner.delete-unit');

Route::get('create-property', [HomeController::class, 'createProperty'])->name('Owner.create-Property');
Route::Post('create-property', [HomeController::class, 'storeProperty'])->name('Owner.store-Property');
Route::get('edit-property/{id}', [HomeController::class, 'editProperty'])->name('Owner.edit-property');
Route::put('update-property/{id}', [HomeController::class, 'updateProperty'])->name('Owner.update-property');
Route::delete('delete-property/{id}', [HomeController::class, 'deleteProperty'])->name('Owner.delete-property');


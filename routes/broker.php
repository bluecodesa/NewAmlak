<?php

use App\Http\Controllers\Broker\ProjectManagement\AdvisorController;
use App\Http\Controllers\Broker\ProjectManagement\DeveloperController;
use App\Http\Controllers\Broker\ProjectManagement\EmployeeController;
use App\Http\Controllers\Broker\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Broker\Gallary\GallaryController;
use App\Http\Controllers\Broker\PaymentController;
use App\Http\Controllers\Broker\ProjectManagement\ProjectController;
use App\Http\Controllers\Broker\SettingController;
use App\Http\Controllers\Broker\ProjectManagement\PropertyController;
use App\Http\Controllers\Broker\ProjectManagement\UnitController;
use App\Http\Controllers\Broker\TicketController;
use App\Http\Controllers\Home\UnitInterestController;
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
// pendingPayment


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'checkUserRole:broker']
    ],
    function () {
        Route::prefix('broker')->name('Broker.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('UpdateSubscription/{id}', 'HomeController@UpdateSubscription')->name('UpdateSubscription');
            Route::get('ViewInvoice', 'HomeController@ViewInvoice')->name('ViewInvoice');
            Route::get('ShowSubscription', 'HomeController@showSubscription')->name('ShowSubscription')->middleware('CheckSubscription');
            Route::get('ShowInvoice/{id}', 'HomeController@ShowInvoice')->name('ShowInvoice');
            //
            route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
            route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
            route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
            //
            route::resource('Project', ProjectController::class)->middleware('CheckSubscription');
            Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty')->middleware('CheckSubscription');
            Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty')->middleware('CheckSubscription');
            Route::get('/deleteImage/{id}', 'ProjectManagement\ProjectController@deleteImage')->name('Project.deleteImage')->middleware('CheckSubscription');
            route::resource('Payment', PaymentController::class);
            //
            route::resource('Setting', SettingController::class)->middleware('CheckSubscription');
            route::put('updateBroker/{id}', [SettingController::class, 'updateBroker'])->name('Setting.updateBroker')->middleware('CheckSubscription');
            //
            route::resource('Property', PropertyController::class)->middleware('CheckSubscription');
            Route::get('/CreateUnit/{id}', 'ProjectManagement\PropertyController@CreateUnit')->name('Property.CreateUnit')->middleware('CheckSubscription');
            Route::get('autocomplete', 'ProjectManagement\PropertyController@autocomplete')->name('Property.autocomplete')->middleware('CheckSubscription');
            Route::post('StoreUnit/{id}', 'ProjectManagement\PropertyController@StoreUnit')->name('Property.StoreUnit')->middleware('CheckSubscription');
            Route::get('/PropertydeleteImage/{id}', 'ProjectManagement\PropertyController@deleteImage')->name('Property.deleteImage')->middleware('CheckSubscription');
            //
            route::resource('Unit', UnitController::class)->middleware('CheckSubscription');
            Route::post('SaveNewOwners', [UnitController::class, 'SaveNewOwners'])->name('Unit.SaveNewOwners');
            Route::get('/UnitdeleteImage/{id}', 'ProjectManagement\UnitController@deleteImage')->name('Unit.deleteImage')->middleware('CheckSubscription');
            Route::get('/UpdateRentPriceByType/{id}', 'ProjectManagement\UnitController@UpdateRentPriceByType')->name('Unit.UpdateRentPriceByType')->middleware('CheckSubscription');
            Route::delete('/gallery/unit/{id}', [UnitController::class, 'destroyUnitGallery'])->name('gallery.unit.destroy');
            //
            route::resource('Tickets', TicketController::class);
            Route::post('tickets/{ticketId}/add-response', [TicketController::class, 'addResponse'])->name('tickets.addResponse');
            //
            route::resource('Gallery', GallaryController::class)->middleware('CheckSubscription');
            Route::post('/update-cover', [GallaryController::class, 'updateCover'])->name('Gallery.update-cover');
            Route::post('/gallery/create', [GallaryController::class, 'createGallery'])->name('Gallery.create');
            Route::post('/gallery/custom-update/{gallery}', [GallaryController::class, 'customUpdate'])->name('Gallery.customUpdate')->middleware('CheckSubscription');
            Route::get('Gallery/{gallery_name}/unit/{id}', [GallaryController::class, 'showGalleryUnit'])->name('Gallary.showUnit')->middleware('CheckSubscription');
            Route::get('Gallery/GetDistrictByCity/{id}', [GallaryController::class, 'GetDistrictByCity'])->name('Gallary.GetDistrictByCity')->middleware('CheckSubscription');
            //
            Route::post('/Interest/status/{id}', [UnitInterestController::class, 'update'])->name('Interest.status.update')->middleware('CheckSubscription');
            Route::get('Interests', [UnitInterestController::class, 'index'])->name('Gallary.showInterests')->middleware('CheckSubscription');

            //
            Route::get('GetCitiesByRegion/{id}', 'HomeController@GetCitiesByRegion')->name('Broker.GetCitiesByRegion')->middleware('CheckSubscription');
            Route::get('GetDistrictsByCity/{id}', 'HomeController@GetDistrictsByCity')->name('Broker.GetDistrictsByCity')->middleware('CheckSubscription');
        });
    }
);

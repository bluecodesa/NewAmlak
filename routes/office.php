<?php

use App\Http\Controllers\Office\Gallary\RealEstateRequestController;
use App\Http\Controllers\Office\ProjectManagement\AdvisorController;
use App\Http\Controllers\Office\ProjectManagement\DeveloperController;
use App\Http\Controllers\Office\ProjectManagement\EmployeeController;
use App\Http\Controllers\Office\ProjectManagement\OwnerController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Home\UnitInterestController;
use App\Http\Controllers\Office\FinancialManagment\WalletController;
use App\Http\Controllers\Office\Gallary\GallaryController;
use App\Http\Controllers\Office\HomeController;
use App\Http\Controllers\Office\ProjectManagement\Contract\ContractController;
use App\Http\Controllers\Office\ProjectManagement\ProjectController;
use App\Http\Controllers\Office\ProjectManagement\PropertyController;
use App\Http\Controllers\Office\ProjectManagement\Receipt\VoucherController;
use App\Http\Controllers\Office\ProjectManagement\Renter\RenterController;
use App\Http\Controllers\Office\ProjectManagement\UnitController;
use App\Http\Controllers\Office\SettingController;
use App\Http\Controllers\Office\TicketController;
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
            Route::get('ShowSubscription', 'HomeController@showSubscription')->name('ShowSubscription')->middleware('CheckSubscription');
            Route::get('ShowInvoice/{id}', 'HomeController@ShowInvoice')->name('ShowInvoice');

       //resources
       Route::resource('Developer', DeveloperController::class)->middleware('CheckSubscription');
       Route::resource('Advisor', AdvisorController::class)->middleware('CheckSubscription');
       Route::resource('Wallet', WalletController::class)->middleware('CheckSubscription');
       route::resource('RealEstateRequest', RealEstateRequestController::class)->middleware('CheckSubscription');
       Route::post('/update-interest-type/{requestId}', [RealEstateRequestController::class, 'updateInterestType'])->name('updateInterestType');


       //owner

       Route::resource('Owner', OwnerController::class)->middleware('CheckSubscription');
       Route::post('/owner-search', [OwnerController::class, 'searchByIdNumber'])->name('Owner.searchByIdNumber');
       Route::post('/owner/add/{id}', [OwnerController::class, 'addAsOwner'])->name('Owner.addAsOwner');


       //contract
       Route::resource('Contract', ContractController::class)->middleware('CheckSubscription');

       //Ticket
       route::resource('Tickets', TicketController::class);
       Route::post('tickets/{ticketId}/add-response', [TicketController::class, 'addResponse'])->name('tickets.addResponse');
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
        Route::get('/IndexByStatus/{id}', [UnitController::class, 'IndexByStatus'])->name('Unit.IndexByStatus')->middleware('CheckSubscription');
        Route::get('/IndexByUsage/{id}', [UnitController::class, 'IndexByUsage'])->name('Unit.IndexByUsage')->middleware('CheckSubscription');
       //end of Unit routes

       Route::resource('Receipt', VoucherController::class)->middleware('CheckSubscription');
        // Route::post('/Receipt', [ReceiptController::class, 'store'])->name('Receipt.store');
        Route::get('receipt/download/{id}', [VoucherController::class, 'download'])->name('Receipt.download');
        Route::post('create-payment-voucher', [VoucherController::class, 'creatPaymentVoucher'])->name('create-payment-voucher')->middleware('CheckSubscription');


       Route::resource('Setting', SettingController::class)->middleware('CheckSubscription');
       route::get('createFalLicense', [SettingController::class, 'createFalLicense'])->name('Setting.createFalLicense')->middleware('CheckSubscription');
       route::post('createFalLicense', [SettingController::class, 'storeFalLicense'])->name('Setting.createFalLicense')->middleware('CheckSubscription');
       route::get('editFalLicense/{id}', [SettingController::class, 'editFalLicense'])->name('Setting.editFalLicense')->middleware('CheckSubscription');
       route::put('updateFalLicense/{id}', [SettingController::class, 'updateFalLicense'])->name('Setting.updateFalLicense')->middleware('CheckSubscription');
       route::delete('deleteFalLicense/{id}', [SettingController::class, 'deleteFalLicense'])->name('Setting.deleteFalLicense')->middleware('CheckSubscription');
       route::put('createPassword/{id}', [SettingController::class, 'createPassword'])->name('Setting.createPassword')->middleware('CheckSubscription');



       //
            route::put('updateOffice/{id}', [SettingController::class, 'updateProfileSetting'])->name('Setting.updateProfileSetting')->middleware('CheckSubscription');
            route::put('updatePassword/{id}', [SettingController::class, 'updatePassword'])->name('Setting.updatePassword')->middleware('CheckSubscription');
            // Route::get('/CreateProperty/{id}', 'ProjectManagement\ProjectController@CreateProperty')->name('Project.CreateProperty');
            // Route::post('/StoreProperty/{id}', 'ProjectManagement\ProjectController@StoreProperty')->name('Project.StoreProperty');
            Route::get('GetCitiesByRegion/{id}', [HomeController::class, 'GetCitiesByRegion'])->name('Office.GetCitiesByRegion')->middleware('CheckSubscription');
            Route::get('GetDistrictsByCity/{id}', [HomeController::class, 'GetDistrictsByCity'])->name('Office.GetDistrictsByCity')->middleware('CheckSubscription');

            Route::get('GetPropertiesByProject/{projectId}', [UnitController::class, 'getPropertiesByProject'])->name('GetPropertiesByProject');
            Route::get('property/details/{id}', [UnitController::class, 'getPropertyDetail'])->name('GetPropertyDetail');
            Route::get('GetProjectDetails/{projectId}', [UnitController::class, 'getProjectDetails'])->name('GetProjectDetails');
            Route::get('GetPropertyDetails/{propertyId}', [UnitController::class, 'getPropertyDetails'])->name('GetPropertyDetails');

               //
               route::resource('Gallery', GallaryController::class)->middleware('CheckSubscription');
               Route::post('/update-cover', [GallaryController::class, 'updateCover'])->name('Gallery.update-cover');
               Route::post('/gallery/create', [GallaryController::class, 'createGallery'])->name('Gallery.create');
               Route::post('/gallery/custom-update/{gallery}', [GallaryController::class, 'customUpdate'])->name('Gallery.customUpdate')->middleware('CheckSubscription');
               Route::get('Gallery/{gallery_name}/unit/{id}', [GallaryController::class, 'showGalleryUnit'])->name('Gallary.showUnit')->middleware('CheckSubscription');
               Route::get('Gallery/GetDistrictByCity/{id}', [GallaryController::class, 'GetDistrictByCity'])->name('Gallary.GetDistrictByCity')->middleware('CheckSubscription');
               Route::get('InteractiveMap', [GallaryController::class, 'showInteractiveMap'])->name('Gallery.InteractiveMap')->middleware('CheckSubscription');



               //
               Route::get('Interests', [UnitInterestController::class, 'index'])->name('Gallary.showInterests')->middleware('CheckSubscription');


        });
        Route::get('/get-project-details/{project}', [ContractController::class, 'getProjectDetails']);
        Route::get('/get-units-by-property/{property}', [ContractController::class, 'getUnitsByProperty']);
        Route::post('/contracts/{contract}/certify', [ContractController::class, 'certify'])->name('contracts.certify');
        Route::post('/contracts/{contract}/deportation', [ContractController::class, 'deportation'])->name('contracts.deportation');
        Route::delete('/contracts/{contract}', [ContractController::class, 'reset'])->name('contracts.reset');
        Route::post('/contracts/update-validity', [ContractController::class, 'updateValidity'])->name('contracts.updateValidity');
        Route::get('/get-unit-details/{unitId}', [ContractController::class, 'getUnitDetails']);
        Route::get('/get-all-properties-and-units', [ContractController::class, 'getAllPropertiesAndUnits']);
        Route::get('/get-all-units', [ContractController::class, 'getAllUnits']);
        Route::get('/units/{id}/status', [ContractController::class, 'getStatus']);




    }
);

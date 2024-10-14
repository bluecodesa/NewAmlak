<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Broker\Gallary\GallaryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionTypesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Broker\ProjectManagement\ProjectController;
use App\Http\Controllers\Broker\ProjectManagement\PropertyController;
use App\Http\Controllers\Home\Gallary\GallaryController as HomeGallaryController;
use App\Http\Controllers\Property_Finder\RealEstateRequestController;
use App\Http\Controllers\Home\UnitInterestController;
use App\Http\Controllers\Property_Finder\HomeController as Property_FinderHomeController;
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

Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('key:generate');
    // $exitCode = Artisan::call('route:cache');
    // $exitCode = Artisan::call('optimize');
    return '<h1>Cache facade value cleared</h1>';
});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
    ],
    function () {
        Route::prefix('app')->name('Home.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/nafath/callback', [HomeController::class, 'handleCallback'])->name('nafath.callback');
            Route::get('create-office', [HomeController::class, 'createOffice'])->name('Offices.CreateOffice');
            Route::get('create-broker', [HomeController::class, 'createBroker'])->name('Brokers.CreateBroker');
            Route::get('create-new-broker', [HomeController::class, 'createNewBroker'])->name('Broker.CreateNewBroker');
            Route::get('create-new-office', [HomeController::class, 'createNewOffice'])->name('Offices.CreateNewOffice');
            Route::get('create-prperty-finder', [HomeController::class, 'createPropertyFinder'])->name('PropertyFinders.CreatePropertyFinder');
            Route::get('create-new-property-finder', [HomeController::class, 'createNewPropertyFinder'])->name('PropertyFinder.CreateNewPropertyFinder');

            Route::post('create-office', [HomeController::class, 'storeOffice'])->name('Offices.CreateOffice');
            Route::post('create-broker', [HomeController::class, 'storeBroker'])->name('Brokers.CreateBroker');
            Route::post('create-new-broker', [HomeController::class, 'storeNewBroker'])->name('Brokers.CreateNewBroker');
            Route::post('create-new-office', [HomeController::class, 'storeNewOffice'])->name('Offices.CreateNewOffice');
            Route::post('create-prperty-finder', [HomeController::class, 'storePropertyFinder'])->name('PropertyFinders.CreatePropertyFinder');
            Route::post('create-new-porperty-finder', [HomeController::class, 'storeNewPropertyFinder'])->name('PropertyFinders.CreateNewPropertyFinder');

            Route::post('send-report', [HomeController::class, 'sendAdReport'])->name('Tickets.send-report');
            Route::post('/add-owner-profile', [HomeController::class, 'addOwnerProfile'])->name('add-owner-profile');

            Route::get('/region/{id}',  [HomeController::class, 'showRegion'])->name('Region.show');
              //projects
            Route::get('gallery/projects', [ProjectController::class, 'showAllProjetcs'])->name('showAllProjects');
            Route::get('gallery/{gallery_name}/project/{id}', [ProjectController::class, 'showPubllicProject'])->name('showPublicProject');
            Route::get('gallery/{gallery_name}/property/{id}', [PropertyController::class, 'showPubllicProperty'])->name('showPublicProperty');
            route::resource('Real-Estate-Requests', RealEstateRequestController::class)->middleware('CheckSubscription');
            Route::post('/store-request', [HomeController::class, 'createRequest'])->name('createRequest');
            Route::post('send-otp', [HomeController::class, 'sendOtp'])->name('sendOtp');
            Route::get('verifyLogin', [HomeController::class, 'verifyLogin'])->name('auth.verifyLogin');
            Route::post('verifyLogin', [HomeController::class, 'verifyLogin'])->name('auth.verifyLogin');
            Route::get('chooseAccount', [HomeController::class, 'chooseAccount'])->name('auth.chooseAccount');
            Route::get('Login', [HomeController::class, 'loginByPassword'])->name('auth.loginByPassword');
            Route::get('createAccount', [HomeController::class, 'createAccount'])->name('createAccount');
            Route::post('createAccount', [HomeController::class, 'register'])->name('storeAccount');
            Route::post('addAccount', [HomeController::class, 'addAccount'])->name('addAccount');



        //
        });

        //fav
        Route::post('/add-to-favorites', [UnitInterestController::class, 'addToFav'])->name('add-to-favorites');
        Route::post('/reomve-from-favorites', [UnitInterestController::class, 'removeFromFav'])->name('remove-from-favorites');
        //
        Route::get('/pending', [SubscriptionController::class, 'viewPending'])->name('pending');
        Route::resource('Notification', 'General\NotificationController');
        Route::get('/', 'Home\HomeController@index')->name('welcome');
        Route::get('/Privacy', 'Home\HomeController@Privacy')->name('Privacy');
        Route::get('/Terms&Conditions', 'Home\HomeController@Terms')->name('Terms');
        Auth::routes();

        Route::get('/gallery/{name}', [GallaryController::class, 'showByName'])->name('gallery.showByName');
        // Route::get('/gallery', [GallaryController::class, 'showAllGalleries'])->name('gallery.showAllGalleries');
        Route::get('/gallery', [HomeGallaryController::class, 'showAllGalleries'])->name('gallery.showAllGalleries');

        Route::get('gallery/{gallery_name}/unit/{id}', [HomeGallaryController::class, 'showUnitPublic'])->name('gallery.showUnitPublic');
        Route::post('/unit_interests',  [UnitInterestController::class, 'store'])->name('unit_interests.store');
        Route::get('/download-qrcode/{link}', [GallaryController::class, 'downloadQRCode'])->name('download.qrcode');
        Route::get('/filtered-units', [GallaryController::class, 'fetchFilteredUnits'])->name('filtered.units');

        //rest password
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
        Route::post('send-code', [ForgotPasswordController::class, 'submitCodeForm'])->name('reset.password.code');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
        Route::post('forget-password/send-new-code', [ForgotPasswordController::class, 'sendNewCode'])->name('forget.password.newcode');

        Route::get('/brokers',  [HomeController::class, 'showAllBrokers'])->name('brokers');
        Route::get('Gallery/GetDistrictByCity/{id}', [GallaryController::class, 'GetDistrictByCity'])->name('Gallary.GetDistrictByCity');

        Route::post('StoreContactUs',  [HomeController::class, 'StoreContactUs'])->name('home.StoreContactUs');


        // Route::get('/loadMoreBrokers', 'HomeController@loadMoreBrokers')->name('loadMoreBrokers');

        // Route::get('/filter/brokers',  [HomeController::class, 'filterBrokers'])->name('filter.brokers');

        //create property finder

        // Route for sending OTP
        Route::post('/send-otp', [Property_FinderHomeController::class, 'sendOtp'])->name('send-otp');

        // Route for verifying OTP
        Route::post('/verify-otp', [Property_FinderHomeController::class, 'verifyOtp'])->name('verify-otp');

        // Route for resending OTP
        Route::post('/resend-otp', [Property_FinderHomeController::class, 'resendOtp'])->name('resend-otp');

        // Route for registering property finder
        Route::post('/register-property-finder', [Property_FinderHomeController::class, 'registerPropertyFinder'])->name('register-property-finder');

        Route::get('GetDistrictsByCity/{id}', 'HomeController@GetDistrictsByCity')->name('GetDistrictsByCity');

        Route::get('/get-city-data/{cityId}', [AdminHomeController::class, 'getCityData']);

        Route::get('GetCitiesRegion/{id}',[Property_FinderHomeController::class, 'GetCitiesRegion'])->name('Owner.GetCitiesRegion');
        Route::get('GetDistrictsCity/{id}',[Property_FinderHomeController::class, 'GetDistrictsCity'])->name('Owner.GetDistrictsCity');


    }

);


Route::post('/fcm-token', 'Home\HomeController@UpdateToken')->name('fcmToken');
Route::post('/send-notification', [HomeController::class, 'notification'])->name('notification');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::resource('Payment', 'PaymentController');

        Route::post('callback_payments_package/{user}', 'PaymentController@Payment_callBack')->name('callback_payments_package');
        Route::get('callback_payments_package/{user}', 'PaymentController@Payment_callBack')->name('callback_payments_package');
        //
        Route::post('callback_payments_packageUpgarde/{id}', 'PaymentController@Payment_callBackUpgarde')->name('callback_payments_package_upgrade');
        Route::get('callback_payments_packageUpgarde/{id}', 'PaymentController@Payment_callBackUpgarde')->name('callback_payments_package_upgrade');
        //
        Route::post('UpgradeSubscription', 'PaymentController@UpgradeSubscription')->name('UpgradeSubscription');

        Route::get('callback_UpgradeSubscription/{id}', 'PaymentController@callback_UpgradeSubscription')->name('callback_UpgradeSubscription');
        Route::post('callback_UpgradeSubscription/{id}', 'PaymentController@callback_UpgradeSubscription')->name('callback_UpgradeSubscription');
        Route::get('/switch-role/{role}', [AdminHomeController::class, 'switchRole'])->name('switch.role');

    }

);

use App\Http\Controllers\IdValidationController;

Route::get('/id-validation', [IdValidationController::class, 'showForm'])->name('id-validation');
Route::post('/validate-id', [IdValidationController::class, 'validateId'])->name('validate-id');



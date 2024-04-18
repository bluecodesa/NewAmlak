<?php

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
use App\Http\Controllers\Home\UnitInterestController;
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
            Route::get('create-office', [HomeController::class, 'createOffice'])->name('Offices.CreateOffice');
            Route::get('create-broker', [HomeController::class, 'createBroker'])->name('Brokers.CreateBroker');
            Route::post('create-office', [HomeController::class, 'storeOffice'])->name('Offices.CreateOffice');
            Route::post('create-broker', [HomeController::class, 'storeBroker'])->name('Brokers.CreateBroker');
            Route::get('/region/{id}',  [HomeController::class, 'showRegion'])->name('Region.show');
        });
        Route::get('/pending', [SubscriptionController::class, 'viewPending'])->name('pending');
        Route::resource('Notification', 'General\NotificationController');
        Route::get('/', 'Home\HomeController@index')->name('welcome');
        Auth::routes();
        Route::get('/gallery/{name}', [GallaryController::class, 'showByName'])->name('gallery.showByName');
        Route::get('gallery/{gallery_name}/{id}', [GallaryController::class, 'showUnitPublic'])->name('gallery.showUnitPublic');
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
    }

);
// NotificationController
// Route::get('reset', [ForgotPasswordController::class, 'showresetform']);

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
    }

);

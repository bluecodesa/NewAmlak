<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\Admin\Subscribers\SubscriptionController;
use App\Http\Controllers\SubscriptionTypesController;
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
        Auth::routes();
        Route::get('/', 'Home\HomeController@index')->name('welcome');
        Route::prefix('app')->name('Home.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('create-office', [HomeController::class, 'createOffice'])->name('Offices.CreateOffice');
            Route::get('create-broker', [HomeController::class, 'createBroker'])->name('Brokers.CreateBroker');
            Route::post('create-office', [HomeController::class, 'storeOffice'])->name('Offices.CreateOffice');
            Route::post('create-broker', [HomeController::class, 'storeBroker'])->name('Brokers.CreateBroker');
            Route::get('/region/{id}',  [HomeController::class, 'showRegion'])->name('Region.show');
        });
        Route::get('/pending', [SubscriptionController::class, 'viewPending'])->name('pending');
    }


);

Route::post('/fcm-token', 'Home\HomeController@UpdateToken')->name('fcmToken');
Route::post('/send-notification', [HomeController::class, 'notification'])->name('notification');
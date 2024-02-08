<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionTypesController;

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

Route::get('/', function () {
    return view('Home.home');
})->name('welcome');


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
    ],
    function () {
        Auth::routes();
        Route::prefix('app')->name('Home.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('create-office', [HomeController::class, 'createOffice'])->name('Offices.CreateOffice');
            Route::get('create-broker', [HomeController::class, 'createBroker'])->name('Brokers.CreateBroker');
        });
    }
);

<?php

use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubscriptionTypesController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::prefix('app')->name('Admin.')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::resources([
                'roles' => RoleController::class,
                'users' => UserController::class,
                'offices' => OfficeController::class,
                'SubscriptionTypes' => SubscriptionTypesController::class,
                'Permissions' => PermissionController::class,
            ]);
        });
    }
);


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Auth::routes();
    }
);

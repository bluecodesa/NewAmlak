<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    // 'products' => ProductController::class,
]);
// routes/web.php



Route::get('/offices/create', [OfficeController::class, 'create'])->name('offices.create');
Route::post('/offices/store', [OfficeController::class, 'store'])->name('offices.store');

//subscription
Route::get('subscriptionTypes', [SubscriptionTypesController::class, 'index'])->name('SubscriptionTypes.index');
Route::get('/subscriptionTypes/create', [SubscriptionTypesController::class, 'create'])->name('SubscriptionTypes.create');
Route::post('SubscriptionTypes/create', [SubscriptionTypesController::class, 'store'])->name('SubscriptionTypes.store');
Route::get('SubscriptionTypes/edit/{id}', [SubscriptionTypesController::class, 'edit'])->name('SubscriptionTypes.edit');


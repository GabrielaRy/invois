<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::middleware(['auth'])->group(function () {
	Route::prefix('/api')->group(function () {

		Route::post('/ares/{ico}', [App\Http\Controllers\AresController::class, 'fetchData']);
		Route::post('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'retrieveCustomer']);

	});
});

Route::middleware(['auth'])->group(function () {
	Route::prefix('/app')->group(function () {

		Route::view('/dashboard', 'app.dashboard')->name('app.dashboard');

		Route::resource('/invoice', App\Http\Controllers\InvoiceController::class);
		Route::resource('/customers', App\Http\Controllers\CustomerController::class);

		Route::get('user', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
		Route::patch('user', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');


		Route::get('invoicesettings', [App\Http\Controllers\InvoiceSettingsController::class, 'edit'])->name('app.invoiceSettings.edit');
		Route::patch('invoicesettings', [App\Http\Controllers\InvoiceSettingsController::class, 'update'])->name('app.invoiceSettings.update');

	});
});

Route::middleware(['auth', 'can:admin'])->group(function () {
	Route::prefix('/admin')->group(function () {

		Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

	});
});

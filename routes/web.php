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
	Route::prefix('/app')->group(function () {

	Route::resource('/customers', CustomerController::class)->except(['edit', 'update']);
	Route::get('/customer/{id}/edit', 'CustomerController@edit')->name('customers.edit');
	Route::put('/customer/{id}', 'CustomerController@update');

		Route::get('/dashboard', function () {
			return view('app.dashboard');
		})->name('app.dashboard');

	});
});

Route::middleware(['auth', 'can:admin'])->group(function () {
	Route::prefix('/admin')->group(function () {

		Route::get('/dashboard', function () {
			return view('admin.dashboard');
		})->name('admin.dashboard');

	});
});



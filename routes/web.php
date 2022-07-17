<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembersController;

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

Route::get('/', [MembersController::class, 'index'])->name('list_users');

Route::get('/user/add', [MembersController::class, 'create'])->name('create_users');

Route::post('/user/save', [MembersController::class, 'store'])->name('save_user_details');

Route::get('/user/details/{id}', [MembersController::class, 'show'])->name('view_user_details');

Route::post('/user/get_system_currency_conversion', [MembersController::class, 'get_system_currency_conversion'])->name('get_system_currency_conversion');

Route::post('/user/get_external_currency_conversion', [MembersController::class, 'get_external_currency_conversion'])->name('get_external_currency_conversion');
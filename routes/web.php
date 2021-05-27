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

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', 'FrontController@index')->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('getData', 'FrontController@getData')->name('dashboard.getData');

Route::middleware(['auth:sanctum', 'verified'])->post('deleteData', 'FrontController@deleteData')->name('dashboard.deleteData');

Route::middleware(['auth:sanctum', 'verified'])->get('notification', 'FrontController@notification')->name('notification');

Route::middleware(['auth:sanctum', 'verified'])->post('save-token', [App\Http\Controllers\FrontController::class, 'saveToken'])->name('save-token');

Route::middleware(['auth:sanctum', 'verified'])->post('send-notification', [App\Http\Controllers\FrontController::class, 'sendNotification'])->name('send.notification');

Route::middleware(['auth:sanctum', 'verified'])->get('feeds', 'FrontController@feeds')->name('feeds');

Route::middleware(['auth:sanctum', 'verified'])->get('imap', 'FrontController@imap')->name('imap');

Route::middleware(['auth:sanctum', 'verified'])->get('pert_mail', 'FrontController@pert_mail')->name('pert_mail');

<?php

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

use Illuminate\Http\Resources\Json\Resource;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

Route::get('password/reset')->name('password.request')->uses('Auth\ForgotPasswordController@showLinkRequestForm')->middleware('guest');
Route::post('password/email')->name('password.email')->uses('Auth\ForgotPasswordController@sendResetLinkEmail')->middleware('guest');
Route::get('password/reset/{token}')->name('password.reset')->uses('Auth\ResetPasswordController@showResetForm')->middleware('guest');
Route::post('password/reset')->name('password.update')->uses('Auth\ResetPasswordController@reset')->middleware('guest');

Route::middleware(['auth'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('students', 'StudentController')->only(['index', 'show', 'create', 'store', 'edit', 'update']);
});

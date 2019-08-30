<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
	Route::get('/', function () {
		return view('welcome');
	});

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/profile', 'ProfileController@show')->name('profile');

	Route::middleware(['role:admin'])->group(function () {
		Route::resource('users', 'UserController')->name('index', 'users')->except('show');
		Route::resource('keys', 'SoftwareKeyController')->except('index');
	});

	Route::resource('keys', 'SoftwareKeyController')->only('index')->name('index', 'keys');
});

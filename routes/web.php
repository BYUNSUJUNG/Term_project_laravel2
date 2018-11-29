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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('bbs', 'BoardsController');

/* 사용자 가입 */
Route::get('auth/register', 
	['as' => 'users.create', 
	 'uses' => 'UsersController@create']);

Route::post('auth/register', 
	['as' => 'users.store', 
	 'uses' => 'UsersController@store']);


/* 사용자 인증 */
Route::get('auth/login', 
	['as' => 'sessions.create', 
	 'uses' => 'LoginController@create']);

Route::post('auth/login', 
	['as' => 'sessions.store', 
	 'uses' => 'LoginController@store']);

Route::get('auth/logout', 
	['as' => 'sessions.destroy', 
	 'uses' => 'LoginController@destroy']);

/* 비밀번호 초기화 */
Route::get('auth/remind', 
	['as' => 'remind.create', 
	 'uses' => 'PasswordsController@getRemind']);

Route::post('auth/remind', 
	['as' => 'remind.store', 
	 'uses' => 'PasswordsController@postRemind']);

Route::get('auth/reset/{token}', 
	['as' => 'reset.create', 
	 'uses' => 'PasswordsController@getReset']);

Route::post('auth/reset', 
	['as' => 'reset.store', 
	 'uses' => 'PasswordsController@postReset']);


Route::get('login/google','LoginController@redirectToProvider')->name('google.login');
Route::get('login/google/callback', 'LoginController@handleProviderCallback');
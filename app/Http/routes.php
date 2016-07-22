<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/**
 *  Route group with user/ prefixed path.
 */

Route::group(['prefix' => 'user'], function (){

	/**
	 *  Route group for authenticated users/
	 */
	Route::group(['middleware' => 'auth'], function(){

		Route::get('/logout', [
			'uses' => 'UserController@getLogout',
			'as' => 'user.logout'
		]);

	});

	/**
	 *  Route group for guest users.
	 */
	Route::group(['middleware' => 'guest'], function (){

		Route::get('/login', [
			'uses' => 'UserController@getLogin',
			'as' => 'user.login'
		]);

		Route::post('/login', [
			'uses' => 'UserController@postLogin',
			'as' => 'user.login'
		]);

		Route::get('/register', [
			'uses' => 'UserController@getRegister',
			'as' => 'user.register'
		]);

		Route::post('/register', [
			'uses' => 'UserController@postRegister',
			'as' => 'user.register'
		]);

		Route::get('/verify/{confirmation_code}', [
			'uses' => 'UserController@getVerify',
			'as' => 'user.verify'
		]);
	});

});

/**
 *  Products routes group.
 */
Route::group(['prefix' => 'store'], function (){

	Route::get('/products', function (){
		return view('store.products');
	})->name('store.products');

});

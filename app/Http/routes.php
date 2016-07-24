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
 *  Store routes group.
 */
Route::group(['prefix' => 'store'], function (){

	Route::get('', function (){
		return view('store.products');
	})->name('store.products');

	Route::get('/{category_name}', [
		'uses' => 'CategoryController@getCategoryPage',
		'as' => 'category.products'
	]);

	Route::get('/product/{product_name}', [
		'uses' => 'ProductsController@getSingleProduct',
		'as' => 'single.product'
	]);

});

Route::get('/category_image/{filename}', [
	'uses' => 'CategoryController@getCategoryImage',
	'as' => 'category.image'
]);


Route::get('/search', [
	'uses' => 'ProductsController@getSearch',
	'as' => 'store.search'
]);

Route::post('/search', [
	'uses' => 'ProductsController@postSearch',
	'as' => 'store.search'
]);

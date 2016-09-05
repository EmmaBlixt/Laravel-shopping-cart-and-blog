<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

Route::group(['middleware' => 'web'], function() {

	Route::get('/', [
	'uses' => 'ProductController@get_index',
	'as' => 'index'
	]);

	Route::get('/shopping-cart', [
	'uses' => 'ProductController@get_cart',
	'as' => 'shopping-cart'
	]);

	Route::get('/checkout', [
	'uses' => 'ProductController@get_checkout',
	'as' => 'checkout'
	]);

	Route::get('/clear-cart', [
	'uses' => 'ProductController@clear_cart',
	'as' => 'clear-cart'
	]);

});// end of middleware web group
/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
|
| Deals with products and the shopping cart
|
*/

		Route::group(['prefix' => 'products'], function() {

			Route::get('/add-to-cart/{id}', [
				'uses' => 'ProductController@add_to_cart',
				'as' => 'add-to-cart'
			]);

			Route::get('/remove-from-cart/{id}', [
				'uses' => 'ProductController@remove_from_cart',
				'as' => 'remove-from-cart'
			]);

			Route::post('/add-new-product', [
			'uses' => 'ProductController@add_new_product',
			'as' => 'add-new-product'
			]);

			Route::get('/edit-product/{id}', [
			'uses' => 'ProductController@get_edit_product',
			'as' => 'edit-product'
			]);

			Route::post('/edit-product', [
			'uses' => 'ProductController@post_edit_product',
			'as' => 'post-edit-product' 
			]);

	 	}); // end of product prefix group
	 	
		/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Deals with signing up, signing in/out and user profile
|
*/

	Route::group(['prefix' => 'user'], function() {
			
			Route::get('/signup', [
			'uses' => 'UserController@get_signup',
			'as' => 'signup'
			]);

			Route::post('/signup', [
			'uses' => 'UserController@post_signup',
			'as' => 'post_signup'
			]);


			Route::get('/signin', [
			'uses' => 'UserController@get_signin',
			'as' => 'signin'
			]);

			Route::post('/signin', [
			'uses' => 'UserController@post_signin',
			'as' => 'post_signin'
			]);

		}); // end of user prefix group


/*
|--------------------------------------------------------------------------
| Post Routes
|--------------------------------------------------------------------------
|
| Deals with posts on the blog
|
*/

			Route::get('/delete-post/{id}', [
				'uses' => 'PostController@delete_post',
				'as' => 'delete-post'
			]);

			Route::post('/edit-post', [
				'uses' => 'PostController@edit_post',
				'as' => 'edit-post'
				]);

			Route::post('/like', [
				'uses' => 'PostController@like_post',
				'as' => 'like'
				]);

	

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Authenticated routes that requires users to be logged in
|
*/

	Route::group(['middleware' => 'auth'], function(){
			
			Route::get('/profile', [
			'uses' => 'UserController@get_profile',
			'as' => 'profile'
			]);

			Route::get('/logout', [
			'uses' => 'UserController@get_logout',
			'as' => 'logout'
			]);

			Route::get('/edit-profile', [
			'uses' => 'UserController@edit_profile',
			'as' => 'edit-profile'
			]);

			Route::post('/update-profile', [
			'uses' => 'UserController@update_profile',
			'as' => 'update-profile' 
			]);

			Route::get('/insert-product', [
			'uses' => 'ProductController@get_insert_product',
			'as' => 'insert-product'
			]);

			Route::get('/delete-product/{id}', [
			'uses' => 'ProductController@delete_product',
			'as' => 'delete-product'
			]);

			Route::get('/dashboard', [
			'uses' => 'PostController@get_dashboard',
			'as' => 'dashboard'
			]);

			Route::post('/new-post', [
			'uses' => 'PostController@new_post',
			'as' => 'new-post'
			]);

			});// end of middleware auth group

			Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
    		return "this page requires that you be logged in and an Admin";
			}]);
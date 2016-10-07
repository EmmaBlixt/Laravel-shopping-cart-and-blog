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

	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
			

			Route::get('/profile/{username}/{id}', [
			'uses' => 'UserController@get_profile',
			'as' => 'profile'
			]);


			Route::get('/add-friend/{username}/{id}', [
			'uses' => 'FriendController@add_friend',
			'as' => 'add-friend'
			]);


			Route::get('/accept-friend/{id}', [
			'uses' => 'FriendController@accept_friend',
			'as' => 'accept-friend'
			]);


			Route::get('/friends/{username}/{id}', [
			'uses' => 'FriendController@get_friends_list',
			'as' => 'friends'
			]);


			Route::post('/remove-friend/{id}', [
			'uses' => 'FriendController@post_remove_friend',
			'as' => 'remove-friend'
			]);

			Route::get('/decline-request/{id}', [
			'uses' => 'FriendController@post_decline_request',
			'as' => 'decline-request'
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

		Route::group(['middleware' => 'auth'], function(){

			Route::post('/new-post', [
			'uses' => 'PostController@new_post',
			'as' => 'new-post'
			]);


			Route::post('/reply', [
			'uses' => 'PostController@post_reply',
			'as' => 'reply'
			]);

			Route::get('/delete-post/{id}', [
				'uses' => 'PostController@delete_post',
				'as' => 'delete-post'
			]);

			Route::get('/delete-post/{id}/{post_parent_id}', [
				'uses' => 'PostController@delete_reply',
				'as' => 'delete-reply'
			]);


			Route::post('/edit-post', [
				'uses' => 'PostController@edit_post',
				'as' => 'edit-post'
				]);


			Route::post('/like', [
				'uses' => 'PostController@like_post',
				'as' => 'like'
				]);


			Route::get('/dashboard', [
			'uses' => 'PostController@get_dashboard',
			'as' => 'dashboard'
			]);

		});// end of middleware web group
	
/*
|--------------------------------------------------------------------------
| Search Routes
|--------------------------------------------------------------------------
|
| Search for registered users
|
*/

	Route::post('/search', [
	'uses' => 'UserController@get_results',
	'as' => 'post_search'
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


			});// end of middleware auth group

			Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
    		return "this page requires that you be logged in and an Admin";
			}]);

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Cush API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register cush API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('queries/{key}', 'Api\Auth\RegisterController@queries');

Route::post('register/{key}', 'Api\Auth\RegisterController@register');

Route::post('register_all/{key}', 'Api\Auth\RegisterController@register_all');

Route::post('login/{key}', 'Api\Auth\LoginController@login');

Route::post('refresh/{key}', 'Api\Auth\LoginController@refresh');

Route::post('forget/{key}', 'Api\Auth\ForgetPasswordController@forget');
Route::post('reset/{key}', 'Api\Auth\ResetPasswordController@reset');

Route::get('types/{key}', 'Api\ItemTypeController@types');

Route::get('type_items/{key}/{id}', 'Api\ItemTypeController@type_items');

Route::get('item/{key}/{id}', 'Api\ItemController@item');

Route::get('related_items/{key}/{id}', 'Api\ItemController@related_items');

Route::get('home/{key}', 'Api\ItemController@home');

Route::get('search/{key}', 'Api\SearchController@search');

Route::middleware('auth:api')->group(function () {
    Route::get('authhome/{key}', 'Api\ItemController@home');
    Route::post('logout/{key}', 'Api\Auth\LoginController@logout');
    Route::get('profile/{key}', 'Api\UserController@profile');
    Route::get('peoples/{key}', 'Api\UserController@peoples');
    Route::get('vendors/{key}', 'Api\UserController@vendors');
    Route::get('mycustomers/{key}', 'Api\UserController@mycustomers');
    Route::get('customers/{key}', 'Api\UserController@customers');
    Route::get('user_items/{key}/{id}', 'Api\ItemController@user_items');
    Route::get('only_user_items/{key}/{id}', 'Api\ItemController@only_user_items');
    Route::get('wishlist/{key}', 'Api\UserController@wishlist');
    Route::post('setWishlist/{key}', 'Api\UserController@setWishlist');
    Route::post('complete_registration/{key}', 'Api\Auth\RegisterController@complete_registration');
    Route::get('authitem/{key}/{id}', 'Api\ItemController@item');

    Route::get('item_types/{key}', 'Api\ItemController@item_types');
    Route::post('post/{key}', 'Api\ItemController@post');
    Route::post('setVendor/{key}', 'Api\UserController@setVendor');
    Route::post('removeVendor/{key}', 'Api\UserController@removeVendor');
    Route::get('my_items/{key}', 'Api\ItemController@my_items');
    Route::post('update_item/{key}', 'Api\ItemController@update_item');
    Route::post('change_status/{key}', 'Api\ItemController@change_status');
    Route::post('add_image/{key}', 'Api\ItemController@add_image');
    Route::post('remove_image/{key}', 'Api\ItemController@remove_image');

    Route::post('update_name/{key}', 'Api\UserController@update_name');
    Route::post('update_phone/{key}', 'Api\UserController@update_phone');
    Route::post('update_email/{key}', 'Api\UserController@update_email');
    Route::post('update_region/{key}', 'Api\UserController@update_region');
    Route::post('update_city/{key}', 'Api\UserController@update_city');
    Route::post('update_address1/{key}', 'Api\UserController@update_address1');
    Route::post('update_address2/{key}', 'Api\UserController@update_address2');
    Route::post('update_profile/{key}', 'Api\UserController@update_profile');

    Route::post('change_password/{key}', 'Api\UserController@change_password');

    Route::post('review/{key}', 'Api\ItemController@review');

    Route::get('search_user/{key}', 'Api\SearchController@search_user');
});

Route::any('/'.env('TELEGRAM_TOKEN'), 'Api\TelegramController@index')->name('webhook');
Route::post('/bot/getUpdates', function(){
	$updates  = Telegram::getUpdatesubmits();
	return json_encode($updates);
});

Route::post('bot/sendmessage', function() {
    Telegram::sendMessage([
        'chat_id' => '3562000145',
        'text' => 'Hello there!'
    ]);
    return;
});
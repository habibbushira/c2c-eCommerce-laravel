<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register cush web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('locale/{locale}', function($locale = null){
	Session::put('locale', $locale);
	return redirect()->back();
})->name('locale');

Route::get('/', 'IndexController@index');

Auth::routes();

Route::match(['get', 'post'], '/register2', 'Auth\Register2Controller@register2')->name('register2')->middleware('roles:Customer');

//Cush Peoples 
Route::match(['get','post'], '/post', 'ItemController@post')->name('item.post')->middleware('roles:Customer');
Route::match(['get','post'], '/manage_item/{id}', 'ItemController@manage_item')->middleware('roles:Customer');
Route::post('/item/image/remove', 'ItemController@image_remove')->middleware('roles:Customer');
Route::post('/item/image/upload', 'ItemController@image_upload')->name('image.upload')->middleware('roles:Customer');

Route::post('/item/review', 'ItemController@review')->name('item.review')->middleware('roles:Customer');

Route::post('/item/status', 'ItemController@status')->middleware('roles:Customer');

//Cush Category Listing pages
Route::get('/items', 'ItemController@items')->name('items')->middleware('roles:Customer');
Route::get('/typeItems/{id}', 'ItemController@typeItems')->name('type.items')->middleware('roles:Customer');

// Cush Search
Route::get('/search', 'IndexController@search')->name('search');
Route::get('/search_peoples', 'IndexController@search_peoples')->name('search_peoples');

// Cush Customer
Route::match(['get', 'post'], '/vendors', 'CustomerController@vendor')->name('vendor')->middleware('roles:Customer');
Route::get('/vendor/remove/{user_id}', 'CustomerController@vendor_remove')->middleware('roles:Customer');
Route::get('/customer', 'CustomerController@view_user_customers')->middleware('roles:Customer');

Route::get('/recent_items', 'IndexController@recentlyUploaded')->name('recent_items');
Route::get('/top_solds', 'IndexController@topSolds')->name('top_solds');

Route::get('/item/{url}', 'IndexController@item')->name('item.url');

//Cush Wishlist
Route::get('/wishlist/add/{id}', 'WishlistController@add')->name('wishlist.add')->middleware('roles:Customer');
Route::get('/wishlists/view', 'WishlistController@view')->name('wishlists.view')->middleware('roles:Customer');

Route::get('/wishlists/remove/{id}', 'WishlistController@remove')->name('wishlists.remove')->middleware('roles:Customer');

//Cush Profile or Settings
Route::match(['get','post'], '/settings/user_profile', 'SettingController@user_profile')->middleware('roles:Customer');
Route::match(['get','post'], '/settings/account', 'SettingController@account')->middleware('roles:Customer');

Route::get('/webhook', 'Api\TelegramController@webhook');
Route::get('/updated-activity', 'Api\TelegramController@updatedActivity');

//Cush Display shop detail from IndexController

Route::get('/itemTypes', 'IndexController@itemTypes')->name('item.types');
Route::get('/itemTypes/items/{id}', 'IndexController@typeItems')->name('typeItems');

Route::get('/peoples', 'CustomerController@peoples')->name('peoples');
Route::get('/person/items/{id}', 'CustomerController@person_items')->name('person.items');

//Cush Comparision using cart

Route::match(['get','post'],'/compare', 'IndexController@comparision')->name('compare');

Route::get('/compare/remove/{rowId}', 'IndexController@remove_comparision');

Route::get('/privacy_policy', 'IndexController@privacy');

Route::get('empty_compare', function(){
	Cart::instance('comparision')->destroy();
	return redirect('/');
});
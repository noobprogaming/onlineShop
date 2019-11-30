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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('find','HomeController@find')->name('find');

Route::get('profile/{id}', 'ProfileController@index')->name('profile');
Route::get('profileUpdate/{id}', 'ProfileController@profileUpdate')->name('profileUpdate');
Route::post('setProfileUpdate/{id}', 'ProfileController@setProfileUpdate')->name('setProfileUpdate');

Route::get('itemDetail/{item_id}', 'DetailItemController@itemDetail')->name('itemDetail');
Route::get('cartCount', 'CartController@cartCount')->name('cartCount');
Route::get('cartList', 'CartController@cartList')->name('cartList');
Route::post('storeCart','CartController@storeCart')->name('storeCart');
Route::get('deleteCart/{item_id}','CartController@deleteCart')->name('deleteCart');

Route::get('pay','PayController@pay')->name('pay');
Route::get('payCartList', 'PayController@payCartList')->name('payCartList');
Route::post('payStore', 'PayController@payStore')->name('payStore');

Route::get('payConfirm', 'PayController@payConfirm')->name('payConfirm');

Route::get('createItem','ItemController@createItem')->name('createItem');
Route::get('updateItem/{item_id}','ItemController@updateItem')->name('updateItem');
Route::get('deleteItem/{id}/{item_id}','ItemController@deleteItem')->name('deleteItem');
Route::post('setUpdateItem','ItemController@setUpdateItem')->name('setUpdateItem');
Route::post('setCreateItem','ItemController@setCreateItem')->name('setCreateItem');

Route::get('checkCity?prov_id=1','OngkirController@checkCity')->name('checkCity');
Route::post('checkOngkir','OngkirController@checkOngkir')->name('checkOngkir');

Route::get('getprovinceId', 'OngkirController@getprovinceId')->name('getprovinceId');
Route::get('getcityId', 'OngkirController@getcityId')->name('getcityId');

Route::get('getprovince', 'OngkirController@getprovince')->name('getprovince');
Route::get('getcity', 'OngkirController@getcity')->name('getcity');
Route::get('checkshipping', 'OngkirController@checkshipping')->name('checkshipping');

Route::get('getProvinceLocal', 'AddressController@getProvince')->name('getprovinceLocal');
Route::get('getCityLocal', 'AddressController@getCity')->name('getcityLocal');
Route::get('getPostalLocal', 'AddressController@getPostal')->name('getPostalLocal');
Route::get('getUrbanLocal', 'AddressController@getUrban')->name('getUrbanLocal');
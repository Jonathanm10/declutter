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

Route::get('/', 'AdController@index')->name('ads');
Route::prefix('ads')->group(function () {
    Route::get('create', 'AdController@create')->name('ads_create');
    Route::post('store', 'AdController@store')->name('ads_store');
    Route::get('{id}', 'AdController@edit')->name('ads_edit');
    Route::patch('{id}/edit', 'AdController@update')->name('ads_update');
    Route::get('{id}/delete', 'AdController@delete')->name('ads_delete');
});
Route::prefix('platforms')->group(function () {
    Route::get('/', 'PlatformController@index')->name('platforms');
    Route::get('{id}', 'PlatformController@edit')->name('platforms_edit');
    Route::get('{id}/remove-configuration', 'PlatformController@removeConfiguration')->name('platforms_remove_config');
    Route::patch('{id}/edit', 'PlatformController@update')->name('platforms_update');
});

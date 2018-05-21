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
    return redirect()->route('ads.list');
});

Route::group(['prefix' => 'ads', 'as' => 'ads.'], function () {
    Route::get('/', 'AdController@index')->name('list');
    Route::get('create', 'AdController@create')->name('create');
    Route::post('store', 'AdController@store')->name('store');
    Route::get('{ad}', 'AdController@edit')->name('edit');
    Route::patch('{ad}/update', 'AdController@update')->name('update');
    Route::get('{ad}/delete', 'AdController@delete')->name('delete');
    Route::get('{ad}/toggle-publish/{platform}', 'AdController@togglePublish')->name('toggle_publish');
});

Route::group(['prefix' => 'platforms', 'as' => 'platforms.'], function () {
    Route::get('/', 'PlatformController@index')->name('list');
    Route::get('{platform}', 'PlatformController@edit')->name('edit');
    Route::patch('{platform}/update', 'PlatformController@update')->name('update');
    Route::get('{platform}/remove-configuration', 'PlatformController@removeConfiguration')->name('remove_config');
});

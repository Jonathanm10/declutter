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
    Route::get('{id}', 'AdController@edit')->name('edit');
    Route::patch('{id}/edit', 'AdController@update')->name('update');
    Route::get('{id}/delete', 'AdController@delete')->name('delete');
    Route::get('{id}/toggle-publish/{platform_id}', 'AdController@togglePublish')->name('toggle_publish');
});

Route::group(['prefix' => 'platforms', 'as' => 'platforms.'], function () {
    Route::get('/', 'PlatformController@index')->name('list');
    Route::get('{id}', 'PlatformController@edit')->name('edit');
    Route::patch('{id}/edit', 'PlatformController@update')->name('update');
    Route::get('{id}/remove-configuration', 'PlatformController@removeConfiguration')->name('remove_config');
});

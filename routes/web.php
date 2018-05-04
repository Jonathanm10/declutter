<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/ads/create', 'AdController@create')->name('ads_create');
Route::post('/ads/store', 'AdController@store')->name('ads_store');
Route::get('/ads/{id}', 'AdController@edit')->name('ads_edit');
Route::get('/ads/{id}/delete', 'AdController@delete')->name('ads_delete');
Route::patch('/ads/{id}/edit', 'AdController@update')->name('ads_update');

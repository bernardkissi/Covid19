<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/data', 'DataSource\DataController@fetch')->name('fetch.data');

Route::get('/getRegionalData', 'DataSource\APIController@getRegionalData')->name('fetch.getRegionalData');
Route::get('/getSummary', 'DataSource\APIController@getSummary')->name('fetch.getSummary');
Route::get('/getDailyUpdates', 'DataSource\APIController@getDailyUpdates')->name('fetch.getDailyUpdates');
Route::get('/getWeeklyUpdates', 'DataSource\APIController@getWeeklyUpdates')->name('fetch.getWeeklyUpdates');
Route::get('/deceasedFromDayOne', 'DataSource\APIController@deceasedFromDayOne')->name('fetch.deceasedFromDayOne');
Route::get('/recoveredFromDayOne', 'DataSource\APIController@recoveredFromDayOne')->name('fetch.recoveredFromDayOne');
Route::get('/confirmedFromDayOne', 'DataSource\APIController@confirmedFromDayOne')->name('fetch.confirmedFromDayOne');
Route::get('/world', 'DataSource\APIController@world')->name('fetch.world');
Route::get('/regions/total', 'DataSource\APIController@getRegionalTotals')->name('fetch.getRegionalTotals');


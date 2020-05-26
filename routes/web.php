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


Route::get('/', function() {
	return 'This is covid data server';
});
// Route::get('/stats', 'DataSource\APIController@getStats')->name('regions.get.stats');
// Route::get('/getstats', 'DataSource\APIController@getStats')->name('regions.get.stats');

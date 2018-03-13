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

Route::get('/', 'GameController@game')->name('home');

Route::get('/status', 'GameController@status')->name('status');

Route::get('/phase-final', 'GameController@phaseFinal')->name('phase-final');

Route::post('/verify', 'GameController@verify')->name('verify');

Route::post('/login', 'GameController@login')->name('login');

route::get('/solveall', 'GameController@solveAll');

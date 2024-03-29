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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::view('dashboard', 'dashboard')->name('dashboard');
Route::view('team', 'team')->name('team');
Route::view('icinga', 'icinga.essential')->name('icinga');
Route::view('tripphones', 'tripphones')->name('tripphones');

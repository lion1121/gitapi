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
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/dashboard', 'DashboardController@index');
Route::get('/user/dashboard/repo/{id}', 'DashboardController@showRepo');
//Route::post();

Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('gitauth');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/ajax/getUserRepos', 'DashboardController@getUserRepos');
Route::post('/ajax/likeRepo', 'DashboardController@likeRepo');
Route::post('/ajax/diselikeRepo', 'DashboardController@diselikeRepo');
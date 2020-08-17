<?php

// composer dump-autoload
// php artisan config:cache
// php artisan config:clear
Route::resource('countries', 'CountriesController');
Route::delete('countries/destroy/all', 'CountriesController@multi_delete');

Route::resource('departments', 'DepartmentsController');

Route::get('logout', 'AdminAuth@logout');

Route::get('/dashboard', function () {
    return view('admin.home');
});

Route::get('settings', 'Settings@setting');
Route::post('settings', 'Settings@setting_save');

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// });
Route::resource('/', 'Admin\SearchController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::resource('/addcode', 'Admin\CodeController');
	Route::resource('/tags', 'Admin\TagController');
	Route::resource('/search', 'Admin\SearchController');
	Route::get('/delete/{id}', 'Admin\SearchController@delete');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


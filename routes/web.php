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


Auth::routes();

// Route::get('/home', 'HomeController@dashboard')->name('home');

Route::get('/', 'UserController@spaces_index')->name('spaces.index');


Route::get('/profile', 'UserController@profile')->name('user.profile');

Route::post('/profile/save', 'UserController@profile_save')->name('profile.save');

Route::post('profile/change_password', 'UserController@change_password')->name('profile.change_password');

Route::post('profile/delete', 'UserController@profile_delete')->name('profile.delete');

//static pages

Route::get('/static-page', 'UserController@pages')->name('static-pages');


//bookings


Route::get('bookings_index', 'UserController@bookings_index')->name('bookings.index');

Route::post('bookings/save', 'UserController@bookings_save')->name('bookings.save');

Route::get('bookings/view', 'UserController@bookings_view')->name('bookings.view');

Route::get('bookings/checkin', 'UserController@bookings_checkin')->name('bookings.checkin');

Route::get('bookings/checkout', 'UserController@bookings_checkout')->name('bookings.checkout');

Route::get('bookings/payment', 'UserController@bookings_payment')->name('bookings.payment');

Route::get('bookings/status', 'UserController@bookings_status')->name('bookings.status');

Route::post('bookings/review', 'UserController@bookings_review')->name('bookings.review');


//spaces

Route::get('spaces_index', 'UserController@spaces_index')->name('spaces.index');

Route::get('spaces/view', 'UserController@spaces_view')->name('spaces.view');



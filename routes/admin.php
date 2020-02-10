<?php

 
Route::group(['middleware' => 'web'], function() {

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function() {

        Route::get('/clear-cache', function() {

            $exitCode = Artisan::call('config:cache');

            return back();

        })->name('clear-cache');

        Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('login');

        Route::post('login', 'Auth\AdminLoginController@login')->name('login');

        Route::post('logout', 'Auth\AdminLoginController@logout')->name('logout');

        Route::get('/', 'AdminController@dashboard')->name('dashboard');

        //Account management
        Route::get('profile', 'AdminController@profile')->name('profile');

        Route::post('profile_save', 'AdminController@profile_save')->name('profile_save');

        Route::post('change_password', 'AdminController@change_password')->name('change_password');

         //users CRUD routes

        Route::get('users_index', 'AdminController@users_index')->name('users_index');

        Route::get('users_create', 'AdminController@users_create')->name('users_create');

        Route::get('users_edit', 'AdminController@users_edit')->name('users_edit');    

        Route::post('users_save', 'AdminController@users_save')->name('users_save');

        Route::get('users_view', 'AdminController@users_view')->name('users_view');

        Route::get('users_delete', 'AdminController@users_delete')->name('users_delete');

        Route::get('users_status', 'AdminController@users_status')->name('users_status');

        Route::get('users_review','AdminController@users_review')->name('users_review');

        //provider CRUD routes

        Route::get('providers_index', 'AdminController@providers_index')->name('providers_index');

        Route::get('providers_create', 'AdminController@providers_create')->name('providers_create');

        Route::get('providers_edit', 'AdminController@providers_edit')->name('providers_edit');

        Route::post('providers_save', 'AdminController@providers_save')->name('providers_save');

        Route::get('providers_view', 'AdminController@providers_view')->name('providers_view');

        Route::get('providers_delete', 'AdminController@providers_delete')->name('providers_delete');

        Route::get('providers_status', 'AdminController@providers_status')->name('providers_status');

        Route::get('providers_review','AdminController@providers_review')->name('providers_review');

        
        // Static page CRUD routes

        Route::get('static_pages' , 'AdminController@static_pages_index')->name('static_pages_index');

        Route::get('static_pages_create', 'AdminController@static_pages_create')->name('static_pages_create');

        Route::get('static_pages_edit', 'AdminController@static_pages_edit')->name('static_pages_edit');

        Route::post('static_pages_save', 'AdminController@static_pages_save')->name('static_pages_save');

        Route::get('static_pages_delete', 'AdminController@static_pages_delete')->name('static_pages_delete');

        Route::get('static_pages_view', 'AdminController@static_pages_view')->name('static_pages_view');

        Route::get('static_pages_status', 'AdminController@static_pages_status_change')->name('static_pages_status');


        //spaces CRUD routes

        Route::get('spaces_index', 'AdminController@spaces_index')->name('spaces_index');

        Route::get('spaces_create', 'AdminController@spaces_create')->name('spaces_create');

        Route::get('spaces_edit', 'AdminController@spaces_edit')->name('spaces_edit');    

        Route::post('spaces_save', 'AdminController@spaces_save')->name('spaces_save');

        Route::get('spaces_view', 'AdminController@spaces_view')->name('spaces_view');

        Route::get('spaces_delete', 'AdminController@spaces_delete')->name('spaces_delete');

        Route::get('spaces_status', 'AdminController@spaces_status')->name('spaces_status');

        //Booking Management routes

        Route::get('bookings_index','AdminController@bookings_index')->name('bookings_index');

        Route::get('bookings_view','AdminController@bookings_view')->name('bookings_view');
        Route::get('bookings_payment','AdminController@bookings_payments')->name('bookings_payment');

        Route::get('bookings_payment_view','AdminController@bookings_payments_view')->name('bookings_payments_view');
        //Setting Management
        Route::get('settings' , 'AdminController@settings')->name('settings');
    
        Route::post('settings' , 'AdminController@settings_save')->name('settings_save');

        Route::post('common-settings_save' , 'AdminController@common_settings_save')->name('common-settings_save');

    });

});

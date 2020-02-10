<?php

 
Route::group(['middleware' => 'web'], function() {

    Route::group(['as' => 'provider.', 'prefix' => 'provider'], function() {

        Route::get('/clear-cache', function() {

            $exitCode = Artisan::call('config:cache');

            return back();

        })->name('clear-cache');

        Route::get('/register', 'Auth\ProviderRegisterController@showRegisterForm')->name('register');

        Route::post('/register', 'Auth\ProviderRegisterController@register')->name('register');

        Route::get('/login', 'Auth\ProviderLoginController@showLoginForm')->name('login');

        Route::post('/login', 'Auth\ProviderLoginController@login')->name('login.post');

        Route::get('/logout', 'Auth\ProviderLoginController@logout')->name('logout');

        //password reset

        Route::post('/password/email','Auth\ProviderForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('/password/reset','Auth\ProviderForgotPasswordController@showLinkRequestForm')->name('password.request');

        Route::post('/password/reset','Auth\ProviderResetPasswordController@reset');

        Route::get('/password/reset/{token}','Auth\ProviderResetPasswordController@showResetForm')->name('password.reset');

        //profile

        Route::get('/dashboard', 'ProviderController@index')->name('index');

        Route::get('/profile', 'ProviderController@profile')->name('profile');

        Route::post('/profile/save', 'ProviderController@profile_save')->name('profile.save');

        Route::post('/change_password', 'ProviderController@change_password')->name('change_password');

        Route::post('/profile/delete', 'ProviderController@profile_delete')->name('profile.delete');

        //static pages

        Route::get('/static-page', 'ProviderController@pages')->name('static-pages');


        //spaces

        Route::get('/spaces/create', 'ProviderController@spaces_create')->name('spaces.create');

        Route::get('/spaces_index' , 'ProviderController@spaces_index')->name('spaces.index');

        Route::get('/spaces/edit' , 'ProviderController@spaces_edit')->name('spaces.edit');

        Route::post('/spaces/save' , 'ProviderController@spaces_save')->name('spaces.save');

        Route::get('/spaces/view' , 'ProviderController@spaces_view')->name('spaces.view');

        Route::get('/spaces/status' , 'ProviderController@spaces_status')->name('spaces.status');

        Route::get('/spaces/delete' , 'ProviderController@spaces_delete')->name('spaces.delete');

        //bookings


        Route::get('/bookings_index' , 'ProviderController@bookings_index')->name('bookings.index');

        Route::get('/bookings/view' , 'ProviderController@bookings_view')->name('bookings.view');

        Route::get('/bookings/status' , 'ProviderController@bookings_status')->name('bookings.status');

        Route::post('/bookings/review', 'ProviderController@bookings_review')->name('bookings.review');








    });

});

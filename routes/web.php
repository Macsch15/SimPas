<?php
Route::get('/', function () {
    return view('pastebin.index');
});

Route::get('show/{unique_id}', 'PastebinController@show')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware('can_see')
    ->name('pastebin.show');

Route::delete('show/{unique_id}', 'PastebinController@delete')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware(['auth', 'author'])
    ->name('pastebin.delete');

Route::match(['put', 'patch'], 'show/{unique_id}', 'PastebinController@update')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware(['auth', 'author'])
    ->name('pastebin.update');

Route::get('show/{unique_id}/edit', 'PastebinController@edit')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware(['auth', 'author'])
    ->name('pastebin.edit');

Route::post('store', 'PastebinController@store')
    ->name('pastebin.store');

Route::get('entities', 'PastebinController@entities')
    ->middleware('auth')
    ->name('pastebin.entities');

Route::get('login', 'Auth\LoginController@showLoginForm')
    ->name('auth.login.form');

Route::post('login', 'Auth\LoginController@login')
    ->name('auth.login');

Route::post('logout', 'Auth\LoginController@logout')
    ->name('auth.logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')
    ->name('auth.register.form');

Route::post('register', 'Auth\RegisterController@register')
    ->name('auth.register');

Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')
    ->name('auth.password_reset.form');

Route::post('password/email', 'Auth\ResetPasswordController@sendResetLinkEmail')
    ->name('auth.password_reset.email');

Route::post('password/reset', 'Auth\ResetPasswordController@reset')
    ->name('auth.password_reset.password');

Route::get('terms-of-service', 'Auth\RegisterController@termsOfSerivce')
    ->name('auth.tos');

Route::get('activity', 'PastebinController@activity')
    ->name('pastebin.activity');

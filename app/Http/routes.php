<?php
Route::get('/', function () {
    return view('pastebin.index');
});

Route::get('{unique_id}', 'PastebinController@show')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware('can_see')
    ->name('pastebin.show');

Route::delete('{unique_id}', 'PastebinController@delete')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware(['auth', 'author'])
    ->name('pastebin.delete');

Route::match(['put', 'patch'], '{unique_id}', 'PastebinController@update')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->middleware(['auth', 'author'])
    ->name('pastebin.update');

Route::get('{unique_id}/edit', 'PastebinController@edit')
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

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirect')
    ->name('auth.social');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@callback')
    ->name('auth.social.callback');

Route::get('login', 'Auth\AuthController@showLoginForm')
    ->name('auth.login.form');

Route::post('login', 'Auth\AuthController@login')
    ->name('auth.login');

Route::post('logout', 'Auth\AuthController@logout')
    ->name('auth.logout');

Route::get('register', 'Auth\AuthController@showRegistrationForm')
    ->name('auth.register.form');

Route::post('register', 'Auth\AuthController@register')
    ->name('auth.register');

Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')
    ->name('auth.password_reset.form');

Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')
    ->name('auth.password_reset.email');

Route::post('password/reset', 'Auth\PasswordController@reset')
    ->name('auth.password_reset.password');

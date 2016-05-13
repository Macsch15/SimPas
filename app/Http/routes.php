<?php
Route::get('/', function () {
    return view('pastebin.index');
});

Route::get('show/{unique_id}', 'PastebinController@show')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->name('pastebin.show');

Route::delete('show/{unique_id}', 'PastebinController@delete')
    ->where([
        'unique_id' => '[A-Za-z0-9]+'
    ])
    ->name('pastebin.delete');

Route::post('store', 'PastebinController@store')
    ->name('pastebin.store');

Route::get('entities', 'PastebinController@entities')
    ->name('pastebin.entities');

Route::auth();

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirect')
    ->name('auth.social');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@callback')
    ->name('auth.social.callback');

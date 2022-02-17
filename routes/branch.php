<?php
Route::group([
    'domain' => env('BRANCH_SUB', 'branch') . '.' . env('DOMAIN_NAME', 'mobex.az'),
    'namespace' => 'Branch',
], function () {

    App::setLocale('en');

    Route::group(['middleware' => ['auth:manager', 'panel']], function () {

        Route::get('/', [
            'as' => 'branch.dashboard',
            'uses' => 'MainController@index',
        ]);

        Route::get('/logout', [
            'as' => 'branch.logout',
            'uses' => 'MainController@logout',
        ]);
    });

    require 'auth.php';
});
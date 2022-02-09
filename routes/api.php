<?php

Route::group([
    'domain'     => env('API_SUB') . '.' . env('DOMAIN_NAME'),
    'namespace'  => 'Front',
    'middleware' => ['throttle:40'],
], function () {
    Route::match(['get', 'post'], 'payment/paymes/return', [
        'uses' => 'Payment\PaymesController@request',
    ]);
});

Route::group([
    'domain'     => env('API_SUB') . '.' . env('DOMAIN_NAME'),
    'namespace'  => 'Api',
    'middleware' => ['throttle:40'],
    'prefix'     => 'v1',
], function () {

    Route::get('/', function () {
        return "Ping works";
    });

    Route::get('track/{code}', [
        'uses' => 'ExtraController@track',
    ]);

    Route::post('user/device_update', [
        'uses' => 'ExtraController@updateDevice',
    ]);

    Route::get('user/search', [
        'uses' => 'ExtraController@user',
    ]);

    Route::group([
        'prefix' => '{provider}',
    ], function () {
        Route::get('/', [
            'uses' => 'ProviderController@handler',
        ]);

        Route::get('check', [
            'uses' => 'ProviderController@check',
        ]);

        Route::get('pay', [
            'uses' => 'ProviderController@pay',
        ]);

        Route::get('status', [
            'uses' => 'ProviderController@status',
        ]);

        Route::get('recon', [
            'uses' => 'ProviderController@recon',
        ]);
    });


    Route::group([
        'middleware' => ['w_api'],
    ], function () {
        Route::get('user', [
            'uses' => 'ExtraController@user',
        ]);

        Route::post('package/add', [
            'uses' => 'ExtraController@add',
        ]);

        Route::post('package/send', [
            'uses' => 'ExtraController@send',
        ]);
    });

    Route::group([
        'prefix'     => 'referral',
    ], function () {

        Route::any('ping', [
            'uses' => 'ReferralController@index',
        ]);

        Route::any('bonus', [
            'uses' => 'ReferralController@bonus',
        ]);
    });

    Route::group([
        'prefix'     => 'trendyol',
    ], function () {

        Route::any('ping', [
            'uses' => 'TrendyolCodesController@index',
        ]);

        Route::any('save', [
            'uses' => 'TrendyolCodesController@save',
        ]);
    });

});
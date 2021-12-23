<?php

Route::group([
    'namespace' => 'Front',
], function () {

    $prefix = in_array(Request::segment(1), config('translatable.locales')) ? Request::segment(1) : null;

    Route::group(['middleware' => ['language',  'web', 'compress'], 'prefix' => $prefix], function () { // 'compress',

        Route::match(['get', 'post'], '/', [
            'as' => 'home',
            'uses' => 'MainController@index',
        ]);

        Route::get('home', [
            'uses' => 'UserController@addresses'
        ])->middleware('auth');

        Route::get('filials', [
            'as'   => 'filials',
            'uses' => 'UserController@filials',
        ]);

        Route::get('news', [
            'as' => 'news',
            'uses' => 'MainController@news',
        ]);

        Route::get('news/{slug}', [
            'as' => 'news.show',
            'uses' => 'MainController@single',
        ]);

        Route::get('p/{slug}', [
            'as' => 'pages.show',
            'uses' => 'MainController@page',
        ]);

        Route::get('stores', [
            'as' => 'shop',
            'uses' => 'ShopController@stores',
        ]);

        Route::get('faq', [
            'as' => 'faq',
            'uses' => 'MainController@faq',
        ]);

        Route::match(['get', 'post'], 'contact', [
            'as' => 'contact',
            'uses' => 'MainController@contact',
        ]);

        require_once 'user.php';
//
//        /* Auth */
        require 'auth.php';
        Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@register']);


        Route::get('register/verify', 'Auth\RegisterController@verify')->name('verifyEmailLink');
        Route::get('register/verify/resend', 'Auth\RegisterController@showResendVerificationEmailForm')->name('showResendVerificationEmailForm');
        Route::post('register/verify/resend', 'Auth\RegisterController@resendVerificationEmail')->name('resendVerificationEmail');


        Route::get('number/verify', 'Auth\VerifySmsController@showResendVerificationSmsForm')->name('showResendVerificationSmsForm');
        Route::post('number/verify/resend', 'Auth\VerifySmsController@sendVerificationSms')->name('sendVerificationSms');
        Route::get('number/verify/code', 'Auth\VerifySmsController@getCode')->name('getCode');
        Route::post('number/verify/check', 'Auth\VerifySmsController@verify')->name('checkCode');
        Route::post('verifyafteremail', 'Auth\VerifySmsController@verifyAfterEmail')->name('verifyAfterEmail');
    });

    Route::match(['get', 'post'], 'portmanat/callback', [
        'as' => 'paytr.callback',
        'uses' => 'Payment\PortmanatController@callback'
    ]);

    Route::match(['get', 'post'], 'paytr_997hdyysb/success', [
        'as' => 'paytr.success',
        'uses' => 'Payment\PayTrController@success'
    ]);

    Route::match(['get', 'post'], 'paymes_hdyysb/request', [
        'as' => 'paymess.request',
        'uses' => 'PaymesController@request'
    ]);

    Route::get('calc_price', [
        'as' => 'calc_price',
        'uses' => 'MainController@calcPrice',
    ]);

    Route::get('show_districts', [
        'as' => 'show_districts',
        'uses' => 'MainController@showDistricts',
    ]);

    Route::get('invoice/{id}.pdf', [
        'as' => 'custom_invoice',
        'uses' => 'MainController@PDFInvoice'
    ]);
});

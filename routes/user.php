<?php
Route::group(['middleware' => ['auth', 'email_verified'], 'prefix' => 'user'], function () {

    Route::get('/', [
        'uses' => 'UserController@panel',
    ]);

    Route::get('address', [
        'as'   => 'addresses',
        'uses' => 'UserController@addresses',
    ]);

    Route::get('panel', [
        'as'   => 'panel',
        'uses' => 'UserController@addresses',
    ]);

    Route::match(['get', 'post'], 'courier', [
        'as'   => 'my-courier',
        'uses' => 'UserController@courier',
    ]);

    Route::match(['get'], 'couriers', [
        'as'   => 'my-couriers',
        'uses' => 'UserController@couriers',
    ]);

    Route::get('couriers/delete/{id}', [
        'as'   => 'couriers.delete',
        'uses' => 'UserController@courierDelete',
    ]);

    Route::get('cashback', [
        'as'   => 'my-cashback',
        'uses' => 'UserController@cashback',
    ]);

    Route::match(['get', 'post'], 'balance', [
        'as'   => 'my-balance',
        'uses' => 'UserController@balance',
    ]);

    Route::get('banned', [
        'as'   => 'banned',
        'uses' => 'UserController@banned',
    ]);

    Route::get('orders/{id?}', [
        'as'   => 'my-orders',
        'uses' => 'UserController@orders',
    ]);

    Route::get('orders/create', [
        'as'   => 'my-orders.create',
        'uses' => 'UserController@createOrder',
    ]);

    Route::post('orders/create', [
        'as'   => 'my-orders.store',
        'uses' => 'UserController@storeOrder',
    ]);

    Route::delete('order/{id}', [
        'as'   => 'my-orders.delete',
        'uses' => 'UserController@deleteOrder',
    ]);

    Route::delete('link/{id}', [
        'as'   => 'my-orders.link.delete',
        'uses' => 'UserController@deleteLink',
    ]);

    Route::get('order/{id}', [
        'as'   => 'my-orders.show',
        'uses' => 'UserController@order',
    ]);

    Route::get('packages/{id?}', [
        'as'   => 'my-packages',
        'uses' => 'UserController@packages',
    ]);

    Route::get('declaration', [
        'as'   => 'declaration.create',
        'uses' => 'UserController@declarationCreate',
    ]);
    Route::post('declaration', [
        'as'   => 'declaration.store',
        'uses' => 'UserController@declarationStore',
    ]);

    Route::get('declaration/{id}/{page?}', [
        'as'   => 'declaration.edit',
        'uses' => 'UserController@declaration',
    ]);
    Route::get('declaration/delete/{id}', [
        'as'   => 'declaration.delete',
        'uses' => 'UserController@declarationDelete',
    ]);

    Route::post('declaration/{id}/{page?}', [
        'as'   => 'declaration.update',
        'uses' => 'UserController@declarationUpdate',
    ]);

    Route::get('payment/{id}', [
        'as'   => 'payment',
        'uses' => 'UserController@payment',
    ]);

    Route::match(['get', 'post'], 'order/{id}/pay', [
        'as'   => 'my-orders.pay',
        'uses' => 'UserController@payOrder',
    ]);

    Route::match(['get', 'post'], 'deposit', [
        'as'   => 'deposit',
        'uses' => 'UserController@deposit',
    ]);

    Route::match(['get', 'post'], 'payment/{id}/paytr', [
        'as'   => 'my-orders.paytr',
        'uses' => 'UserController@payTR',
    ]);

    Route::match(['get', 'post'], 'payment/{id}/paymes', [
        'as'   => 'my-orders.paymes',
        'uses' => 'UserController@paymes',
    ]);

    Route::get('edit/{nulled?}', [
        'as'   => 'edit',
        'uses' => 'UserController@edit',
    ]);
    Route::post('edit', [
        'as'   => 'update',
        'uses' => 'UserController@update',
    ]);

    Route::get('show_district_price', [
        'as' => 'show_district_price',
        'uses' => 'UserController@showDistricts',
    ]);
});
<?php
Route::group([
    'domain' => env('PARTNER_SUB', 'wh') . '.' . env('DOMAIN_NAME', 'mobex.az'),
    'namespace' => 'Warehouse',
], function () {

    App::setLocale('en');

    Route::group(['middleware' => ['auth:worker', 'panel']], function () {

        Route::get('/', [
            'as' => 'my.dashboard',
            'uses' => 'MainController@check',
        ]);

        Route::get('/users', [
            'as' => 'my.users',
            'uses' => 'MainController@users',
        ]);

        Route::get('/dashboard', [
            'as' => 'my.index',
            'uses' => 'MainController@check',
        ]);

        Route::get('edit/{id?}', [
            'as' => 'my.edit',
            'uses' => 'UserController@edit',
        ]);

        Route::put('edit/{id?}', [
            'as' => 'my.update',
            'uses' => 'UserController@update',
        ]);

        Route::resource('w-packages', 'MainController', [
            'parameters' => [
                'w-packages' => 'id',
            ],
        ]);
        Route::get('w-packages/export/{items?}', [
            'as' => 'w-packages.export',
            'uses' => 'MainController@export'
        ]);

        Route::get('w-packages/manifest/{items?}', [
            'as' => 'w-packages.manifest',
            'uses' => 'MainController@manifest'
        ]);

        Route::get('w-processed/{status?}', [
            'as' => 'w-processed',
            'uses' => 'ProcessedController@index',
        ]);

        Route::post('w-processed/detach/{id?}/{package_id?}', [
            'as' => 'w-parceling.detach',
            'uses' => 'ParcellingController@deletePackage',
        ]);

        Route::get('my-package/{id}/label', [
            'as' => 'w-packages.label',
            'uses' => 'MainController@label'
        ]);


        Route::get('my-package/{id}/modal', [
            'as' => 'w-packages.modal',
            'uses' => 'MainController@modal'
        ]);


        Route::post('my-package/{id}/ajax', [
            'as' => 'w-packages.ajax',
            'uses' => 'MainController@ajax'
        ]);
        Route::get('barcode/{code?}', [
            'as' => 'warehouse.barcode.scan',
            'uses' => 'MainController@barcodeScan'
        ]);

        Route::post('my-package/multiple', [
            'as' => 'w-packages.multiple',
            'uses' => 'MainController@multiUpdate'
        ]);

        Route::post('my-parcel/{id}/add-package', [
            'as' => 'w-parcel.add_package',
            'uses' => 'MainController@addPackage'
        ]);

        Route::get('cell', [
            'as' => 'warehouse.cells',
            'uses' => 'MainController@cells'
        ]);

        Route::get('stats', [
            'as' => 'warehouse.stats',
            'uses' => 'MainController@statistics'
        ]);

        Route::resource('w-parcels', 'ParcellingController', [
            'parameters' => [
                'w-parcels' => 'id',
            ],
        ]);

        Route::get('w-parcels/manifest', [
            'as' => 'w-parcels.manifest',
            'uses' => 'ParcellingController@manifest'
        ]);

        Route::match(['get'],'parcels/{status?}', [
            'as' => 'w-parcels.index',
            'uses' => 'ParcellingController@index'
        ]);

        Route::post('parcels/sent/{id}', [
            'as' => 'w-parcels.sent',
            'uses' => 'ParcellingController@sent'
        ]);
        Route::get('parcels/send/all', [
            'as' => 'w-parcels.sendAll',
            'uses' => 'ParcellingController@sendAll'
        ]);

        Route::get('w-parcels/{id}/label', [
            'as' => 'w-parcels.label',
            'uses' => 'ParcellingController@label'
        ]);


        Route::get('user/packages/{id?}', [
            'as' => 'w-user.packages',
            'uses' => 'MainController@userPackages'
        ]);
    });

    require 'auth.php';
    Route::get('my-package/{id}.pdf', [
        'as' => 'w-packages.pdf_label',
        'uses' => 'MainController@PDFLabel'
    ]);

    Route::get('my-package/invs-{id}.pdf', [
        'as' => 'w-packages.invoiceLabel',
        'uses' => 'MainController@invoiceLabel'
    ]);

    Route::get('my-package/invs-{id}', [
        'as' => 'w-packages.invoiceLabelView',
        'uses' => 'MainController@invoiceLabelView'
    ]);
});
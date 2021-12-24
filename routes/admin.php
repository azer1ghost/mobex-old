<?php
Route::group([
    'domain'    => env('ADMIN_SUB', 'panel') . '.' . env('DOMAIN_NAME', 'mobex.az'),
    'namespace' => 'Admin',
], function () {

    App::setLocale('en');

    Route::group(['middleware' => ['auth:admin', 'panel']], function () {

        Route::get('/', [
            'as'   => 'dashboard',
            'uses' => 'DashboardController@main',
        ]);
        Route::get('/search-users', [
            'as'   => 'admin.users',
            'uses' => 'UserController@search',
        ]);

        Route::get('campaigns/search', [
            'as'   => 'campaigns.search',
            'uses' => 'CampaignController@search',
        ]);

        /* Default resources */
        $resources = [
            'promo',
            'faq',
            'role',
            'setting',
            'admin',
            'page',
            'news',
            'package_type',
            'category',
            'country',
            'warehouse',
            'user',
            'store',
            'city',
            'district',
            'service',
            'product',
            'coupon',
            'filial',
            'card',
            'order'     => [
                ['name' => 'logs', 'method' => 'get'],
                ['name' => 'custom', 'method' => 'put'],
                ['name' => 'links', 'method' => 'get'],
                ['name' => 'linkajax', 'method' => 'post'],
                ['name' => 'ajax', 'method' => 'post'],
            ],
            'parcel'   => [
                ['name' => 'label', 'method' => 'get'],
                ['name' => 'ajax', 'method' => 'post'],
            ],
            'package'   => [
                ['name' => 'request', 'method' => 'get'],
                ['name' => 'logs', 'method' => 'get'],
                ['name' => 'label', 'method' => 'get'],
                ['name' => 'ajax', 'method' => 'post'],
            ],
            'cell'      => [
                ['name' => 'ajax', 'method' => 'post'],
            ],
            'done'      => [
                ['name' => 'label', 'method' => 'get'],
            ],
            'delivery'  => [
                ['name' => 'ajax', 'method' => 'post'],
                ['name' => 'label', 'method' => 'get'],
            ],
            'unknown',
            'activity',
            'notification',
            'slider',
            'sms',
            'email',
            'gift_card' => [
                ['name' => 'label', 'method' => 'get'],
            ],
            'transaction',
            'campaign',
        ];

        foreach ($resources as $key => $resource) {

            $route = is_array($resource) ? $key : $resource;
            $pluralRoute = str_plural($route);

            Route::resource($pluralRoute, studly_case($route) . 'Controller', [
                'parameters' => [
                    $pluralRoute => 'id',
                ],
            ]);

            /* Extra route for resource */
            if (is_array($resource)) {
                foreach ($resource as $singleRoute) {

                    if (is_array($singleRoute['name'])) {
                        $data = $singleRoute['name'];
                    } else {
                        $data = [
                            'url'  => $pluralRoute . '/{id}/' . $singleRoute['name'],
                            'as'   => $pluralRoute . "." . $singleRoute['name'],
                            'uses' => studly_case($route) . 'Controller@' . $singleRoute['name'],
                        ];
                    }

                    Route::{$singleRoute['method']}($data['url'], [
                        'as'   => $data['as'],
                        'uses' => $data['uses'],
                    ]);
                }
            }
        }

        Route::resource('warehouses/{warehouse_id}/addresses', 'AddressController', [
            'parameters' => [
                'addresses' => 'id',
            ],
        ]);

        Route::resource('warehouses/{warehouse_id}/workers', 'WorkerController', [
            'parameters' => [
                'workers' => 'id',
            ],
        ]);

        Route::get('barcode/{code?}', [
            'as'   => 'admin.barcode.scan',
            'uses' => 'PackageController@barcodeScan',
        ]);

        Route::get('packages/export/{items?}', [
            'as'   => 'packages.export',
            'uses' => 'PackageController@export',
        ]);

        Route::get('users/export/{items?}', [
            'as'   => 'users.export',
            'uses' => 'UserController@export',
        ]);

        Route::get('packages/manifest/{items?}', [
            'as'   => 'packages.manifest',
            'uses' => 'PackageController@manifest',
        ]);

        Route::post('packages/multiple', [
            'as'   => 'packages.multiple',
            'uses' => 'CellController@multiUpdate',
        ]);

        Route::get('cells/find', [
            'as'   => 'cells.find',
            'uses' => 'CellController@find',
        ]);

        Route::get('logs', [
            'as'   => 'system.logs',
            'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index',
        ]);
    });

    require 'auth.php';
});
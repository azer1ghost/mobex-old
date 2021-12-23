<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $view = [
        'sub_title'   => 'Districts',
        'formColumns' => 10,
        'listColumns' => 6,
    ];

    protected $list = [
        'name',
        'city.name' => [
            'label' => 'City',
        ],
    ];

    protected $fields = [
        [
            'label'             => 'Name',
            'name'              => 'name',
            'type'              => 'text',
            'validation'        => 'required|string|min:3',
            'wrapperAttributes' => [
                'class' => 'col-md-8',
            ],
        ],
        [
            'label'             => 'City',
            'type'              => 'select2',
            'name'              => 'city_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\City',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'required|integer',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Courier</h3></div>',
        ],
        [
            'name'              => 'has_delivery',
            'label'             => 'Has delivery',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'delivery_fee',
            'label'             => 'Delivery price',
            'hint'              => 'Manat',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'km',
            'label'             => 'Distance from the center (km)',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'zip_index',
            'label'             => 'Zip index',
            'type'              => 'text',
            'validation'        => 'nullable|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
    ];
}

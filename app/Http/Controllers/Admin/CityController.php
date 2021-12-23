<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class CityController extends Controller
{
    protected $view = [
        'sub_title'   => 'Cities',
        'formColumns' => 8,
        'listColumns' => 6,
    ];

    protected $list = [
        'name',
    ];

    protected $fields = [

        [
            'label'      => 'Name',
            'name'       => 'name',
            'type'       => 'text',
            'validation' => 'required|string|min:3',
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
    ];
}

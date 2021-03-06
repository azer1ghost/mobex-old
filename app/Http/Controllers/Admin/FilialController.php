<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class FilialController extends Controller
{
    protected $view = [
        'sub_title'   => 'Branches',
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
            'name'       => 'address',
            'label'      => 'Address',
            'type'       => 'textarea',
            'validation' => 'required|string|min:10',
        ],

        [
            'name'              => 'phone',
            'label'             => 'Phone',
            'type'              => 'text',
            'validation'        => 'nullable|string|min:3',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
        ],
        [
            'name'              => 'working_hours',
            'label'             => 'Working Hours',
            'type'              => 'text',
            'validation'        => 'nullable|string|min:3',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],

        [
            'name'       => 'location',
            'label'      => 'GoogleMap Embed Iframe',
            'type'       => 'textarea',
            'validation' => 'required|string|min:10',
            'attributes' => [
                'rows' => 8,
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10">Cell structure as json format</div>',
        ],
        [
            'name'       => 'cells',
            'label'      => 'Cells',
            'type'       => 'textarea',
            'validation' => 'nullable|string|min:5',
            'attributes' => [
                'rows' => 6,
            ],
        ],
    ];
}

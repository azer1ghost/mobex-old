<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $view = [
        'sub_title'   => 'Services',
        'formColumns' => 8,
        'listColumns' => 8,
    ];

    protected $list = [
        'image' => [
            'type' => 'image',
        ],
        'name',
    ];

    protected $fields = [
        [
            'name'       => 'image',
            'type'       => 'image',
            'label'      => 'Image',
            'validation' => 'nullable|image',
        ],
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
            'name'       => 'description',
            'label'      => 'Description',
            'type'       => 'summernote',
            'validation' => 'required|string|min:10',
        ],

    ];
}

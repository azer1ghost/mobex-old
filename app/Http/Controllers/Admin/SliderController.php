<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class SliderController extends Controller
{
    protected $view = [
        'formColumns' => 10,
        'sub_title'   => 'Slider items in home page',
    ];

    protected $list = [
        'alert' => [
            'type' => 'boolean',
        ],
        'image' => [
            'type' => 'image',
        ],
        'name',
        'url',
    ];

    protected $fields = [
        [
            'name'       => 'image',
            'type'       => 'image',
            'label'      => 'Background image',
            'validation' => 'nullable|image',
        ],
        [
            'name'       => 'name',
            'label'      => 'Name',
            'type'       => 'text',
            'validation' => 'required|string',
        ],
        [
            'name'       => 'title',
            'label'      => 'Title',
            'type'       => 'summernote',
            'validation' => 'nullable|string',
        ],
        [
            'name'       => 'content',
            'label'      => 'Content',
            'type'       => 'summernote',
            'validation' => 'nullable|string',
        ],
        [
            'name'              => 'url',
            'label'             => 'URL',
            'type'              => 'url',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-12',
            ],
            'validation'        => 'nullable|url',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],
        [
            'name'              => 'target_blank',
            'label'             => 'In new page',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'alert',
            'label'             => 'Popup Alert',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'active',
            'label'             => 'Active',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'show_after',
            'label'             => 'Popup (days)',
            'type'              => 'text',
            'default'           => 1,
            'wrapperAttributes' => [
                'class' => 'col-lg-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'button_label',
            'label'             => 'Button label text',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-lg-4',
            ],
            'validation'        => 'nullable|string',
        ],

    ];
}
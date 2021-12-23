<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class StoreController extends Controller
{
    protected $with = ['categories'];

    protected $withCount = ['coupons'];

    protected $view = [
        'sub_title'   => 'Online and offline stores',
        'formColumns' => 10,
    ];

    protected $list = [
        'logo'       => [
            'type'   => 'image',
            'height' => 30,
        ],
        'country'    => [
            'label' => 'Country',
            'type'  => 'country',
        ],
        'categories' => [
            'label' => 'Category',
            'type'  => 'category',
        ],
        'name',
        'url'        => [
            'type' => 'url',
        ],
    ];

    protected $fields = [
        [
            'name'       => 'logo',
            'label'      => 'Logo (220x120 white or transparent background)',
            'type'       => 'image',
            'validation' => 'nullable|image',
        ],
        [
            'label'             => 'Name',
            'name'              => 'name',
            'type'              => 'text',
            'validation'        => 'required|string|min:3',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
        ],
        [
            'name'              => 'url',
            'label'             => 'Web site address',
            'type'              => 'url',
            'validation'        => 'nullable|url',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
        ],
        [
            'label'             => 'Country',
            'type'              => 'select2',
            'name'              => 'country_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\Country',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'required|integer',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],
        [
            'label'      => "Categories",
            'type'       => 'select2_multiple',
            'name'       => 'categories',
            'entity'     => 'categories',
            'attribute'  => 'name',
            'model'      => 'App\Models\Category',
            'pivot'      => true,
            'validation' => 'nullable|array',
        ],
        [
            'name'  => 'featured',
            'label' => 'Show at home or not',
            'type'  => 'checkbox',
        ],
    ];
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class CountryController extends Controller
{
    protected $withCount = 'warehouses';

    protected $view = [
        'formColumns' => 8,
        'sub_title'   => 'Countries that our warehouses are situated',
    ];

    protected $list = [
        'flag'             => [
            'type'   => 'image',
            'height' => 30,
        ],
        'code',
        'name',
        'delivery_index'   => [
            'label' => 'Delivery Index',
        ],
        'warehouses_count' => [
            'label' => 'Warehouse',
        ],
    ];

    protected $fields = [
        [
            'name'       => 'flag',
            'label'      => 'Flag icon',
            'type'       => 'image',
            'validation' => 'nullable|image',
        ],
        [
            'name'              => 'name',
            'label'             => 'Name',
            'type'              => 'text',
            'validation'        => 'required|string|min:2',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'code',
            'label'             => 'ISO code',
            'type'              => 'text',
            'validation'        => 'required|string|min:2',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'delivery_index',
            'label'             => 'Delivery Index',
            'type'              => 'text',
            'validation'        => 'required|integer|min:1000',
            'default'           => 6000,
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'hint'              => 'For size weight calculation',
        ],
        [
            'name'              => 'custom_id',
            'label'             => 'SC ID',
            'type'              => 'text',
            'validation'        => 'required|integer|min:1',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"></div>',
        ],
        [
            'label'      => "Attached Pages",
            'type'       => 'select2_multiple',
            'name'       => 'pages',
            'entity'     => 'pages',
            'attribute'  => 'title',
            'model'      => 'App\Models\Page',
            'filter'     => 'self',
            'pivot'      => true,
            'validation' => 'nullable|array',
        ],
        [
            'name'       => 'emails',
            'label'      => "Order managers' email",
            'type'       => 'text',
            'validation' => 'nullable|string|min:2',
            "hint"       => 'Divide by comma. Ex: bar@example.com, foo@example.com',
        ],
        [
            'name'              => 'status',
            'label'             => 'Show in user panel',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
        [
            'name'              => 'allow_declaration',
            'label'             => 'Allow Declaration',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
        [
            'name'              => 'convert_invoice_to_usd',
            'label'             => 'Convert invoice to USD',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3>Settings</h3></div>',
        ],
        [
            'name'              => 'currency',
            'label'             => 'Currency',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currencies',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'weight_type',
            'label'             => 'Weight Type',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.weight',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'length_type',
            'label'             => 'Length Type',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.length',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|integer',
        ],
    ];
}

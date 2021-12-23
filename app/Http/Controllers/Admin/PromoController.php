<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Package;
use App\Models\Promo;
use App\Models\Warehouse;

class PromoController extends Controller
{
    protected $notificationKey = 'code';

    protected $view = [
        'formColumns' => 10,
    ];

    protected $list = [
        'title',
        'status',
        'code',
        'discount',
        'order_balance',
        'end_date',
        'limited_use',
        'action'         => [
            'type' => 'boolean',
        ],
        'users_count'    => [
            'label' => 'Users',
        ],
        'prod_count'     => [
            'label' => 'Productive',
        ],
        'efficiency',
        'package_weight' => [
            'label' => 'Total weight',
        ],
    ];

    protected $extraActions = [
        [
            'key'    => 'transactions_query',
            'label'  => 'Transactions',
            'icon'   => 'basket',
            'color'  => 'success',
            'target' => '_blank',
        ],
        [
            'key'    => 'package_query',
            'label'  => 'Packages',
            'icon'   => 'list',
            'color'  => 'info',
            'target' => '_blank',
        ],
    ];

    protected $fields = [
        [
            'name'              => 'title',
            'label'             => 'Title',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
        ],
        [
            'name'              => 'code',
            'label'             => 'Code',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'status',
            'label'             => 'Status',
            'type'              => 'select_from_array',
            'options'           => ['ACTIVE' => 'Active', 'PASSIVE' => 'Passive'],
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'  => 'action',
            'label' => 'Action',

            'hint'              => 'Remove passives?',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12"></div>',
        ],

        [
            'name'              => 'discount',
            'label'             => 'Discount (%)',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-percent"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_discount',
            'label'             => 'Liquid Discount',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-percent"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'order_balance',
            'label'             => 'Order Balance (TL)',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'limited_use',
            'label'             => 'Limited use',
            'type'              => 'text',
            'validation'        => 'nullable|integer',
            'prefix'            => '<i class="icon-list-numbered"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],

        /* [
             'name'              => 'package_balance',
             'label'             => 'Package Balance (AZN)',
             'type'              => 'text',
             'validation'        => 'nullable|numeric',
             'prefix'            => '<i class="icon-coin-dollar"></i>',
             'wrapperAttributes' => [
                 'class' => 'col-md-3',
             ],
         ],*/

        [
            'name'              => 'end_date',
            'label'             => 'End Date',
            'type'              => 'date',
            'validation'        => 'nullable',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
    ];

    public function indexObject()
    {
        $items = Promo::orderBy('status', 'desc')->orderBy('limited_use', 'asc')->orderBy('id', 'desc')->paginate($this->limit);

        return $items;
    }
}

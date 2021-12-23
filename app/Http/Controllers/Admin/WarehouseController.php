<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    protected $notificationKey = 'company_name';

    protected $createRedirection = 'addresses.create';

    protected $extraActions = [
        [
            'route' => 'addresses.index',
            'key'   => 'id',
            'label' => 'Addresses',
            'icon'  => 'map',
            'color' => 'success',
        ],
        [
            'route' => 'workers.index',
            'key'   => 'id',
            'label' => 'Workers',
            'icon'  => 'users',
            'color' => 'success',
        ],
    ];

    protected $list = [
        'country'         => [
            'label' => 'Country',
            'type'  => 'country',
        ],
        'company_name',
        'per_week'        => [
            'label' => 'Flies',
        ],
        'addresses_count' => [
            'label' => 'Addresses',
        ],
    ];

    protected $fields = [
        [
            'label'             => 'Country',
            'type'              => 'select2',
            'name'              => 'country_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\Country',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3',
            ],
            'validation'        => 'required|integer',
        ],
        [
            'name'              => 'company_name',
            'label'             => 'Company name',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
        ],
        [
            'name'              => 'min_size_vw',
            'label'             => 'Min cm for VW',
            'type'              => 'text',
            'validation'        => 'required|integer',
            'prefix'            => '<i class="icon-list-numbered"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'per_week',
            'label'             => 'Flies per week',
            'type'              => 'text',
            'validation'        => 'required|string',
            'prefix'            => '<i class="icon-airplane2"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"></div>',
        ],
        /* [
             'type' => 'html',
             'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Custom panel login for the bot</h3></div>',
         ],
         [
             'name'              => 'panel_login',
             'label'             => 'Login',
             'type'              => 'text',
             'validation'        => 'nullable|string',
             'wrapperAttributes' => [
                 'class' => 'col-md-6',
             ],
         ],
         [
             'name'              => 'panel_password',
             'label'             => 'Password',
             'type'              => 'text',
             'validation'        => 'nullable|string',
             'wrapperAttributes' => [
                 'class' => 'col-md-6',
             ],
         ],*/
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Settings</h3></div>',
        ],
        [
            'name'              => 'parcelling',
            'label'             => 'Parcelling',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'              => 'auto_print',
            'label'             => 'Auto Print',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'              => 'allow_make_fake_invoice',
            'label'             => 'Fake invoice',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'              => 'only_weight_input',
            'label'             => 'Weight/User Packaging',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'              => 'show_label',
            'label'             => 'Show Label on scan',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'name'              => 'show_invoice',
            'label'             => 'Show Invoice on scan',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Limitations for parcel</h3></div>',
        ],
        [
            'name'              => 'web_site',
            'label'             => 'Default WebSite',
            'type'              => 'text',
            'validation'        => 'nullable|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'label',
            'label'             => 'Print label',
            'type'              => 'select_from_array',
            'validation'        => 'nullable|integer',
            'options'           => [
                1 => 1,
                2 => 2,
                3 => 3,
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'limit_weight',
            'label'             => 'Limit weight (kg)',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-meter2"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'limit_amount',
            'label'             => 'Limit amount',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'limit_currency',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currencies',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Tariffs</h3></div>',
        ],
        [
            'name'              => 'per_g',
            'label'             => 'Gram',
            'hint'              => 'Price for a gram',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],

        [
            'name'              => 'per_kg',
            'label'             => 'For 1 kg',
            'hint'              => 'Price for 1 kg and up',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_1kq_to_5kq',
            'label'             => '1-5 kg',
            'hint'              => '1 kq - 5 kg',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_5kq_to_10kq',
            'label'             => '5-10 kg',
            'hint'              => '5 kq - 10 kg',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'up_10_kg',
            'label'             => '> 10 kg',
            'hint'              => 'Price for > 10 kg',
            'type'              => 'text',
            'validation'        => 'required|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h4 class="text-center">Optional</h4></div>',
        ],

        [
            'name'              => 'to_100g',
            'label'             => '0-100g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_100g_to_200g',
            'label'             => '100g-200g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_200g_to_500g',
            'label'             => '200g-500g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_500g_to_750g',
            'label'             => '500g-750g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'from_750g_to_1kq',
            'label'             => '750g-1kq',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'currency',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currencies',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'required|integer',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h3 class="text-center">Tariffs for liquid</h3></div>',
        ],
        [
            'name'              => 'has_liquid',
            'label'             => 'Has liquid option',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'l_per_g',
            'label'             => 'Gram',
            'hint'              => 'Price for a gram',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_per_kg',
            'label'             => 'For 1 kg',
            'hint'              => 'Price for 1 kg and up',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_1kq_to_5kq',
            'label'             => '1-5 kg',
            'hint'              => '1 kg - 5 kg',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_5kq_to_10kq',
            'label'             => '5-10 kg',
            'hint'              => '5 kg - 10 kg',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_up_10_kg',
            'label'             => '> 10 kg',
            'hint'              => 'Price for > 10 kg',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h4 class="text-center">Optional</h4></div>',
        ],

        [
            'name'              => 'l_to_100g',
            'label'             => '0-100g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_100g_to_200g',
            'label'             => '100g-200g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_200g_to_500g',
            'label'             => '200g-500g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_500g_to_750g',
            'label'             => '500g-750g',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'l_from_750g_to_1kq',
            'label'             => '750g-1kq',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"><h4 class="text-center">Discounts</h4></div>',
        ],

        [
            'name'              => 'discount_user',
            'label'             => 'User Discount (%)',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'              => 'liquid_discount_user',
            'label'             => 'User Liquid Discount (%)',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'validation'        => 'nullable|numeric',
        ],

        [
            'name'              => 'discount_dealer',
            'label'             => 'Dealer Discount (%)',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'              => 'liquid_discount_dealer',
            'label'             => 'Dealer Liquid Discount (%)',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'validation'        => 'nullable|numeric',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"><h2>Cell structure as json format</h2></div>',
        ],
        [
            'name'       => 'main_cells',
            'label'      => 'Cells',
            'type'       => 'textarea',
            'validation' => 'nullable|string|min:5',
            'attributes' => [
                'rows' => 6,
            ],
        ],
    ];

    public function indexObject()
    {
        $items = Warehouse::withCount('addresses')->paginate($this->limit);

        return $items;
    }
}

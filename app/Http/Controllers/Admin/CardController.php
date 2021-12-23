<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\PackagesExport;
use App\Exports\Admin\UsersExport;
use App\Http\Requests;
use App\Models\Extra\SMS;
use App\Models\Package;
use App\Models\Parcel;
use App\Models\User;
use DB;
use Illuminate\View\View;

class CardController extends Controller
{
    protected $notificationKey = 'name';

    protected $view = [
        'formColumns' => 10,
        'bodyClass'   => 'sidebar-xs',
        'row'         => true,
        'search'      => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-6',
                ],
            ],
        ],
        'sub_title'   => 'Cards for bot',
    ];

    protected $list = [
        'id',
        'name',
        'logo'           => [
            'type'   => 'image',
            'height' => 30,
            'label'  => 'Type',
        ],
        'hidden_number',
        'limit',
        'currency_value' => [
            'label' => 'Currency',
        ],
        'phone_number',
        'status',
    ];

    protected $fields = [
        [
            'name'              => 'name',
            'label'             => 'Name',
            'type'              => 'text',
            'validation'        => 'required|string|max:50',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'name_on_card',
            'label'             => 'Name on card',
            'type'              => 'text',
            'validation'        => 'required|string|max:50',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],

        [
            'name'              => 'number',
            'label'             => 'Card Number',
            'type'              => 'text',
            'validation'        => 'required|string|max:50',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'end_date',
            'label'             => 'End Date',
            'type'              => 'text',
            'validation'        => 'required|string|max:5',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
        ],
        [
            'name'              => 'cvv',
            'label'             => 'CVV',
            'type'              => 'text',
            'validation'        => 'required|string|max:3',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"><h2 class="text-center">Limits</h2></div>',
        ],
        [
            'name'              => 'phone_number',
            'label'             => '3d Phone number',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'limit',
            'label'             => 'Max Limit',
            'type'              => 'text',
            'validation'        => 'nullable|numeric',
            'hint'              => "Don't buy above",
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'currency',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currencies',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'status',
            'label'             => 'Status',
            'type'              => 'select_from_array',
            'options'           => [
                'ACTIVE'  => 'Active',
                'PASSIVE' => 'Passive',
                'PENDING' => 'Pending',
                'ERROR'   => 'ERROR',
            ],
            'wrapperAttributes' => [
                'class' => 'col-lg-3',
            ],
        ],

    ];
}

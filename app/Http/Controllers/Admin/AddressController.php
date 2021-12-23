<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Address;
use App\Models\Warehouse;

class AddressController extends Controller
{
    protected $notificationKey = 'id';

    protected $view = [
        'name' => null,
    ];

    protected $list = [
        'title',
        'address_line_1',
        'phone',
        'city',
        'zip_code',
    ];

    protected $fields = [
        [
            'name'              => 'title',
            'label'             => 'Title',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-5',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'contact_name',
            'label'             => 'Contact name',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-5',
            ],
            'validation'        => 'nullable|string',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"></div>',
        ],
        [
            'name'              => 'city',
            'label'             => 'City',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'state',
            'label'             => 'State',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'region',
            'label'             => 'Region',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-lg-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'zip_code',
            'label'             => 'Zip code',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-lg-3',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"></div>',
        ],
        [
            'name'       => 'address_line_1',
            'label'      => 'Address line 1',
            'type'       => 'text',
            'validation' => 'required|string',
        ],
        [
            'name'       => 'address_line_2',
            'label'      => 'Address line 2',
            'type'       => 'text',
            'validation' => 'nullable|string',
        ],
        [
            'name'              => 'phone',
            'label'             => 'Phone number',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
        ],
        [
            'name'              => 'mobile',
            'label'             => 'Mobile number',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 clearfix"></div>',
        ],
        [
            'name'       => 'passport',
            'label'      => 'Passport ID',
            'type'       => 'text',
            'prefix'     => '<i class="icon-credit-card"></i>',
            'hint'       => 'Some online platforms require ID number',
            'validation' => 'nullable|string',
        ],
        [
            'name'       => 'attention',
            'label'      => 'Attention',
            'type'       => 'textarea',
            'validation' => 'nullable|string',
        ],
        [
            'name'       => 'reminder',
            'label'      => 'Reminder',
            'type'       => 'textarea',
            'validation' => 'nullable|string',
        ],
    ];

    public function __construct()
    {
        $wId = request()->route('warehouse_id');

        $warehouse = Warehouse::find($wId);

        if (! $warehouse) {
            return back();
        }

        $this->routeParams = [
            'warehouse_id' => $warehouse->id,
        ];

        $this->view['name'] = 'Address for ' . $warehouse->company_name;
        parent::__construct();
    }

    public function indexObject()
    {
        $items = Address::where('warehouse_id', $this->routeParams['warehouse_id'])->paginate($this->limit);

        return $items;
    }
}

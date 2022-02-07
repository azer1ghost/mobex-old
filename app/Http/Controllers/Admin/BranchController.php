<?php

namespace App\Http\Controllers\Admin;

use View;

class BranchController extends Controller
{
    protected $view = [
        'sub_title'   => 'Branches',
        'listColumns' => 12,
    ];

    protected $list = [
        'name',
        'address',
        'phone',
        'status'
    ];

    protected $extraActions = [
        [
            'key'    => 'invoice',
            'label'  => 'Invoice',
            'icon'   => 'file-pdf',
            'color'  => 'info',
            'target' => '_blank',
        ],
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

    ];

    public function __construct()
    {
        parent::__construct();

        \View::share('extraAction', $this->extraActions);
    }
}

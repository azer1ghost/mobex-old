<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests;
use App\Models\Activity;

class ActivityController extends Controller
{
    protected $can = [
        'delete' => false,
        'update' => false,
    ];

    protected $view = [
        'sub_title' => 'Admin activities',
        'search'    => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [

                'name'              => 'content_type',
                'type'              => 'select_from_array',
                'options'           => [
                    'App\Models\Package'     => 'Package',
                    'App\Models\Warehouse'   => 'Warehouse',
                    'App\Models\User'        => 'User',
                    'App\Models\Transaction' => 'Transaction',

                ],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Type',
            ],
            [
                'type'              => 'select2',
                'name'              => 'admin_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Admin',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Admins',
            ],
            [
                'type'              => 'select2',
                'name'              => 'worker_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Worker',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Workers',
            ],

        ],
    ];

    protected $list = [
        'admin.name'  => [
            'label' => 'Admin',
        ],
        'worker.name' => [
            'label' => 'Worker',
        ],
        'content_id',
        //'content_type',
        'description',
        'data',
        'ip',
        'user_agent',
    ];

    public function indexObject()
    {
        $validator = \Validator::make(\Request::all(), [
            'q'          => 'string',
            'admin_id'   => 'integer',
            'worker_id ' => 'integer',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = Activity::latest();

        if (\Request::get('worker_id') != null) {
            $items->where('worker_id', \Request::get('worker_id'));
        }

        if (\Request::get('content_type') != null) {
            $items->where('content_type', \Request::get('content_type'));
        }

        if (\Request::get('admin_id') != null) {
            $items->where('admin_id', \Request::get('admin_id'));
        }

        if (\Request::get('q') != null) {
            $q = str_replace('"', '', \Request::get('q'));
            $items->where('content_id', $q);
        }

        return $items->paginate($this->limit);
    }
}

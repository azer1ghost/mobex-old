<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests;
use App\Models\NotificationQueue;
use DB;

class NotificationController extends Controller
{
    protected $modelName = 'NotificationQueue';

    protected $can = [
        'create' => false,
        'delete' => false,
        'update' => false,
    ];

    protected $view = [
        'sub_title' => 'Notifications',
        'search'    => [
            [
                'name'              => 'user',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'User...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'name'              => 'type',
                'type'              => 'select_from_array',
                'options'           => [
                    'SMS'   => 'SMS',
                    'EMAIL' => 'EMAIL',
                    'PUSH'  => 'PUSH',
                ],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'Source',
            ],
            [
                'name'              => 'sent',
                'type'              => 'select_from_array',
                'options'           => ['0' => 'No', '1' => 'Yes'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Sent',
            ],
        ],
    ];

    protected $list = [
        'user' => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],

        'type',
        'to',
        'subject',
        'sent' => [
            'type' => 'boolean',
        ],
        'updated_at',
    ];

    public function indexObject()
    {
        $validator = \Validator::make(\Request::all(), [
            'user' => 'string',
            'q'    => 'string',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = NotificationQueue::latest();

        if (\Request::get('q') != null) {
            $q = str_replace('"', '', \Request::get('q'));
            $items->where('content', "like", "%" . $q . "%");
        }

        if (\Request::get('type') != null) {
            $items->where('type', \Request::get('type'));
        }

        if (\Request::get('sent') != null) {
            $items->where('sent', \Request::get('sent'));
        }

        if (\Request::get('user') != null) {
            $q = str_replace('"', '', \Request::get('user'));
            $items->where(function ($query) use ($q) {
                $query->whereHas('user', function (
                    $query
                ) use ($q) {
                    $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%")->orWhereHas('dealer', function (
                        $query
                    ) use ($q) {
                        $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                    });
                });
            });
        }

        return $items->paginate($this->limit);
    }
}

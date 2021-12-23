<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\PackagesExport;
use App\Exports\Admin\UsersExport;
use App\Http\Requests;
use App\Models\Extra\SMS;
use App\Models\Package;
use App\Models\Parcel;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $notificationKey = 'customer_id';

    protected $can = [
        'export' => true,
    ];

    protected $with = ['city', 'dealer'];

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
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'filial_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Filial',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All Filials',
            ],
            [
                'type'              => 'select2',
                'name'              => 'city_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\City',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All Cities',
            ],
            [
                'name'              => 'type',
                'type'              => 'select_from_array',
                'options'           => ['USER' => 'USER', 'DEALER' => 'DEALER'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Type',
            ],
            [
                'name'              => 'status',
                'type'              => 'select_from_array',
                'options'           => ['ACTIVE' => 'Active', 'PASSIVE' => 'Passive', 'BANNED' => 'Banned'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Status',
            ],
            [
                'type'              => 'select2',
                'name'              => 'promo_id',
                'attribute'         => 'title',
                'model'             => 'App\Models\Promo',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All Promos',
            ],
            [
                'name'       => 'event_date_range',
                'start_name' => 'start_date',
                'end_name'   => 'end_date',
                'type'       => 'date_range',

                'date_range_options' => [
                    'timePicker' => true,
                    'locale'     => ['format' => 'DD/MM/YYYY'],
                ],
                'wrapperAttributes'  => [
                    'class' => 'col-lg-4',
                ],
            ],
        ],
        'sub_title'   => 'Our members',
    ];

    protected $list = [
        'customer_id'    => [
            'order' => 'customer_id',
        ],
        'auto_charge'    => [
            'type'  => 'boolean',
            'label' => 'Charge',
        ],
        'dealer'         => [
            'type'  => 'custom.user',
            'label' => 'Dealer',
        ],
        'full_name'      => [
            'label' => 'Full name',
        ],
        'spending'       => [
            'label' => 'Limit',
        ],
        'order_balance',
        'type',
        'email',
        'cleared_phone'  => [
            'label' => 'Phone',
        ],
        'passport',
        'fin'            => [
            'order' => 'fin',
        ],
        'filial_name'    => [
            'label' => 'Filial',
        ],
        'total_discount' => [
            'label' => 'Discount',
        ],
        'login_at'       => ['label' => 'LastLogin', 'type' => 'date', 'order' => 'login_at'],
        'created_at'     => ['label' => 'Registered', 'type' => 'date', 'order' => 'created_at'],
        'address',
        'status',
    ];

    protected $fields = [
        [
            'name'              => 'name',
            'label'             => 'Name',
            'type'              => 'text',
            'validation'        => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3',
            ],
        ],
        [
            'name'              => 'surname',
            'label'             => 'Surname name',
            'type'              => 'text',
            'validation'        => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'label'             => 'Dealer',
            'type'              => 'select2',
            'name'              => 'parent_id',
            'attribute'         => 'full_name,customer_id',
            'model'             => 'App\Models\User',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
            'allowNull'         => true,
            'attributes'        => [
                //'class'    => 'select2-ajax',
                'data-url' => '/search-users',
            ],
        ],
        [
            'label'             => 'Filial',
            'type'              => 'select2',
            'name'              => 'filial_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\Filial',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
            //'allowNull'         => true,
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"></div>',
        ],
        [
            'name'       => 'address',
            'label'      => 'Address',
            'type'       => 'textarea',
            'validation' => 'required|string',
            'attributes' => [
                'rows' => 8,
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"></div>',
        ],
        [
            'name'              => 'phone',
            'label'             => 'Phone number',
            'type'              => 'text',
            'validation'        => 'required|string', //|unique:users,phone
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],

        ],
        [
            'label'             => 'City',
            'type'              => 'select2',
            'name'              => 'city_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\City',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
            //'allowNull'         => true,
        ],
        [
            'name'              => 'zip_code',
            'label'             => 'Zip code',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'gender',
            'label'             => 'Gender',
            'type'              => 'select_from_array',
            'options'           => ['1' => 'Male', '0' => 'Female'],
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-3',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"></div>',
        ],
        [
            'name'              => 'customer_id',
            'label'             => 'Customer ID',
            'type'              => 'text',
            'validation'        => 'required|string|unique:users,customer_id',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
        ],
        [
            'name'              => 'passport',
            'label'             => 'Passport',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
            'validation'        => 'required|string|unique:users,passport',
        ],
        [
            'name'              => 'fin',
            'label'             => 'FIN',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
            'validation'        => 'required|string|unique:users,fin',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"><h1 class="text-center">Auth</h1></div>',
        ],
        [
            'name'              => 'email',
            'label'             => 'Email',
            'type'              => 'email',
            'validation'        => 'required|email|unique:users,email',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
        ],
        [
            'name'              => 'password',
            'label'             => 'Password',
            'type'              => 'password',
            'validation'        => [
                'store'  => 'required|string|min:6',
                'update' => 'nullable|string|min:6',
            ],
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
        ],
        [
            'name'              => 'verified',
            'label'             => 'Email Verified',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        [
            'name'              => 'sms_verification_status',
            'label'             => 'Phone # Verified',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        [
            'name'              => 'status',
            'label'             => 'Status',
            'type'              => 'select_from_array',
            'options'           => ['ACTIVE' => 'Active', 'PASSIVE' => 'Passive', 'BANNED' => 'Banned'],
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"><h1 class="text-center">Discount</h1></div>',
        ],
        [
            'name'              => 'type',
            'label'             => 'Type',
            'type'              => 'select_from_array',
            'options'           => ['USER' => 'User', 'DEALER' => 'Dealer', 'COMPANY' => 'Company'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3',
            ],
        ],
        [
            'name'              => 'discount',
            'label'             => 'Discount (%)',
            'type'              => 'text',
            'hint'              => 'For total discounts',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-2',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'              => 'liquid_discount',
            'label'             => 'Liquid Discount (%)',
            'type'              => 'text',
            'hint'              => 'For liquid discounts',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-2',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'label'             => 'Promo',
            'type'              => 'select2',
            'name'              => 'promo_id',
            'attribute'         => 'code',
            'model'             => 'App\Models\Promo',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|integer',
            'allowNull'         => true,
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10 clearfix"><h1 class="text-center">Settings</h1></div>',
        ],
        [
            'name'              => 'refresh_customs',
            'label'             => 'Refresh Customs packages',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'type'              => 'checkbox',
        ],
        [
            'name'              => 'auto_charge',
            'label'             => 'Auto Charge',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'type'              => 'checkbox',
        ],
        [
            'name'              => 'campaign_notifications',
            'label'             => 'Campaign Notifications',
            'wrapperAttributes' => [
                'class' => 'from-group col-md-3',
            ],
            'type'              => 'checkbox',
        ],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function indexObject()
    {
        $validator = \Validator::make(request()->all(), [
            'q' => 'string',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        if (\request()->get('sort') != null) {
            $sortKey = explode("__", \request()->get('sort'))[0];
            $sortType = explode("__", \request()->get('sort'))[1];
            $items = User::orderBy($sortKey, $sortType)->orderBy('id', 'desc');
        } else {
            $items = User::with(['city', 'dealer'])->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        }

        /* Filter filials */
        $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();
        if ($filials) {
            $items->whereIn('filial_id', $filials);
        }

        if (request()->get('q') != null) {
            $q = request()->get('q');
            $items->where(function ($query) use ($q) {
                $query->where("customer_id", "LIKE", "%" . $q . "%")->orWhere("email", "LIKE", "%" . $q . "%")->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%")->orWhere("phone", "LIKE", "%" . $q . "%")->orWhere("passport", "LIKE", "%" . $q . "%")->orWhere("company", "LIKE", "%" . $q . "%")->orWhere("address", "LIKE", "%" . $q . "%")->orWhere("status", "LIKE", "%" . $q . "%")->orWhereHas('dealer', function (
                    $query
                ) use ($q) {
                    $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(\Illuminate\Support\Facades\DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                });
            });
        }

        if (request()->get('filial_id') != null) {
            $items->where('filial_id', request()->get('filial_id'));
        }

        if (request()->get('city_id') != null) {
            $items->where('city_id', request()->get('city_id'));
        }

        if (request()->get('promo_id') != null) {
            $items->where('promo_id', request()->get('promo_id'));
        }

        if (request()->get('status') != null) {
            $items->where('status', request()->get('status'));
        }

        if (request()->get('type') != null) {
            $items->where('type', request()->get('type'));
        }

        if (request()->get('fin') !== null) {
            if (request()->get('fin')) {
                $items->whereNotNull('fin');
            } else {
                $items->whereNull('fin');
            }
        }

        if (\Request::get('start_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '<=', Carbon::createFromFormat("Y-m-d", request()->get('end_date'))->addDay()->format("Y-m-d"));
        }

        if (\request()->has('search_type') && \request()->get('search_type') == 'export') {
            if ($items->count()) {
                $items = $items->get();
            } else {
                $items = $items->paginate($this->limit);
            }
        } else {
            $items = $items->paginate($this->limit);
        }

        return $items;
    }

    public function export($items = null)
    {
        if (request()->has('hidden_items')) {
            $items = explode(",", request()->get('hidden_items'));
        }

        return \Excel::download(new UsersExport($items), 'users_' . uniqid() . '.xlsx');
    }

    public function search()
    {

        $q = request()->get('q') != null ? request()->get('q') : request()->get('term');

        $users = User::where(function ($query) use ($q) {
            $query->where("customer_id", "LIKE", "%" . $q . "%")->orWhere(\Illuminate\Support\Facades\DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
        })->take(15)->get();
        $data = [];

        foreach ($users as $user) {
            $data[] = ["id" => $user->id, "text" => $user->full_name . " (" . $user->customer_id . ")"];
        }

        return \GuzzleHttp\json_encode(["results" => $data]);
    }
}

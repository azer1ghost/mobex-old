<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\PackagesExport;
use App\Exports\Warehouse\ManifestExport;
use App\Models\Activity;
use App\Models\AzerpoctBranch;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\PackageType;
use App\Models\Parcel;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    protected $can = [
        'export' => true,
    ];

    protected $view = [
        'sum'            => [
            [
                'key'  => 'weight',
                'skip' => 11,
                'add'  => "kg",
            ],
            [
                'key'  => 'number_items',
                'skip' => 0,
            ],
            [
                'key'  => 'delivery_manat_price',
                'skip' => 1,
                'add'  => "₼",
            ],

        ],
        'colorCondition' => [
            'key'   => 'alert',
            'value' => 1,
        ],
        'bodyClass'      => 'sidebar-xs',
        'formColumns'    => 10,
        'search'         => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search anything'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'user_id',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'validation'        => 'required|integer',
                'allowNull'         => true,
                'attributes'        => [
                    'data-placeholder' => 'Search user',
                    'data-validation'  => 'required',
                    'class'            => 'select2-ajax',
                    'data-url'         => '/search-users',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'warehouse_id',
                'attribute'         => 'country.name',
                'model'             => 'App\Models\Warehouse',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All warehouses',
            ],
            [
                'name'              => 'status',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.package.status',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Status',
            ],

            [
                'name'              => 'paid',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.package.paid',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Paid Status',
            ],
            [
                'name'              => 'dec',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.package.dec',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Filter',
            ],
            [
                'name'              => 'custom_status',
                'type'              => 'select_from_array',
                'options'           => [
                    'Not Declared',
                    'Declared',
                    'Depeshed',
                ],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'SC',
            ],
            [
                'name'              => 'date_by',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.package.date_by',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
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
            [
                'type'              => 'select2',
                'name'              => 'filial_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Filial',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Filial',
            ],
//            [
//                'type'              => 'select2',
//                'name'              => 'branch_id',
//                'attribute'         => 'name',
//                'model'             => 'App\Models\Branch',
//                'wrapperAttributes' => [
//                    'class' => 'col-lg-2',
//                ],
//                'allowNull'         => 'All Branch',
//            ],
            [
                'type'              => 'select2',
                'name'              => 'zip_code',
                'attribute'         => 'zip_code',
                'model'             => 'App\Models\AzerpoctBranch',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Azerpoct',
            ],
            [
                'type'              => 'select2',
                'name'              => 'promo_id',
                'attribute'         => 'title',
                'model'             => 'App\Models\Promo',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Promos',
            ],
        ],
    ];

    protected $notificationKey = 'custom_id';

    protected $extraActions = [
        [
            'key'    => 'invoice',
            'label'  => 'Invoice',
            'icon'   => 'file-pdf',
            'color'  => 'info',
            'target' => '_blank',
        ],
        [
            'route'  => 'packages.label',
            'key'    => 'id',
            'label'  => 'Label',
            'icon'   => 'windows2',
            'color'  => 'success',
            'target' => '_blank',
        ],
        [
            'route'  => 'packages.logs',
            'key'    => 'logs',
            'label'  => 'Logs',
            'icon'   => 'list',
            'color'  => 'default',
            'target' => '_blank',
        ],
    ];

    protected $list = [
        'scanned_at'             => [
            'label' => 'DeliveredAt',
            'type'  => 'date',
            'order' => 'scanned_at',
        ],
        'parcel'                 => [
            'type'  => 'parcel',
            'label' => 'Parcel',
        ],
        'custom_status'          => [
            'type'  => 'customs',
            'label' => 'SC',
        ],
        'cell'                   => [
            'order' => 'cell',
        ],
        'custom_id'              => [
            'label' => 'CWB #',
            'order' => 'custom_id',
        ],
        'tracking_code'          => [
            'type'  => 'tracking_code',
            'label' => 'Track #',
            'order' => 'tracking_code',
        ],
        'user'                   => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'user.cleared_phone'     => [
            'label' => 'Phone',
        ],
        'user.filial_name'       => [
            'label' => 'Filial',
        ],
        'warehouse.country'      => [
            'label' => 'Country',
            'type'  => 'country',
        ],
        'weight_with_type'       => [
            'order'    => 'weight',
            'label'    => 'Weight',
            'type'     => 'editable',
            'editable' => [
                'key'   => 'weight',
                'route' => 'packages.ajax',
                'type'  => 'number',
            ],
        ],
        /* 'full_size'                 => [
             'label' => 'W/H/L',
         ],*/
        'number_items'           => [
            'order'    => 'number_items',
            'label'    => 'Items',
            'type'     => 'editable',
            'editable' => [
                'route' => 'packages.ajax',
                'type'  => 'number',
            ],
        ],
        'shipping_org_price'     => [
            'order' => 'shipping_amount',
            'label' => 'Invoice Price',
        ],
        'merged_delivery_price'  => [
            'order' => 'delivery_price',
            'label' => 'Delivery Price',
            /*'type'     => 'editable',
            'editable' => [
                'key'   => 'delivery_price',
                'route' => 'packages.ajax',
                'type'  => 'number',
            ],*/
        ],
        'depo_dept_exp'          => [
            'label' => 'Depo Dept',
        ],
        'total_price_with_label' => [
            'label' => 'Declared Value',
        ],
        /* 'show_label_with_label'  => [
             'label'    => 'Show Label',
             'type'     => 'editable',
             'editable' => [
                 'title'            => 'Label for warehouse',
                 'key'              => 'show_label',
                 'route'            => 'packages.ajax',
                 'type'             => 'checklist',
                 'sourceFromConfig' => 'ase.attributes.package.labelWithLabel',
                 'data'             => [
                     'emptytext'   => 'Hide',
                     'showbuttons' => 'bottom',
                     'tpl'         => '<div class="checkbox"></div>',
                 ],
             ],
         ],*/
        'status'                 => [
            'label'    => 'Status',
            'type'     => 'select-editable',
            'editable' => [
                'route'            => 'packages.ajax',
                'type'             => 'select',
                'sourceFromConfig' => 'ase.attributes.package.statusWithLabel',
            ],
        ],
        'user.package_balance'   => [
            'label' => 'Balance',
        ],
        'paid'                   => [
            'label'    => 'Paid',
            'type'     => 'paid',
            'editable' => [
                'route'            => 'packages.ajax',
                'type'             => 'select',
                'sourceFromConfig' => 'ase.attributes.package.paidWithLabel',
            ],
        ],
        'paid_by'                => [
            'label' => 'By',
        ],
        /* 'shipping_fee'           => [
             'label'    => 'Shipping_fee',
             'type'     => 'editable',
             'editable' => [
                 'route' => 'packages.ajax',
                 'type'  => 'number',
                 'key'   => 'shipping_fee',
             ],
         ],*/
        'worker'                 => [
            'label' => 'Worker',
        ],
        'id',
        'created_at'             => [
            'label' => 'CreatedAt',
            'type'  => 'date',
            'order' => 'created_at',
        ],
    ];

    protected $fields = [
        [
            'name'              => 'order_id',
            'type'              => 'text',
            'default'           => null,
            'validation'        => 'nullable|integer',
            'wrapperAttributes' => [
                'class' => 'hidden',
            ],
        ],
        [
            'name'              => 'links',
            'type'              => 'text',
            'default'           => null,
            'validation'        => 'nullable|string',
            'wrapperAttributes' => [
                'class' => 'hidden',
            ],
        ],
        [
            'label'             => 'WareHouse',
            'type'              => 'select2',
            'name'              => 'warehouse_id',
            'attribute'         => 'company_name,country.name',
            'model'             => 'App\Models\Warehouse',
            'wrapperAttributes' => [
                'class' => ' col-md-3',
            ],
            'validation'        => 'nullable|integer',
            'allowNull'         => true,
        ],
        [
            'label'             => 'User',
            'type'              => 'select2',
            'name'              => 'user_id',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'required|integer',
            'allowNull'         => true,
            'attributes'        => [
                'data-validation' => 'required',
                'class'           => 'select2-ajax',
                'data-url'        => '/search-users',
            ],
        ],
        [
            'name'              => 'status',
            'label'             => 'Status',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.package.status',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        /*[
            'name'              => 'paid',
            'label'             => 'Paid',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.package.paid',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],*/
        [
            'name'              => 'has_liquid',
            'label'             => 'Has liquid',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'show_label',
            'label'             => 'Show label for warehouse',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-2 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],

        [
            'name'              => 'custom_id',
            'label'             => 'CWB Number',
            'type'              => 'text',
            'hint'              => 'Special CWB number',
            'prefix'            => '<i class="icon-check"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'attributes'        => [
                'disabled' => 'disabled',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'tracking_code',
            'label'             => 'Tracking Code',
            'type'              => 'text',
            'hint'              => 'Special Tracking number',
            'prefix'            => '<i class="icon-truck"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'required|string|min:5|unique:packages,tracking_code',
        ],
        [
            'name'              => 'website_name',
            'label'             => 'WebSite name',
            'type'              => 'text',
            'hint'              => 'Also accept url',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'required|required_without_all:tracking_code,custom_id|string',
        ],
        [
            'label'             => 'Type',
            'type'              => 'select2_from_array',
            'name'              => 'type_id',
            'options'           => [],
            'attribute'         => 'translateOrDefault_en.name',
            'model'             => 'App\Models\PackageType',
            'query'             => [
                'key'       => 'custom_id',
                'condition' => '!=',
                'value'     => null,
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'allowNull'         => true,
            'validation'        => 'nullable|integer',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12"><h3 class="text-center">Shipping</h3></div>',
        ],
        [
            'name'              => 'weight',
            'label'             => 'Weight',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'              => 'weight_type',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.weight',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'number_items',
            'label'             => 'Number Items',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'required|integer',
        ],
        [
            'name'              => 'shipping_amount',
            'label'             => 'Invoiced price',
            'type'              => 'text',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'required|numeric',
        ],
        [
            'name'              => 'shipping_amount_cur',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currencies',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'invoice',
            'label'             => 'Invoice',
            'type'              => 'file',
            'wrapperAttributes' => [
                'class' => 'col-md-3 text-center',
            ],
            'validation'        => 'nullable|mimes:jpeg,jpg,png,gif,svg,pdf,doc,docx,csv,xls',
        ],
        /*[
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12"><h3 class="text-center">Manual inputs for Smart Customs</h3></div>',
        ],
        [
            'name'              => 'custom_awb',
            'label'             => 'AirwayBill number',
            'type'              => 'text',
            'prefix'            => '<i class="icon-plane"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'custom_parcel_number',
            'label'             => 'Parcel Number',
            'type'              => 'text',
            'prefix'            => '<i class="icon-bag"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|string',
        ],*/
        /* [
             'type' => 'html',
             'html' => '<div class="form-group mt-10 col-lg-12"><h3 class="text-center">Attachments</h3></div>',
         ],*/

        /*[
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12"><h3 class="text-center">Comments</h3></div>',
        ],
        [
            'name'       => 'admin_comment',
            'label'      => 'Admin Comment',
            'type'       => 'textarea',
            'prefix'     => '<i class="icon-user-tie"></i>',
            'validation' => 'nullable|string',
        ],

        [
            'name'       => 'user_comment',
            'label'      => 'User Comment',
            'type'       => 'textarea',
            'prefix'     => '<i class="icon-user"></i>',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ],

        [
            'name'       => 'warehouse_comment',
            'label'      => 'Warehouse Comment',
            'type'       => 'textarea',
            'prefix'     => '<i class="icon-office"></i>',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ],
        [
            'name'       => 'bot_comment',
            'label'      => 'Bot Comment',
            'type'       => 'textarea',
            'prefix'     => '<i class="icon-reddit"></i>',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]*/
    ];

    protected $with = ['type', 'warehouse', 'user', 'logs'];

    public function __construct()
    {
        $categoriesObj = PackageType::with('children')->whereNull('parent_id')->whereNotNull('custom_id')->get();

        $categories = [];
        foreach ($categoriesObj as $category) {
            $categories[$category->id] = $category->translateOrDefault('tr')->name;
            if ($category->children) {
                foreach ($category->children as $sub_category) {
                    $categories[$sub_category->id] = "  -  " . $sub_category->translateOrDefault('tr')->name . " (" . $category->translateOrDefault('tr')->name . ")";
                }
            }
        }
        $this->fields[11]['options'] = $categories;
        \View::share('fields', $this->fields);

        parent::__construct();
    }

    public function label($id)
    {
        $item = Package::withTrashed()->with(['user', 'warehouse', 'country'])->find($id);
        if (! $item) {
            abort(404);
        }
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if ($shipper && ! $shipper->country) {
            die("Warehouse doesn't have country.");
        }

        return view('admin.widgets.label', compact('item', 'shipper'));
    }

    public function logs($id)
    {
        $logs = Activity::where('content_id', $id)->where('content_type', Package::class)->orderBy('id', 'desc')->get();
        if (! $logs) {
            return back();
        }

        return view('admin.widgets.logs', compact('logs', 'id'));
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexObject()
    {
        $validator = \Validator::make(\Request::all(), [
            'q'             => 'string',
            'user_id'       => 'integer',
            'status'        => 'integer',
            'warehouse_id ' => 'integer',
            'start_date'    => 'date',
            'start_end'     => 'date',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = Package::with(['parcel', 'logs', 'transaction', 'portmanat', 'user', 'type']);

        if (\request()->get('sort') != null) {
            $sortKey = explode("__", \request()->get('sort'))[0];
            $sortType = explode("__", \request()->get('sort'))[1];
            $items = $items->orderBy($sortKey, $sortType)->orderBy('id', 'desc');
        } else {
            $items = $items->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        }

        if (\request()->get('dec') != 3) {
            $items = $items->where('status', '!=', 3);
        }

        /* Filter filials */
        $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();
        if ($filials) {
            $items->whereHas('user', function (
                $query
            ) use ($filials) {
                $query->whereIn('filial_id', $filials)->orWhere('filial_id', null);
            });
        } else {
            if (request()->get('filial_id') != null) {
                $items->whereHas('user', function (
                    $query
                ) {
                    $query->where('filial_id', request()->get('filial_id'));
                });
            }
        }

//        if (request()->get('branch_id') != null) {
//            $items->whereHas('user', function ($query) {
//                $query->where('branch_id', request()->get('branch_id'));
//            });
//        }

        if (request()->get('zip_code') != null) {

            $branch = AzerpoctBranch::find(request()->get('zip_code'));

            $items->where('zip_code', $branch->zip_code);
        }

        if (\request()->get('q') != null) {
            $q = str_replace('"', '', \Request::get('q'));
            $q = str_replace('\\', '', $q);
            $items->where(function ($query) use ($q) {
                $query
                    ->orWhere("tracking_code", "LIKE", "%" . $q . "%")
                    ->orWhereRaw(\DB::raw('concat("E", (6005710000 + id)) = "' . $q . '"'))
                    ->orWhere("website_name", "LIKE", "%" . $q . "%")
                    ->orWhere("custom_id", "LIKE", "%" . $q . "%")
                    ->orWhereHas('user', function ($query) use ($q) {
                        $query
                            ->where('customer_id', 'LIKE', '%' . $q . '%')
                            ->orWhere('passport', 'LIKE', '%' . $q . '%')
                            ->orWhere('fin', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%")
                            ->orWhereHas('dealer', function ($query) use ($q) {
                                $query
                                    ->where('customer_id', 'LIKE', '%' . $q . '%')
                                    ->orWhere('passport', 'LIKE', '%' . $q . '%')
                                    ->orWhere('fin', 'LIKE', '%' . $q . '%')
                                    ->orWhere('phone', 'LIKE', '%' . $q . '%')
                                    ->orWhere('email', 'LIKE', '%' . $q . '%')
                                    ->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                            });
                    });
            });
        }

        if (\request()->get('user_id') != null) {
            $items->where('user_id', request()->get('user_id'));
        }

        if (\Request::get('promo_id') != null) {
            $items->whereHas('user', function (
                $query
            ) {
                $query->where('promo_id', \Request::get('promo_id'));
            });
        }
        if (\Request::get('dec') == 2) {
            $items->ready();
        }
        if (\Request::get('dec') == 1) {
            $items->whereNull('shipping_amount')->whereNotNull('tracking_code');
        }

        if (\Request::get('dec') == 4) {
            $items->withTrashed();
        }

        if (\Request::get('status') != null) {
            $items->where('status', \Request::get('status'));
        }

        if (\Request::get('custom_status') != null) {
            $items->where('custom_status', \Request::get('custom_status'));
        }

        if (\Request::get('parcel_id') != null) {
            $items->whereHas('parcel', function (
                $query
            ) {
                $query->where('parcel_id', \request()->get('parcel_id'));
            });
        }

        if (\Request::get('paid') != null) {
            $items->where('paid', boolval(\Request::get('paid')));
        }

        if (\Request::get('warehouse_id') != null) {
            $items->where('warehouse_id', \Request::get('warehouse_id'));
        }

        if (\Request::get('start_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '<=', Carbon::createFromFormat("Y-m-d", request()->get('end_date'))->addDay()->format("Y-m-d"));
        }

        if (\request()->get('search_type') == 'export' || \request()->has('export')) {
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
        if (is_string($items)) {
            $parcel = Parcel::find($items);

            if ($parcel) {
                $items = $parcel->packages;
            } else {
                $items = [];
            }
        }

        $formats = ['Xlsx' => 'Xlsx', 'Mpdf' => 'pdf'];
        $type = isset($formats[\request()->get('format')]) ? \request()->get('format') : 'Xlsx';
        $ext = $formats[$type];

        return \Excel::download(new PackagesExport($items), 'packages_' . uniqid() . '.' . $ext, $type);
    }

    public function manifest($items = null)
    {
        $warehouse = null;
        if (request()->has('hidden_items')) {
            $items = explode(",", request()->get('hidden_items'));
        }
        if (is_string($items)) {
            $parcel = Parcel::find($items);
            $warehouse = $parcel->warehouse;

            if ($parcel) {
                $items = $parcel->packages;
            } else {
                $items = [];
            }
        }

        $formats = ['Xlsx' => 'xlsx', 'Mpdf' => 'pdf'];
        if ($warehouse->allow_make_fake_invoice) {
            $type = 'Xlsx';
            $ext = 'xlsx';
        } else {
            $type = isset($formats[\request()->get('format')]) ? \request()->get('format') : 'Xlsx';
            $ext = $formats[$type];
        }

        return \Excel::download(new ManifestExport($items, $warehouse, $type, $parcel), 'manifest_' . uniqid() . '.' . $ext, $type);
    }

    public function update(Request $request, $id)
    {
        $used = Package::find($id);

        $data = [];

        if (trim($used->status) != trim($request->get('status'))) {
            $data['status'] = [
                'before' => trim($used->status),
                'after'  => trim($request->get('status')),
            ];

            /* Send Notification */
            Notification::sendPackage($id, trim($request->get('status')));
        }

        if (! empty($data)) {
            $log = new PackageLog();
            $log->data = json_encode($data);
            $log->admin_id = \Auth::guard('admin')->user()->id;
            $log->package_id = $id;
            $log->save();
        }

        return parent::update($request, $id);
    }

    public function ajax(Request $request, $id)
    {
        $used = Package::find($id);
        if ($request->get('name') == 'status') {

            $data = [];

            if (trim($used->status) != trim($request->get('value'))) {
                $data['status'] = [
                    'before' => trim($used->status),
                    'after'  => trim($request->get('value')),
                ];

                if ($used->status < trim($request->get('value'))) {
                    /* Send Notification */
                    Notification::sendPackage($id, trim($request->get('value')));
                }
            }

            if (trim($request->get('value')) == 3) {
                event(new \App\Events\PackageCell('done', $used->id));
            }
            if (! empty($data)) {
                $log = new PackageLog();
                $log->data = json_encode($data);
                $log->admin_id = \Auth::guard('admin')->user()->id;
                $log->package_id = $id;
                $log->save();
            }
        }

        if ($request->get('name') == 'paid') {
            if ($used->status == 2) { // if in filial
                if ($request->get('value') != 0) {
                    // Pay
                    $type = $request->get('value') == 1 ? 'CASH' : config('ase.attributes.package.paid')[$request->get('value')];

                    if ($type == 'PACKAGE_BALANCE') {
                        if ($used->user->packageBalance() < $used->delivery_manat_price) {
                            return \Response::json("Hasn't enough balance", 400);
                        }
                    }
                    $request->merge(['value' => 1]);
                    Transaction::addPackage($used->id, $type);

                    // Make request to local warehouse
                    $used->requested_at = Carbon::now();
                    $used->save();

                    event(new \App\Events\PackageCell('find', $used->id));
                } else {

                    // Remove paid transaction
                    $check = Transaction::where('custom_id', $used->id)->where('paid_for', 'PACKAGE')->where('type', 'OUT')->first();
                    if ($check && $check->paid_by != 'PORTMANAT') {
                        Transaction::where('custom_id', $used->id)->where('paid_for', 'PACKAGE')->delete();
                    }

                    // Remove request if unpaid
                    $used->requested_at = null;
                    $used->save();
                }
            }
        }

        return parent::ajax($request, $id);
    }

    public function request($id)
    {
        $used = Package::find($id);
        if ($used) {

            $used->requested_at = $used->requested_at ? null : Carbon::now();
            $used->save();

            event(new \App\Events\PackageCell('find', $used->id));

            return "1";
        }

        return "0";
    }

    public function barcodeScan($code = null)
    {
        $code = $code ?: \request()->get('code');

        if (! $code) {
            return response()->json([
                'error' => 'Cannot read the barcode!',
            ]);
        }
        // Check barcode
        $package = Package::whereTrackingCode($code)->orWhere('custom_id', $code)->first();

        if ($package) {
            $status = $package->status;

            $notification = false;
            if (app('laratrust')->can('update-cells')) {
                /* Send Notification */
                if ($status < 2) {
                    $package->status = 2;
                    $notification = true;
                    if (! $package->scanned_at) {
                        $package->scanned_at = Carbon::now();
                    }
                    $package->save();
                }
            }

            if (app('laratrust')->can('update-cells') && ! $package->cell) {
                return response()->json([
                    'redirect' => route('cells.edit', $package->id),
                ]);
            } else {
                return response()->json([
                    'success' => $notification ? 'Notification was sent' : 'You have already scanned this package :-)',
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Package does not exist with that barcode :' . $code,
            ]);
        }
    }
}

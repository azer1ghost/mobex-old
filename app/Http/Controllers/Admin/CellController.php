<?php

namespace App\Http\Controllers\Admin;

use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Parcel;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CellController extends Controller
{
    protected $modelName = 'Package';

    protected $user = null;

    protected $view = [
        'checklist'   => [
            [
                'route' => 'packages.multiple',
                'key'   => 'status',
                'value' => 3,
                'label' => 'Done',
                'icon'  => 'check',
            ],
        ],
        'formColumns' => 10,
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
                'name'              => 'warehouse_id',
                'attribute'         => 'company_name,country.name',
                'model'             => 'App\Models\Warehouse',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All warehouses',
            ],
            [
                'name'              => 'requested',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.warehouse.filter',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Filter',
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
    ];

    protected $notificationKey = 'custom_id';

    protected $list = [
        'scanned_at'        => [
            'label' => 'Delivered At',
            'type'  => 'date',
        ],
        'requested_at'      => [
            'label' => 'Requested At',
        ],
        'cell'              => [
            'label'    => 'Cell',
            'type'     => 'select-editable',
            'editable' => [
                'route'  => 'cells.ajax',
                'type'   => 'select',
                'key'    => 'cell',
                'source' => null,
            ],
        ],
        'custom_id'         => [
            'label' => 'CWB #',
        ],
        'user'              => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'warehouse.country' => [
            'label' => 'Country',
            'type'  => 'country',
        ],
        'weight_with_type'  => [
            'label' => 'Weight',
        ],
        'number_items'      => [
            'label' => 'Items',
        ],
    ];

    protected $fields = [
        [
            'name'              => 'custom_id',
            'label'             => 'CWB Number',
            'type'              => 'text',
            'prefix'            => '<i class="icon-check"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
            'attributes'        => [
                'disabled' => 'disabled',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'cell',
            'label'             => 'Cell',
            'type'              => 'select_from_array',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
            'options'           => null,
            'allowNull'         => 'Select Cell',
            'validation'        => 'nullable|string',
        ],

    ];

    protected $with = ['user'];

    public function __construct()
    {
        $this->list['cell']['editable']['source'] = generateCells();
        $this->fields[1]['options'] = generateCells(false);

        if (\request()->route() != null && \request()->route()->getName() == 'cells.edit') {
            $cellsView = null;

            $id = (int) \request()->route()->parameter('id');
            $package = Package::find($id);
            $user = $package->user;

            $dealer = $package->user->dealer ? $package->user->dealer : null;

            if ($dealer) {
                $usersId = User::whereParentId($dealer->id)->where('id', '!=', $dealer->id)->pluck("id")->all();
                $nearBy = Package::whereIn('user_id', $usersId)->where('id', '!=', $id)->whereNotNull('cell')->orderBy('cell', 'asc')->where('status', 2)->first();
                $nearByCount = Package::whereIn('user_id', $usersId)->where('id', '!=', $id)->whereNotNull('cell')->where('status', 2)->count();
            } else {
                $nearBy = Package::where('user_id', $user->id)->where('id', '!=', $id)->whereNotNull('cell')->where('status', 2)->orderBy('cell', 'asc')->first();
                $nearByCount = Package::where('user_id', $user->id)->where('id', '!=', $id)->whereNotNull('cell')->where('status', 2)->count();
            }

            if ($nearByCount) {
                $nearBy = $nearBy->cell;
            }

            $includes = [];

            $includes[] = [
                'view' => 'admin.widgets.alerting',
                'data' => [
                    'nearBy'      => $nearBy,
                    'nearByCount' => $nearByCount,
                    'dealer'      => $dealer,
                    'user'        => $user,
                    'package'     => $package,
                ],
            ];

            $includes[] = [
                'view' => 'admin.widgets.cells',
                'data' => [
                    'nearBy' => $nearBy,
                    //'cells'  => $cells,
                ],
            ];

            \View::share([
                'includes' => $includes,
            ]);
        }

        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexObject()
    {
        $validator = \Validator::make(\Request::all(), [
            'q'             => 'string',
            'status'        => 'integer',
            'warehouse_id ' => 'integer',
            'start_date'    => 'date',
            'start_end'     => 'date',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = Package::where('status', 2)->orderBy('requested_at', 'desc')->orderBy('cell', 'asc');

        /* Filter filials */
        $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();
        if ($filials) {
            $items->whereHas('user', function (
                $query
            ) use ($filials) {
                $query->whereIn('filial_id', $filials);
            });
        }

        if (\request()->get('requested') == 1) {
            $items->whereNotNull('requested_at');
        }

        if (\Request::get('q') != null) {
            $q = \Request::get('q');
            $items->where(function ($query) use ($q) {
                $query->orWhere("cell", strtoupper($q))->orWhere("tracking_code", "LIKE", "%" . $q . "%")->orWhereRaw(\DB::raw('concat("E", (6005710000 + id)) = "' . $q . '"'))->orWhere("custom_id", "LIKE", "%" . $q . "%")->orWhereHas('user', function (
                    $query
                ) use ($q) {
                    $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%")->orWhereHas('dealer', function (
                        $query
                    ) use ($q) {
                        $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                    });
                })->orWhereHas('parcel', function (
                    $query
                ) use ($q) {
                    $parcel = Parcel::whereCustomId($q)->first();
                    $id = $parcel ? $parcel->id : 0;
                    $query->where('parcel_id', $id);
                });
            });
        }

        if (\Request::get('warehouse_id') != null) {
            $items->where('warehouse_id', \Request::get('warehouse_id'));
        }

        if (\Request::get('start_date') != null) {
            $items->where('scanned_at', '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where('scanned_at', '<=', Carbon::createFromFormat("Y-m-d", request()->get('end_date'))->addDay()->format("Y-m-d"));
        }

        $items = $items->paginate($this->limit);

        return $items;
    }

    public function ajax(Request $request, $id)
    {
        $used = Package::find($id);

        if ($request->get('name') == 'cell') {
            if (! $used->cell) {

                Notification::sendPackage($used->id, '2', env('IN_BAKU_HOUR', 1));

                // Auto Pay
                if ($used->user && $used->user->auto_charge && $used->user->packageBalance() >= $used->delivery_manat_price) {
                    Transaction::addPackage($used->id, 'PACKAGE_BALANCE');
                    $used->paid = true;
                    $used->save();
                }
            }
        }

        if ($request->get('name') == 'status') {

            $data = [];

            if (trim($used->status) != trim($request->get('value'))) {
                $data['status'] = [
                    'before' => trim($used->status),
                    'after'  => trim($request->get('value')),
                ];
            }

            if (! empty($data)) {
                $log = new PackageLog();
                $log->data = json_encode($data);
                $log->admin_id = \Auth::guard('admin')->user()->id;
                $log->package_id = $id;
                $log->save();
            }
        }

        return parent::ajax($request, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->fields[] = [
            'name'              => 'tracking_code',
            'label'             => 'Cell',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
            'validation'        => 'nullable|string',
        ];

        return parent::edit($id);
    }

    public function find()
    {

        $code = \request()->get('cwb');
        if (! $code) {
            return redirect()->back();
        }
        $package = Package::whereIn('status', [1, 2])->whereTrackingCode($code)->orWhere('custom_id', $code)->first();

        if ($package) {
            $status = $package->status;

            /* Send Notification */
            if ($status < 2) {
                $package->status = 2;
                if (! $package->scanned_at) {
                    $package->scanned_at = Carbon::now();
                }
                $package->save();
            }

            return redirect()->route('cells.edit', $package->id);
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (! $package->cell) {
            if (! $package->scanned_at) {
                $package->scanned_at = Carbon::now();
                $package->save();
            }
            Notification::sendPackage($package->id, '2', env('IN_BAKU_HOUR', 1));

            // Auto Pay
            if ($package->user && $package->user->auto_charge && $package->user->packageBalance() >= $package->delivery_manat_price) {
                Transaction::addPackage($package->id, 'PACKAGE_BALANCE');
                $package->paid = true;
                $package->save();
            }
        }

        return parent::update($request, $id);
    }

    /**
     * For multiple updates
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function multiUpdate(Request $request)
    {
        $items = Package::whereIn('id', $request->get('ids'))->whereNotNull('requested_at')->where($request->get('key'), "!=", $request->get('value'))->get();

        $count = $items->count();

        if ($count) {
            $key = $request->get('key');
            foreach ($items as $item) {

                $item->{$key} = $request->get('value');
                $item->save();
            }

            return \Response::json(['message' => $count . ' items has been updated!']);
        } else {
            return \Response::json(['message' => "There isn't any data to update!"], 400);
        }
    }
}

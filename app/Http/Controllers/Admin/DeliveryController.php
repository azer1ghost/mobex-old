<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\DeliveriesExport;
use App\Exports\Admin\PackagesExport;
use App\Models\Delivery;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Parcel;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $can = [
        'export' => true,
        'update' => false,
        'create' => false,
        'delete' => false,
    ];

    protected $extraActions = [
        [
            'key'   => 'custom_id',
            'label' => 'Export [XLS]',
            'icon'  => 'file-download',
            'route' => 'packages.export',
            'query' => [
                'format' => 'Xlsx',
            ],
            'color' => 'info',
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Export [PDF]',
            'icon'  => 'file-download',
            'route' => 'packages.export',
            'query' => [
                'format' => 'Mpdf',
            ],
            'color' => 'info',
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Manifest [XLS]',
            'icon'  => 'download',
            'route' => 'packages.manifest',
            'query' => [
                'format' => 'Xlsx',
            ],
            'color' => 'success',
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Manifest [PDF]',
            'icon'  => 'download',
            'route' => 'packages.manifest',
            'query' => [
                'format' => 'Mpdf',
            ],
            'color' => 'success',
        ],
    ];

    //protected $route = 'deliveries';

    protected $notificationKey = 'custom_id';

    //protected $modelName = 'Delivery';

    protected $view = [
        'search' => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'name'              => 'status',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.delivery.status',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Status',
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
            [
                'type'              => 'select2',
                'name'              => 'district',
                'attribute'         => 'full_name',
                'model'             => 'App\Models\District',
                'query'             => [
                    'key'       => 'has_delivery',
                    'condition' => '=',
                    'value'     => 1,
                ],
                'wrapperAttributes' => [
                    'class' => 'col-lg-4',
                ],
                'allowNull'         => 'All Districts',
            ],

        ],
    ];

    protected $list = [
        'merged_delivery_price' => [
            'label' => 'Total',
        ],
        'user'                  => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'cell',
        'custom_id',
        'weight_with_type'      => [
            'label' => 'Weight',
            'type'  => 'text',
        ],

        'created_at' => [
            'label' => 'At',
            'type'  => 'date',
        ],
    ];

    public function indexObject()
    {
        $items = Delivery::with([
            'packages',
            'filial',
            'user',
        ])->withCount(['packages'])->whereHas('packages')->orderBy('status', 'asc')->orderBy('filial_id', 'asc')->orderBy('city_id', 'asc')->orderBy('district_id', 'asc')->latest();

        /* Filter filials */
        $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();
        if ($filials) {
            $items->whereIn('filial_id', $filials);
        } else {
            if (request()->get('filial_id') != null) {
                $items->where('filial_id', request()->get('filial_id'));
            }
        }

        /* Filter Districts */
        $districts = auth()->guard('admin')->user()->districts->pluck('id')->all();
        if ($districts) {
            $items->whereIn('district_id', $districts);
        } else {
            if (request()->get('district_id') != null) {
                $items->where('district_id', request()->get('district_id'));
            }
        }

        if (request()->get('admin_id') != null) {
            $items->where('admin_id', request()->get('admin_id'));
        }

        if (\Request::get('start_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '>=', \Request::get('start_date'));
        }

        if (\Request::get('end_date') != null) {
            $items->where(\Request::get('date_by', 'created_at'), '<=', Carbon::createFromFormat("Y-m-d", request()->get('end_date'))->addDay()->format("Y-m-d"));
        }

        $isMainAdmin = auth()->guard('admin')->user()->hasPermission('update-packages');
        $isWarehouseman = auth()->guard('admin')->user()->hasPermission('update-cells');
        $isCourier = auth()->guard('admin')->user()->hasPermission('update-deliveries');
        $statuses = 'statusWithLabel';
        // Show for Courier
        $statuses = 'statusWithLabel';
        $type = 'general';
        // Show for Courier

        if ($isCourier && ! $isMainAdmin && ! $isWarehouseman) {
            $type = 'courier';
            $items->whereIn('status', [1, 2, 4, 5]);
            $statuses = 'statusForCourierWithLabel';
        } elseif ($isCourier && ! $isMainAdmin && $isWarehouseman) {
            $type = 'warehouse';
            $items->whereIn('status', [0, 1]);
            $statuses = 'statusForWarehouseWithLabel';
        }

        \View::share(['admin_type' => $type]);

        if (request()->get('status') != null) {
            $items->where('status', request()->get('status'));
        }

        if (\Request::get('q') != null) {
            $q = str_replace('"', '', \Request::get('q'));
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

        \View::share([
            'statuses' => $statuses,
        ]);

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

        return \Excel::download(new DeliveriesExport($items), 'deliveries_' . uniqid() . '.xlsx', 'Xlsx');
    }

    public function panelView($blade)
    {
        return 'admin.delivery.index';
    }

    public function ajax(Request $request, $id)
    {
        $used = Delivery::with(['packages'])->find($id);
        $isMainAdmin = auth()->guard('admin')->user()->hasPermission('update-packages');
        $isWarehouseman = auth()->guard('admin')->user()->hasPermission('update-cells');
        $isCourier = auth()->guard('admin')->user()->hasPermission('update-deliveries');
        if ($isCourier && ! $isMainAdmin && ! $isWarehouseman) {
            $used->admin_id = auth()->guard('admin')->user()->id;
            $used->save();
        }

        if ($request->get('name') == 'status') {

            if (trim($used->status) != trim($request->get('value'))) {

                /* Send Notification */
                // Notification::sendPackage($id, trim($request->get('value')));
            }
            /*
             *     0 => 'Pending',
                1 => 'Ready',
                2 => 'On way',
                3 => 'Delivered',
                4 => 'Wrong Address',
                5 => 'Not reached',
                6 => 'Back to Warehouse',
             *
             * */

            //if (trim($request->get('value')) > $used->status) {
            if (1) {

                if (trim($request->get('value')) == 1) {
                    foreach ($used->packages as $package) {
                        // Make in Courier status
                        if ($package->status == 2) {
                            $package->status = 7;
                            $package->save();
                        }
                    }
                }

                if (trim($request->get('value')) == 3) {
                    // Delivered and paid
                    foreach ($used->packages as $package) {
                        if (! $package->paid) {
                            Transaction::addPackage($package->id, 'CASH', 'Kuryer sifarişi');
                            $package->paid = true;
                        }

                        if ($package->status != 3) {
                            $package->status = 3;
                            $package->save();
                        }
                    }

                    if (! $used->paid) {
                        // Courier fee
                        Transaction::addDeliveryFee($used->id, $used->fee);

                        $used->paid = true;
                        $used->save();
                    }
                }

                if (trim($request->get('value')) == 6 && $used->status != 3) {
                    foreach ($used->packages as $package) {
                        // Back to Warehouse
                        if ($package->status == 7) {
                            $package->status = 2;
                            $package->save();
                        }
                    }
                }
            }
        }

        return parent::ajax($request, $id);
    }

    public function label($id)
    {
        $item = Delivery::with(['user', 'packages', 'district', 'city'])->find($id);

        if (! $item) {
            abort(404);
        }

        return view('admin.widgets.delivery_invoice', compact('item'));
    }
}

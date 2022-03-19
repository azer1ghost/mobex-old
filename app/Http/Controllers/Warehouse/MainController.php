<?php

namespace App\Http\Controllers\Warehouse;

use Alert;
use App\Exports\Warehouse\PackagesExport;
use App\Exports\Warehouse\ManifestExport;
use App\Http\Controllers\Admin\Controller;
use App\Models\EmailTemplate;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\PackageType;
use App\Models\Parcel;
use App\Models\User;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Validator;

class MainController extends Controller
{
    protected $modelName = 'Package';

    protected $view = [
        'formColumns' => 10,
        'search'      => [
            [

                'name'              => 'custom_status',
                'type'              => 'select_from_array',
                'options'           => [
                    0 => 'Not Declared',
                    1 => 'Declared',
                    2 => 'Ignored',

                ],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'Filter',
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
                'name'              => 'cell',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Cell'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-1',
                ],
            ],

            [
                'name'              => 'parcel',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Parcel'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
            ],

            [
                'name'              => 'status',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.package.status_for_warehouse',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All',
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
                    'class' => 'col-lg-2',
                ],
            ],
        ],
    ];

    protected $can = ['export' => true];

    protected $route = 'w-packages';

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
            'route'  => 'w-packages.label',
            'key'    => 'is_ready',
            'label'  => 'Label',
            'icon'   => 'windows2',
            'color'  => 'success',
            'target' => '_blank',
        ],
    ];

    protected $extraButtons = [
        [
            'key'       => 'scan',
            'route'     => 'w-parcels.create',
            'label'     => 'Use Parcelling',
            'icon'      => 'file-download',
            'color'     => 'success',
            'target'    => '_blank',
            'condition' => 'parcelling',
        ],
    ];

    protected $list = [
        'parcel'             => [
            'type'  => 'parcel',
            'label' => 'Parcel',
        ],
        'custom_status'      => [
            'type'  => 'customs',
            'label' => 'SC',
        ],
        'custom_id'          => [
            'label' => 'CWB No',
        ],
        "tracking_code"      => [
            'label'    => 'Tracking #',
            'type'     => 'editable',
            'editable' => [
                'route' => 'w-packages.ajax',
                'type'  => 'text',
            ],
        ],
        'user'               => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'warehouse_cell'     => [
            'label'    => 'Cell',
            'type'     => 'editable',
            'editable' => [
                'route' => 'w-packages.ajax',
                'type'  => 'text',
            ],
        ],
        'shipping_org_price' => [
            'label' => 'Invoice',
            'type'  => 'text',
        ],
        'weight_with_type'   => [
            'label' => 'Weight',
            'type'  => 'text',
        ],
        'number_items'       => [
            'label' => 'Items',
        ],

        'worker'     => [
            'label' => 'Worker',
        ],
        'arrived_at' => [
            'label' => 'At',
            'type'  => 'date',
        ],
    ];

    protected $fields = [
        [
            'name'    => 'show_label',
            'type'    => 'hidden',
            'default' => 1,
        ],
        [
            'name'    => 'detailed_type',
            'type'    => 'hidden',
            'default' => null,
        ],
        [
            'name'    => 'categories',
            'type'    => 'hidden',
            'default' => null,
        ],
        [
            'name'    => 'width',
            'type'    => 'hidden',
            'default' => null,
        ],
        [
            'name'    => 'height',
            'type'    => 'hidden',
            'default' => null,
        ],
        [
            'name'    => 'length',
            'type'    => 'hidden',
            'default' => null,
        ],
        [
            'name'    => 'length_type',
            'type'    => 'hidden',
            'default' => 0,
        ],
        [
            'name'              => 'tracking_code',
            'label'             => 'Tracking Code',
            'type'              => 'text',
            'short'             => true,
            'hint'              => 'Special Tracking number (optional)',
            'prefix'            => '<i class="icon-barcode2"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'attributes'        => [
                'autofocus' => true,
            ],
            'validation'        => 'nullable|string|min:5|unique:packages,tracking_code',
        ],
        [
            'label'             => 'User',
            'type'              => 'select2',
            'name'              => 'user_id',
            'attribute'         => 'full_name,customer_id',
            'model'             => 'App\Models\User',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
            'allowNull'         => true,
            'attributes'        => [
                'data-validation' => 'required',
                //'class'           => 'select2-ajax',
                'data-url'        => '/search-users',
            ],
        ],
        [
            'name'              => 'website_name',
            'label'             => 'WebSite name',
            'type'              => 'text',
            'hint'              => 'Also accept url',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'prefix'            => '<i class="icon-link"></i>',
            'validation'        => 'nullable|string',
        ],
        [
            'label'             => 'Type',
            'type'              => 'select2_from_array',
            'name'              => 'type_id',
            'options'           => [],
            'attribute'         => 'translateOrDefault_tr.name',
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
        /* [
             'name'              => 'gross_weight',
             'label'             => 'Gross Weight',
             'type'              => 'text',
             'wrapperAttributes' => [
                 'class' => 'col-md-2',
             ],
             'validation'        => 'nullable|numeric',
             'prefix'            => '<i class="icon-meter2"></i>',
             'hint'              => 'Optional',
         ],*/
        [
            'name'              => 'weight',
            'label'             => 'Weight',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'short'             => true,
            'validation'        => 'required|numeric',
            'prefix'            => '<i class="icon-meter2"></i>',
        ],
        [
            'name'              => 'weight_type',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'short'             => true,
            'optionsFromConfig' => 'ase.attributes.weight',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
            'validation'        => 'required|integer',
        ],
        [
            'name'              => 'has_liquid',
            'label'             => 'Has liquid',
            'type'              => 'checkbox',
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-1 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'has_battery',
            'label'             => 'Has Battery',
            'type'              => 'checkbox',
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-1 mt-15',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'number_items',
            'label'             => 'Items',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'shipping_amount',
            'label'             => 'Invoiced price',
            'type'              => 'text',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'                => 'shipping_amount_cur',
            'label'               => '&nbsp',
            'type'                => 'select_from_array',
            'optionsFromConfig'   => 'ase.attributes.currencies',
            'wrapperAttributes'   => [
                'class' => 'col-md-1',
            ],
            'default'             => 0,
            'default_by_relation' => 'country.currency',
            'validation'          => 'nullable|integer',
        ],
        [
            'name'              => 'print_invoice',
            'label'             => 'Print Invoice',
            'type'              => 'checkbox',
            'default'           => true,
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'check_limit',
            'label'             => 'Check Limit',
            'type'              => 'checkbox',
            'default'           => true,
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'warehouse_comment',
            'label'             => 'Note',
            'type'              => 'textarea',
            'wrapperAttributes' => [
                'class' => 'col-md-12',
            ],
            'validation'        => 'nullable|string',
        ],
    ];

    public function __construct()
    {

        parent::__construct();

        \View::share('bodyClass', 'sidebar-xs');
    }

    /**
     * Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function label($id)
    {
        $item = Package::with(['user', 'warehouse', 'country'])->whereWarehouseId($this->id())->find($id);
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if (! $item) {
            Alert::warning('Package not found');

            return redirect()->route('w-packages.index');
        }

        return view('admin.widgets.label', compact('item', 'shipper'));
    }

    /**
     * Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoiceLabel($id)
    {
        $cargoes = [
            [
                'name'   => 'ARAS',
                'number' => '0720039666',
            ],
            [
                'name'   => 'Trendyol Express',
                'number' => '8590921777',
            ],
        ];
        $item = Package::with(['user', 'warehouse', 'country'])->find($id);

        if (! $item) {
            return abort(404);
        }

        $cargo = $cargoes[rand(0, 1)];

        $item = Package::with(['user', 'warehouse', 'country'])->whereWarehouseId($this->id())->find($id);
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if (! $item) {
            Alert::warning('Package not found');

            return redirect()->route('w-packages.index');
        }

        $invoiceTemplate = ($shipper->country && strtoupper($shipper->country->code) == 'TR') ? 'invoice-inc' : 'invoice-default-inc';

        $pdf = \PDF::loadView('admin.widgets.invoice', compact('item', 'shipper', 'cargo', 'invoiceTemplate'));
        $r = $pdf->setPaper('a4')->setWarnings(false)->stream($id . '_invoice.pdf')->setCharset('UTF-8');

        return $r;
    }

    /**
     * Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoiceLabelView($id)
    {
        $cargoes = [
            [
                'name'   => 'ARAS',
                'number' => '0720039666',
            ],
            [
                'name'   => 'Trendyol Express',
                'number' => '8590921777',
            ],
        ];
        $item = Package::with(['user', 'warehouse', 'country'])->find($id);

        if (! $item) {
            return abort(404);
        }

        $cargo = $cargoes[rand(0, 1)];

        $item = Package::with(['user', 'warehouse', 'country'])->whereWarehouseId($this->id())->find($id);
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if (! $item) {
            Alert::warning('Package not found');

            return redirect()->route('w-packages.index');
        }

        $invoiceTemplate = ($shipper->country && strtoupper($shipper->country->code) == 'TR') ? 'invoice-inc-light' : 'invoice-default-inc';

        return view('admin.widgets.light_invoice', compact('item', 'shipper', 'cargo', 'invoiceTemplate'));
    }

    /**
     * PDF Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PDFLabel($id)
    {
        $item = Package::with(['user', 'warehouse', 'country'])->find($id);
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if (! $item) {
            Alert::warning('Package not found');

            return redirect()->route('w-packages.index');
        }

        $pdf = \PDF::loadView('admin.widgets.pdf_label', compact('item', 'shipper'));

        return $pdf->setPaper('a5', 'landscape')->setWarnings(false)->stream($id . '_label.pdf');
    }

    public function check()
    {
        if ($this->me()->parcelling) {
            return redirect()->route('w-parcels.index');
        }

        return redirect()->route('w-packages.index');
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexObject()
    {
        $validator = Validator::make(\Request::all(), [
            'q'            => 'nullable|string',
            'warehouse_id' => 'nullable|integer|min:0',
            'status'       => 'nullable|integer|min:0',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ['error' => 'Unexpected variables!'];
        }

        $countryId = $this->me()->country_id;

        $items = Package::with(['parcel'])->whereWarehouseId($this->id())->whereIn('status', [0, 6]);
        /*->orWhere(function ($q) use ($countryId) {
           return $q->where('country_id', $countryId)->where('status', 6);
       });*/

        if (\Request::get('q') != null) {
            $q = \Request::get('q');

            $items->where(function ($query) use ($q) {
                $query->where("tracking_code", "LIKE", "%" . $q . "%")->orWhere("website_name", "LIKE", "%" . $q . "%")->orWhere("custom_id", "LIKE", "%" . $q . "%")->orWhereHas('user', function (
                    $query
                ) use ($q) {
                    $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                });
            });
        }

        if (\Request::get('parcel') != null) {
            $items->whereHas('parcel', function (
                $query
            ) {
                $query->where('custom_id', \request()->get('parcel'));
            });
        }

        if (\Request::get('cell') != null) {
            $items->where('warehouse_cell', \Request::get('cell'));
        }

        if (\Request::get('status') != null) {
            $items->where('status', \Request::get('status'));
        }

        if (\Request::get('custom_status') != null) {
            if (in_array(\Request::get('custom_status'), [0, 1])) {
                $items->where('custom_status', \Request::get('custom_status'));
            } else {
                $items->where('status', 0)->where(function ($t) {
                    $t->whereNull('delivery_price')->orWhereNull('weight')->orWhereNull('user_id');
                });
            }
        }

        if (\Request::get('start_date') != null) {
            $items->where('created_at', '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where('created_at', '<=', Carbon::createFromFormat("Y-m-d", \Request::get('end_date'))->addDay());
        }

        $items = $items->latest();

        if (\request()->has('export') || (\request()->has('search_type') && \request()->get('search_type') == 'export') && ! \request()->has('search')) {
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
            $parcel = Parcel::where('warehouse_id', $this->id())->where('id', $items)->first();

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
        $parcel = false;

        if (request()->has('hidden_items')) {
            $items = explode(",", request()->get('hidden_items'));
        }
        if (is_string($items)) {
            $parcel = Parcel::where('warehouse_id', $this->id())->where('id', $items)->first();

            if ($parcel) {
                $items = $parcel->packages;
            } else {
                $items = [];
            }
        }

        $formats = ['Xlsx' => 'xlsx', 'Mpdf' => 'pdf'];

        if ($this->me()->allow_make_fake_invoice) {
            $type = 'Xlsx';
            $ext = 'xlsx';
        } else {
            $type = isset($formats[\request()->get('format')]) ? \request()->get('format') : 'Xlsx';
            $ext = $formats[$type];
        }

        return \Excel::download(new ManifestExport($items, null, $type, $parcel), 'manifest_' . uniqid() . '.' . $ext, $type);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function editObject($id)
    {
        $countryId = $this->me()->country_id;
        $this->changeTypes();

        return Package::where(function ($q) use ($countryId) {
            $q->where('warehouse_id', $this->id())->orWhere(function ($q) use ($countryId) {
                $q->where('country_id', $countryId)->where('status', 6);
            });
        })->whereWarehouseId($this->id())->whereId($id)->first();
    }

    public function create()
    {
        $this->changeTypes();

        return parent::create();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function deleteObject($id)
    {
        return Package::whereWarehouseId($this->id())->whereId($id)->first();
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function id()
    {
        return $this->me() ? $this->me()->getAuthIdentifier() : null;
    }

    public function me()
    {
        return \auth()->guard('worker')->user()->warehouse;
    }

    /**
     * Default attributes on create
     *
     * @return array
     */
    public function autoFill()
    {
        return [
            'warehouse_id' => $this->id(),
        ];
    }

    public function warehouseFill()
    {
        return [
            'warehouse_id' => $this->id(),
            'status'       => 0,
        ];
    }

    public function update(Request $request, $id)
    {
        $used = $this->editObject($id);

        $data = [];

        if ($used && trim($used->status) != trim($request->get('status'))) {
            $data['status'] = [
                'before' => trim($used->status),
                'after'  => trim($request->get('status')),
            ];

            /* Send Notification */
            Notification::sendPackage($id, trim($request->get('status')));
        }

        // Update smart Customs
        if ($used) {
            if ($used->weight != $request->get('weight') || $used->user_id != $request->get('user_id') || $used->shipping_amount != $request->get('shipping_amount') || $used->number_items != $request->get('number_items')) {
                $user = $used->user;
                if ($user) {
                    $user->refresh_customs = true;
                    $user->save();
                }

                if ($used->user_id != $request->get('user_id')) {
                    $newUser = User::find($request->get('user_id'));
                    $newUser->refresh_customs = true;
                    $newUser->save();
                }
            }
        }

        if (! empty($data)) {
            $log = new PackageLog();
            $log->data = json_encode($data);
            $log->warehouse_id = $this->id();
            $log->package_id = $id;
            $log->save();
        }

        return parent::update($request, $id);
    }

    public function ajax(Request $request, $id)
    {
        return parent::ajax($request, $id);
    }

    public function modal($id)
    {
        $item = Package::with(['user', 'warehouse', 'country'])->whereWarehouseId($this->id())->find($id);
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        if (! $item) {
            return null;
        }

        return view('warehouse.widgets.modal', compact('item', 'shipper'));
    }

    public function barcodeScan($code = null)
    {
        try {

            $code = $code ?: \request()->get('code');

            if (! $code) {
                return response()->json([
                    'error' => 'Cannot read the barcode!',
                ]);
            }

            $id = $this->id();

            //$checkInvoice = EmailTemplate::where('key', 'no_declaration')->where('active', 1)->first();

            // Check barcode
            $item = Package::where(function ($query) use ($code) {
                $query->where("tracking_code", "like", "%" . $code . "%")->orWhere("custom_id", $code);
            })->where(function ($query) use ($id) {
                $query->where("warehouse_id", $id)->orWhereNull("warehouse_id");
            })->first();

            if (! $item && strlen($code) >= 10) {
                $start = -1 * strlen($code) + 1;
                for ($i = $start; $i <= -8; $i++) {
                    $code = substr($code, $i);
                    $item = Package::where(function ($query) use ($code) {
                        $query->where("tracking_code", "like", "%" . $code . "%")->orWhere("custom_id", $code);
                    })->where(function ($query) use ($id) {
                        $query->where("warehouse_id", $id)->orWhereNull("warehouse_id");
                    })->first();

                    if ($item) {
                        break;
                    }
                }
            }
            $parcel = null;

            if (request()->has('scan')) {
                $parcel = Parcel::where("id", request()->get('scan'))->first();
            }

            if ($item) {

                if (request()->has('scan')) {
                    if (! $parcel) {
                        return response()->json([
                            'error' => 'Cannot find the parcel!',
                        ]);
                    }

                    if ($parcel->sent) {
                        return response()->json([
                            'error' => 'Parcel already was sent, Please create new parcel for adding the package!',
                        ]);
                    }
                    $checkParcel = \DB::table('parcel_package')->whereNotNull('parcel_id')->where('package_id', $item->id)->orderBy('parcel_id', 'asc')->first();
                    $foundParcel = $checkParcel ? Parcel::find($checkParcel->parcel_id) : false;
                    // The package has parcel
                    if ($foundParcel && $foundParcel->sent) { // before it was $foundParcel->is_real

                        return response()->json([
                            'error' => 'Package has been already added to another parcel! ' . $foundParcel->custom_id,
                        ]);
                    }

                    if ($parcel->is_real && $item->custom_status != 1) {
                        $cell = $this->detectCell($item);

                        return response()->json([
                            'error' => 'Package not declared in Smart Customs! Put back ' . $cell,
                            'sound' => 'smart_customs',
                        ]);
                    } else {
                        if ($foundParcel) {
                            $foundParcel->packages()->detach($item->id);
                        }
                    }
                }

                if (! in_array($item->status, [0, 6])) {
                    return response()->json([
                        'error' => "You cannot add the package due to status!",
                    ]);
                }
                $status = $item->status;
                $checkPrint = ($status == 0 && $item->custom_status !== null) ? false : true;
                $route = ($item->print_invoice && $item->custom_status === null) ? 'invoiceLabelView' : 'label';

                $item->warehouse_id = $this->id();
                if ($status == 6) {
                    $item->status = 0;
                }

                $item->save();

                if (auth()->guard('worker')->user()->warehouse->only_weight_input && ! $item->weight) {
                    return response()->json([
                        'add_package' => true,
                        'user'        => isset($item->user_id) ? 'yes' : 'no',
                        'cwb'         => $item->custom_id,
                    ]);
                }

                if (! $item->is_ready) {
                    return response()->json([
                        'error' => "Package is not ready. Please hold the package!",
                    ]);
                }

                /* Send Notification */
                if ($status == 6) {
                    Notification::sendPackage($item->id, '0');
                }

                if (request()->has('scan')) {

                    // Check limitation
                    $limitWeight = $this->me()->limit_weight;
                    $limitAmount = $this->me()->limit_amount;
                    $limitCurrency = $this->me()->limit_currency;
                    if ($limitAmount || $limitWeight) {
                        $limitShippingAmount = $limitAmount / getCurrencyRate($limitCurrency);
                        $totalShipInvoice = 0;
                        $totalWeight = 0;

                        foreach ($parcel->packages()->get() as $_package) {
                            $totalShipInvoice += $_package->shipping_amount / getCurrencyRate($_package->shipping_amount_cur);
                            $totalWeight += $_package->weight;
                        }

                        $totalShipInvoice += $item->shipping_amount / getCurrencyRate($item->shipping_amount_cur);
                        $totalWeight += $item->weight;

                        if ($limitAmount && $limitShippingAmount < $totalShipInvoice) {
                            return response()->json([
                                'error' => 'Parcel pass the ' . $limitAmount . config('ase.attributes.currencies')[$limitCurrency] . " limitation!",
                            ]);
                        }

                        if ($parcel->is_real && $limitWeight && $limitWeight < $totalWeight) {
                            return response()->json([
                                'error' => 'Parcel pass the ' . $limitWeight . "kg limitation!",
                            ]);
                        }
                    }
                    /* Attach new package to the parcel */
                    $parcel->packages()->syncWithoutDetaching($item->id);

                    // If a package has been added to the real parcel, remove it from the cell
                    if ($parcel && $parcel->is_real && $item->custom_status == 1) {
                        $item->warehouse_cell = null;
                        $item->save();
                    } else {
                        $this->detectCell($item);
                    }

                    unset($this->list['parcel']);

                    $printLabel = $checkPrint;
                    $checkingWaybill = ($item->reg_number != null && $parcel->is_real);
                    if ($checkingWaybill) {
                        $printLabel = true;
                        $route = 'label';
                    }

                    return response()->json([
                        'id'      => $item->id,
                        'waybill' => $checkingWaybill ? "yes" : "no",
                        'weight'  => $parcel->packages->count() . " / " . $parcel->packages->sum('weight') . "kg",
                        'sound'   => $parcel->is_real ? 'yes' : 'no',
                        'label'   => ($printLabel && $item->user_id && isset($item->warehouse->address)) ? route('w-packages.' . $route, $item->id) . "?print=true" : null,
                        //'invoice' => ($checkPrint && $item->print_invoice) ? ($item->invoice ? asset($item->invoice) : null) : null,
                        'invoice' => null,
                        'html'    => view('warehouse.widgets.single-package')->with([
                            'extraActions' => $this->extraActions,
                            'item'         => $item,
                            '_list'        => $this->list,
                            '_view'        => $this->view,
                        ])->render(),
                    ]);
                } else {
                    return response()->json([
                        'label'   => ($checkPrint && $item->user_id && isset($item->warehouse->address)) ? route('w-packages.' . $route, $item->id) . "?print=true" : null,
                        //'invoice' => ($checkPrint && $item->print_invoice) ? ($item->invoice ? asset($item->invoice) : null) : null,
                        'invoice' => null,
                        /*'package' => view('warehouse.widgets.modal-package')->with([
                            'item'  => $item,
                        ])->render(),*/
                    ]);
                }
            } else {
                if (auth()->guard('worker')->user()->warehouse->only_weight_input) {
                    if ($parcel && $parcel->is_real) {
                        return response()->json([
                            'error' => 'Package does not exist. Use fake parcel to add new package!',
                        ]);
                    } else {
                        return response()->json([
                            'add_package' => true,
                            'user'        => 'no',
                        ]);
                    }
                } else {
                    return response()->json([
                        'error' => 'Package does not exist or not ready!',
                    ]);
                }
            }
        } catch (\Exception $exception) {
            \Bugsnag::notifyException($exception);

            return response()->json([
                'error' => 'The system is busy right now. Please refresh the page!',
            ]);
        }
    }

    public function addPackage(Request $request, $id)
    {
        try {
            $parcel = Parcel::where("id", $id)->where('sent', 0)->first();
            if (! $parcel) {
                return response()->json([
                    'error' => 'Parcel already was sent, Please create new parcel for adding the package!',
                ]);
            }

            $code = \request()->get('tracking_code');
            if ($code != null) {

                $warehouseId = $this->me()->id;
                $item = Package::where(function ($query) use ($code) {
                    $query->where("tracking_code", "like", "%" . $code . "%")->orWhere("custom_id", $code);
                })->where(function ($query) use ($warehouseId) {
                    $query->where("warehouse_id", $warehouseId)->orWhereNull("warehouse_id");
                })->whereIn('status', [0, 6])->first();

                if (! $item && strlen($code) >= 10) {
                    $start = -1 * strlen($code) + 1;
                    for ($i = $start; $i <= -8; $i++) {
                        $code = substr($code, $i);
                        $item = Package::where(function ($query) use ($code) {
                            $query->where("tracking_code", "like", "%" . $code . "%")->orWhere("custom_id", $code);
                        })->where(function ($query) use ($warehouseId) {
                            $query->where("warehouse_id", $warehouseId)->orWhereNull("warehouse_id");
                        })->whereIn('status', [0, 6])->first();

                        if ($item) {
                            break;
                        }
                    }
                }
            } else {
                $item = null;
            }

            $request->request->add(['only_id' => 'yes']);

            if (starts_with($code, env('MEMBER_PREFIX_CODE'))) {
                $request->merge(['tracking_code' => null]);
            }

            $userId = ($item && $item->user_id) ? $item->user_id : $request->get('user_id');

            if ($request->get('check_limit') == '1' && ! $item) {
                $foundUser = User::find($userId);
                if ($foundUser) {
                    $spending = $foundUser->spending();
                    $weightPrice = auth()->guard('worker')->user()->warehouse->calculateDeliveryPrice($request->get('weight'));
                    $shippingAmount = $item ? $item->shipping_amount : floatval($request->get('shipping_amount'));
                    $shippingAmountCur = $item ? $item->shipping_amount_cur : floatval($request->get('shipping_amount_cur'));

                    $realPrice = round((float) $spending + (float) $weightPrice + $shippingAmount / getCurrencyRate($shippingAmountCur), 0);
                    if ($realPrice > 290) {
                        Notification::sendBoth($foundUser->id, ['user' => $foundUser->full_name], 'limit');

                        return response()->json([
                            'error' => "User is passing monthly limit. Please don't send the package! Balance will be : " . $realPrice . " USD",
                        ]);
                    }
                }
            }

            if (auth()->guard('worker')->user()->warehouse->only_weight_input && ! auth()->guard('worker')->user()->warehouse->allow_make_fake_invoice) {
                if ($item) {
                    if ($item->user_id) {
                        $request->request->add(['user_id' => $item->user_id]);
                    }
                    $this->update($request, $item->id);
                    $itemId = $item->id;
                } else {
                    $itemId = $this->store($request);
                }
            } else {
                if (auth()->guard('worker')->user()->warehouse->allow_make_fake_invoice) {

                    $detailedType = [];
                    $categories = [];
                    $amount = 0;

                    if ($request->has('types') && $request->get('types') != null && ! empty($request->get('types') && isset($request->get('types')[0]))) {
                        foreach ($request->get('types') as $key => $type) {
                            $amm = $request->get('items')[$key];
                            $amount += $amm;
                            $cat = PackageType::find($type);
                            $typeName = $cat ? $cat->translateOrDefault('en')->name : 'Diğer';

                            if ($cat) {
                                $categories[] = $cat->custom_id;
                            }

                            $detailedType[] = $amm . " x " . $typeName;
                        }

                        $request->request->add(['number_items' => $amount]);
                        $request->request->remove('types');
                        $request->request->remove('items');

                        if ($detailedType) {
                            $request->request->add(['detailed_type' => implode("; ", $detailedType)]);
                        }
                        if ($categories) {
                            $request->request->add(['categories' => implode(",", $categories)]);
                        }
                    }

                    if ($item) {
                        if ($item->user_id) {
                            $remove = [
                                'user_id',
                                'website_name',
                                'shipping_amount',
                                'shipping_amount_cur',
                                'warehouse_comment',
                                'detailed_type',
                                'categories',
                                'number_items',
                                'tracking_code',
                            ];
                            foreach ($remove as $removeIt) {
                                $request->merge([$removeIt => $item->{$removeIt}]);
                            }
                        }

                        //dd($item->user_id, $request->all());

                        $this->update($request, $item->id);
                        $itemId = $item->id;
                    } else {
                        $itemId = $this->store($request);
                    }
                } else {
                    $itemId = 0;
                }
            }


            $item = Package::find($itemId);
            //$this->detectCell($item);

            if (!is_numeric($item->country_id)) {
                $item->setAttribute('country_id',  $this->me()->country_id);
            }

            if ($item->user_id && $item->user->sent_by_post){
                $item->setAttribute('zip_code', $item->user->zip_code);
            }

            $item->save();

            /* Send Notification */
            if ($item->status == 6) {
                $rt = 1;
            }

            $parcel = \DB::table('parcel_package')->whereNotNull('parcel_id')->where('package_id', $item->id)->first();
            if ($parcel) {
                return response()->json([
                    'error' => 'Package has been already added to another parcel!',
                ]);
            }

            if ($item->shipping_amount > 0) {
                @Notification::sendPackage($item->id, '0');
            } else {
                @Notification::sendPackage($item->id, 'no_declaration');
            }

            return response()->json([
                'cwb'      => $item->custom_id,
                'web_site' => auth()->guard('worker')->user()->warehouse->web_site,
            ]);
        } catch (\Exception $exception) {
            \Bugsnag::notifyException($exception);

            return response()->json([
                'error' => 'The system is busy right now. Please refresh the page!' . $exception->getMessage(),
            ]);
        }
    }

    public function detectCell(Package $package)
    {
        if (! $package || ($package && ($package->warehouse_cell || $package->status != 0))) {
            return $package->warehouse_cell;
        }

        $foundCell = ($package->parcel && $package->parcel->first()) ? $package->parcel->first()->name : null;

        if (! $foundCell) {
            $wId = $package->warehouse_id;
            // Detect it is liquid or not
            $isLiquid = boolval($package->has_liquid);
            $isBattery = boolval($package->has_battery);
            $cellKey = $isLiquid ? 'liquid_cells' : 'main_cells';
            $cellKey = $isBattery ? 'battery_cells' : $cellKey;

            $cells = config('ase.warehouse.' . $cellKey);

            if (auth()->guard('worker')->user()->warehouse->{$cellKey}) {
                $cells = \GuzzleHttp\json_decode(auth()->guard('worker')->user()->warehouse->{$cellKey}, true);
                if (! is_array($cells)) {
                    $cells = config('ase.warehouse.' . $cellKey);
                }
            }

            $filled = [];
            // Fill cells
            foreach ($cells as $cell => $rows) {
                for ($row = 1; $row <= $rows; $row++) {
                    $filled[$cell . $row] = 0;
                }
            }

            // Weight Limit
            $weightLimit = ($package->warehouse && $package->warehouse->cell_limit_weight) ? $package->warehouse->cell_limit_weight : 16;

            // Current Cell situation
            $dbCells = Package::select([
                \DB::raw('sum(weight) as total'),
                'warehouse_cell',
            ])->whereWarehouseId($wId)->where('status', 0)->where('warehouse_cell', "!=", "")->whereNotNull('warehouse_cell')->where('has_battery', $isBattery)->where('has_liquid', $isLiquid)->groupBy('warehouse_cell')->orderBy('total', 'asc')->get();

            if ($dbCells) {
                foreach ($dbCells as $value) {
                    if (isset($filled[strtoupper($value->warehouse_cell)])) {
                        $filled[strtoupper($value->warehouse_cell)] = $value->total;
                    }
                }
            }
            $merged = $filled;

            asort($merged);

            $foundCell = array_key_first($merged);

            $otherPackageOfUser = Package::whereWarehouseId($wId)->where('status', 0)->whereNotNull('warehouse_cell')->where('has_battery', $isBattery)->where('has_liquid', $isLiquid)->whereUserId($package->user_id)->latest()->first();

            if ($otherPackageOfUser) {
                // if Yes and cell has empty place add it the the cell
                if (isset($merged[$otherPackageOfUser->warehouse_cell]) && (($merged[$otherPackageOfUser->warehouse_cell] + $package->weight) < $weightLimit)) {
                    $foundCell = $otherPackageOfUser->warehouse_cell;
                }
            }
        }

        $package->warehouse_cell = $foundCell;
        $package->save();

        return $foundCell;
    }

    public function index()
    {
        if (auth()->guard('worker')->user()->warehouse->auto_print && (! isset($_COOKIE['label_printer']) || ! isset($_COOKIE['invoice_printer']))) {
            return redirect()->route('my.edit', auth()->guard('worker')->user()->warehouse_id);
        }

        return parent::index(); // TODO: Change the autogenerated stub
    }

    public function users()
    {
        $q = request()->get('q') != null ? request()->get('q') : request()->get('term');

        $users = User::where(function ($query) use ($q) {
            $query->where("customer_id", "LIKE", "%" . $q . "%")->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
        })->take(15)->get();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                "id"   => $user->id,
                "text" => $user->full_name . " (" . $user->customer_id . ") [" . $user->spending . "]",
                "filial" => $user->filial_id,
                "has_last_orders" =>
                    $user->orders()->whereDate('created_at', '>',  now()->subDays(10))->where('status', 1)->exists() &&
                    $user->packages()->whereDate('created_at', '>',  now()->subDays(10))->where('status', 6)->exists()
                ,
            ];
        }

        return \GuzzleHttp\json_encode(["results" => $data]);
    }

    public function userPackages($id)
    {
        $packages = Package::where('user_id', $id)->whereIn('status', [6])->orderBy('status', 'desc')->get();

        $html = null;
        if ($packages->count()) {
            $html = view('warehouse.widgets.user-packages')->with([
                'packages' => $packages,
            ])->render();
        }

        return response()->json([
            'html' => $html,
        ]);
    }

    public function cells()
    {
        $item = null;
        if (\request()->get('cwb') != null) {
            $item = Package::where('warehouse_id', $this->id())->whereNotNull('warehouse_cell')->where('status', 0)->where('custom_id', \request()->get('cwb'))->first();
        }
        $cells = Package::select([
            \DB::raw('count(id) as total'),
            'warehouse_cell',
        ])->where('warehouse_id', $this->id())->whereNotNull('warehouse_cell')->where('status', 0)->groupBy('warehouse_cell')->orderBy('warehouse_cell', 'asc')->pluck('total', 'warehouse_cell')->all();

        $weights = Package::select([
            \DB::raw('sum(weight) as total'),
            'warehouse_cell',
        ])->where('warehouse_id', $this->id())->whereNotNull('warehouse_cell')->where('status', 0)->groupBy('warehouse_cell')->orderBy('warehouse_cell', 'asc')->pluck('total', 'warehouse_cell')->all();

        $declaredCells = Package::select([
            \DB::raw('count(id) as total'),
            'warehouse_cell',
        ])->where('warehouse_id', $this->id())->where('custom_status', 1)->whereNotNull('warehouse_cell')->where('status', 0)->groupBy('warehouse_cell')->orderBy('warehouse_cell', 'asc')->pluck('total', 'warehouse_cell')->all();

        return view('warehouse.parcel.cells', compact('cells', 'declaredCells', 'item', 'weights'));
    }

    public function statistics()
    {
        $packagesByDay = Package::setEagerLoads([])->select(\DB::raw('DATE_FORMAT(arrived_at, "%m - %d (%b)") AS month'), \DB::raw('count(id) as total'))->where('arrived_at', '>=', Carbon::now()->subDays(60))->whereNotNull('arrived_at')->where('warehouse_id', $this->id())->orderBy('month', 'asc')->groupBy('month')->get();

        $total = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->where('warehouse_id', $this->id())->whereHas('parcel')->where('status', 0)->first();
        $declared = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->where('warehouse_id', $this->id())->where('status', 0)->where('custom_status', 1)->first();
        $totalToday = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->where('warehouse_id', $this->id())->whereHas('parcel')->whereNotNull('weight')->whereNotNull('user_id')->whereIn('status', [
            0,
            1,
        ])->where('arrived_at', '>=', Carbon::today())->first();
        $totalTodayDeclared = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->where('warehouse_id', $this->id())->whereHas('parcel')->whereNotNull('weight')->where('custom_status', 1)->whereNotNull('user_id')->whereIn('status', [
            0,
            1,
        ])->where('arrived_at', '>=', Carbon::today())->first();

        $totalWorker = Package::select(\DB::raw("count(id) AS total"), 'worker_id')->where('arrived_at', '>=', Carbon::today())->where('warehouse_id', $this->id())->whereHas('parcel')->where('status', 0)->whereNotNull('worker_id')->groupBy('worker_id')->get();

        $workers = [];
        foreach ($totalWorker as $data) {
            $worker = Worker::find($data->worker_id);
            if ($worker) {
                $workers[] = [
                    'name'  => $worker->name,
                    'count' => $data->total,
                ];
            }
        }

        return view('warehouse.parcel.stats', compact('total', 'declared', 'totalToday', 'totalTodayDeclared', 'workers', 'packagesByDay'));
    }

    public function changeTypes()
    {
        $lang = strtolower($this->me()->country->code) == 'tr' ? 'tr' : 'en';

        $categoriesObj = PackageType::with('children')->whereNull('parent_id')->whereNotNull('custom_id')->get();

        $categories = [];
        foreach ($categoriesObj as $category) {
            $categories[$category->id] = $category->translateOrDefault($lang)->name;
            if ($category->children) {
                foreach ($category->children as $sub_category) {
                    $categories[$sub_category->id] = "  -  " . $sub_category->translateOrDefault($lang)->name . " (" . $category->translateOrDefault($lang)->name . ")";
                }
            }
        }
        $this->fields[10]['options'] = $categories;
        \View::share('fields', $this->fields);
    }
}
